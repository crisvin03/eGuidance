<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Concern;
use App\Models\Appointment;
use App\Models\ConcernCategory;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $concerns = Concern::where('student_id', $user->id)->get();
        $appointments = Appointment::where('student_id', $user->id)
            ->with('counselor')
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        return view('student.dashboard', compact('concerns', 'appointments'));
    }

    public function resources()
    {
        return view('student.resources');
    }

    public function kamustaka()
    {
        return view('student.kamustaka');
    }

    public function storeKamustaka(Request $request)
    {
        $mood = $request->input('mood');

        return match($mood) {
            'okay'     => redirect()->route('student.resources.index')->with('kamusta_message', 'Glad to hear you\'re okay! Here are some resources to keep you feeling great.'),
            'not_sure' => redirect()->route('student.appointments.create')->with('kamusta_message', 'It\'s okay to feel unsure. Consider booking a counseling session — talking helps.'),
            'not_okay' => redirect()->route('student.kamustaka.support')->with('kamusta_mood', 'not_okay'),
            default    => redirect()->route('student.dashboard'),
        };
    }

    public function kamustakaSupportPage()
    {
        return view('student.kamustaka-support');
    }

    public function createConcern()
    {
        $categories = ConcernCategory::where('is_active', true)->get();
        return view('student.concerns.create', compact('categories'));
    }

    public function storeConcern(Request $request)
    {
        $request->validate([
            'category_id'  => 'required|exists:concern_categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'is_anonymous' => 'boolean',
            'attachment'   => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:5120',
        ]);

        $attachmentPath = null;
        $attachmentName = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentName = $file->getClientOriginalName();
            $attachmentPath = $file->store('concern-attachments', 'public');
        }

        Concern::create([
            'student_id'      => Auth::id(),
            'category_id'     => $request->category_id,
            'title'           => $request->title,
            'description'     => $request->description,
            'is_anonymous'    => $request->boolean('is_anonymous', false),
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', 'Concern submitted successfully.');
    }

    public function myConcerns(Request $request)
    {
        $query = Concern::where('student_id', Auth::id())->with('category');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        $concerns = $query->orderBy('created_at', 'desc')->paginate(15)->appends($request->query());
        $categories = ConcernCategory::where('is_active', true)->get();
        
        return view('student.concerns.index', compact('concerns', 'categories'));
    }

    public function showConcern(Concern $concern)
    {
        // Ensure the concern belongs to the authenticated student
        if ($concern->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this concern.');
        }

        // Load the concern with relationships
        $concern->load(['category', 'appointments' => function($query) {
            $query->where('status', '!=', 'cancelled')->orderBy('appointment_date', 'desc');
        }]);

        return view('student.concerns.show', compact('concern'));
    }

    public function createAppointment()
    {
        $counselors = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'counselor'))->where('is_active', true)->get();
        return view('student.appointments.create', compact('counselors'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        Appointment::create([
            'student_id' => Auth::id(),
            'counselor_id' => $request->counselor_id,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', 'Appointment scheduled successfully.');
    }

    public function myAppointments(Request $request)
    {
        $query = Appointment::where('student_id', Auth::id())->with('counselor');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('counselor', fn($c) => $c->where('name', 'like', "%{$search}%"))
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $appointments = $query->orderBy('appointment_date', 'desc')->paginate(15)->appends($request->query());
        
        return view('student.appointments.index', compact('appointments'));
    }

    public function showAppointment(Appointment $appointment)
    {
        if ($appointment->student_id !== Auth::id()) {
            abort(403);
        }

        $appointment->load('counselor');

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'appointment' => $appointment
            ]);
        }

        return view('student.appointments.show', compact('appointment'));
    }

    public function rescheduleAppointment(Request $request, Appointment $appointment)
    {
        if ($appointment->student_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($appointment->status, ['scheduled', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'This appointment cannot be rescheduled.'
            ], 422);
        }

        try {
            $request->validate([
                'appointment_date' => 'required|date',
            ]);

            $newDate = \Carbon\Carbon::parse($request->appointment_date);

            if ($newDate->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The appointment date must be in the future.'
                ], 422);
            }

            $appointment->update([
                'appointment_date' => $newDate,
                'status' => 'scheduled',
                'notes' => 'Rescheduled by student. ' . ($appointment->notes ?? ''),
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment rescheduled successfully.',
                    'appointment' => $appointment->fresh()->load('counselor')
                ]);
            }

            return redirect()->route('student.appointments.index')
                ->with('success', 'Appointment rescheduled successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reschedule: ' . $e->getMessage()
            ], 500);
        }
    }

    public function cancelAppointment(Request $request, Appointment $appointment)
    {
        if ($appointment->student_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($appointment->status, ['scheduled', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'This appointment cannot be cancelled.'
            ], 422);
        }

        try {
            $appointment->update([
                'status' => 'cancelled',
                'cancellation_reason' => $request->reason ?? 'Cancelled by student.',
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment cancelled successfully.'
                ]);
            }

            return redirect()->route('student.appointments.index')
                ->with('success', 'Appointment cancelled successfully.');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function formGenerator()
    {
        return view('student.forms.index');
    }

    public function virtualId()
    {
        $user = Auth::user();
        return view('student.virtual-id', compact('user'));
    }

    // ========================================
    // SPILL THE TEA (Enhanced Concerns)
    // ========================================
    
    public function spillTea()
    {
        $categories = ConcernCategory::where('is_active', true)->get();
        return view('student.spill-tea.create', compact('categories'));
    }

    public function spillTeaIndex(Request $request)
    {
        return $this->myConcerns($request);
    }

    public function spillTeaCreate()
    {
        $categories = ConcernCategory::where('is_active', true)->get();
        return view('student.spill-tea.create', compact('categories'));
    }

    public function spillTeaStore(Request $request)
    {
        return $this->storeConcern($request);
    }

    public function spillTeaShow(Concern $concern)
    {
        if ($concern->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this concern.');
        }

        $concern->load(['category', 'appointments' => function($query) {
            $query->where('status', '!=', 'cancelled')->orderBy('appointment_date', 'desc');
        }]);

        return view('student.spill-tea.show', compact('concern'));
    }

    // ========================================
    // CONNECT WITH ATE/KUYA (Enhanced Appointments + Messaging)
    // ========================================
    
    public function connect()
    {
        $user = Auth::user();
        
        // Get available counselors
        $counselors = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'counselor'))
            ->where('is_active', true)
            ->get();
        
        // Get upcoming appointments
        $upcomingAppointments = Appointment::where('student_id', $user->id)
            ->where('appointment_date', '>', now())
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->with('counselor')
            ->orderBy('appointment_date', 'asc')
            ->limit(3)
            ->get();
        
        // Get recent appointments
        $recentAppointments = Appointment::where('student_id', $user->id)
            ->where('status', 'completed')
            ->with('counselor')
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();
        
        return view('student.connect.index', compact('counselors', 'upcomingAppointments', 'recentAppointments'));
    }

    public function connectCounselors()
    {
        $counselors = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'counselor'))
            ->where('is_active', true)
            ->get();
        
        return view('student.connect.counselors', compact('counselors'));
    }

    public function chat(\App\Models\User $user)
    {
        // Verify the user is a counselor or teacher
        if (!$user->hasRole(['counselor', 'teacher'])) {
            abort(403, 'You can only message counselors and teachers.');
        }
        
        // TODO: Implement messaging system
        return view('student.connect.chat', compact('user'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:2000',
        ]);
        
        // TODO: Implement message storage
        // For now, create as a concern
        
        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully. This feature is coming soon!'
        ]);
    }

    public function connectAppointments()
    {
        return $this->myAppointments(request());
    }

    public function bookAppointment(Request $request)
    {
        return $this->storeAppointment($request);
    }

    // ========================================
    // MIND CHECK (Mental Health Assessments)
    // ========================================
    
    public function mindCheck()
    {
        $user = Auth::user();
        
        // Get recent assessments
        $recentAssessments = \App\Models\MentalHealthAssessment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Count assessments by type
        $assessmentCounts = \App\Models\MentalHealthAssessment::where('user_id', $user->id)
            ->selectRaw('assessment_type, count(*) as count')
            ->groupBy('assessment_type')
            ->pluck('count', 'assessment_type');
        
        return view('student.mind-check.index', compact('recentAssessments', 'assessmentCounts'));
    }

    public function headssAssessment()
    {
        return view('student.mind-check.headss');
    }

    public function storeHeadss(Request $request)
    {
        $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'required|string',
        ]);

        // Calculate risk level based on responses
        $responses = $request->responses;
        $riskLevel = $this->calculateHeadssRiskLevel($responses);

        $assessment = \App\Models\MentalHealthAssessment::create([
            'user_id' => Auth::id(),
            'assessment_type' => 'headss',
            'responses' => $responses,
            'score' => null, // HEADSS doesn't have a numeric score
            'risk_level' => $riskLevel,
            'counselor_notified' => $riskLevel === 'high',
        ]);

        // Notify counselor if high risk
        if ($riskLevel === 'high') {
            // TODO: Send notification to counselor
        }

        return redirect()->route('student.mind-check.submitted')
            ->with('success', 'Assessment submitted successfully for counselor review.');
    }

    public function gad7Assessment()
    {
        return view('student.mind-check.gad7');
    }

    public function storeGad7(Request $request)
    {
        $request->validate([
            'responses' => 'required|array|size:7',
            'responses.*' => 'required|integer|min:0|max:3',
        ]);

        // Calculate GAD-7 score (0-21)
        $score = array_sum($request->responses);
        
        // Determine anxiety level
        $riskLevel = match(true) {
            $score >= 15 => 'high',
            $score >= 10 => 'moderate',
            $score >= 5 => 'mild',
            default => 'low'
        };

        $assessment = \App\Models\MentalHealthAssessment::create([
            'user_id' => Auth::id(),
            'assessment_type' => 'gad7',
            'responses' => $request->responses,
            'score' => $score,
            'risk_level' => $riskLevel,
            'counselor_notified' => in_array($riskLevel, ['high', 'moderate']),
        ]);

        if (in_array($riskLevel, ['high', 'moderate'])) {
            // TODO: Send notification to counselor
        }

        return redirect()->route('student.mind-check.submitted')
            ->with('success', 'GAD-7 assessment submitted successfully for counselor review.');
    }

    public function phq9Assessment()
    {
        return view('student.mind-check.phq9');
    }

    public function storePhq9(Request $request)
    {
        $request->validate([
            'responses' => 'required|array|size:9',
            'responses.*' => 'required|integer|min:0|max:3',
        ]);

        // Calculate PHQ-9 score (0-27)
        $score = array_sum($request->responses);
        
        // Determine depression severity
        $riskLevel = match(true) {
            $score >= 20 => 'high',
            $score >= 15 => 'moderately-high',
            $score >= 10 => 'moderate',
            $score >= 5 => 'mild',
            default => 'low'
        };

        $assessment = \App\Models\MentalHealthAssessment::create([
            'user_id' => Auth::id(),
            'assessment_type' => 'phq9',
            'responses' => $request->responses,
            'score' => $score,
            'risk_level' => $riskLevel,
            'counselor_notified' => in_array($riskLevel, ['high', 'moderately-high']),
        ]);

        if (in_array($riskLevel, ['high', 'moderately-high'])) {
            // TODO: Send notification to counselor
        }

        return redirect()->route('student.mind-check.submitted')
            ->with('success', 'PHQ-9 assessment submitted successfully for counselor review.');
    }

    public function mindCheckResults(\App\Models\MentalHealthAssessment $assessment)
    {
        if ($assessment->user_id !== Auth::id()) {
            abort(403);
        }

        return view('student.mind-check.results', compact('assessment'));
    }

    public function mindCheckSubmitted()
    {
        return view('student.mind-check.submitted');
    }

    public function mindCheckHistory()
    {
        $userId = Auth::id();
        
        $assessments = \App\Models\MentalHealthAssessment::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Calculate statistics
        $totalCount = \App\Models\MentalHealthAssessment::where('user_id', $userId)->count();
        $headssCount = \App\Models\MentalHealthAssessment::where('user_id', $userId)
            ->where('assessment_type', 'headss')->count();
        $gad7Count = \App\Models\MentalHealthAssessment::where('user_id', $userId)
            ->where('assessment_type', 'gad7')->count();
        $phq9Count = \App\Models\MentalHealthAssessment::where('user_id', $userId)
            ->where('assessment_type', 'phq9')->count();
        
        // Get latest assessment
        $latestAssessment = \App\Models\MentalHealthAssessment::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('student.mind-check.history', compact(
            'assessments',
            'totalCount',
            'headssCount',
            'gad7Count',
            'phq9Count',
            'latestAssessment'
        ));
    }

    private function calculateHeadssRiskLevel(array $responses): string
    {
        // Count concerning responses
        $concernCount = 0;
        foreach ($responses as $response) {
            if (str_contains(strtolower($response), 'yes') || 
                str_contains(strtolower($response), 'concern') ||
                str_contains(strtolower($response), 'problem') ||
                str_contains(strtolower($response), 'difficult')) {
                $concernCount++;
            }
        }

        return match(true) {
            $concernCount >= 5 => 'high',
            $concernCount >= 3 => 'moderate',
            default => 'low'
        };
    }

    // ========================================
    // NEW HERE - Learner Reintegration Clearance
    // ========================================
    
    public function newHere()
    {
        $userId = Auth::id();
        
        // Get user's reintegration clearance submissions
        $submissions = \App\Models\StudentFormSubmission::where('student_id', $userId)
            ->where('form_type', 'reintegration_clearance')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('student.new-here.index', compact('submissions'));
    }
    
    public function newHereForm()
    {
        return view('student.new-here.form');
    }
    
    public function storeNewHere(Request $request)
    {
        $validated = $request->validate([
            'learner_name' => 'required|string|max:255',
            'grade_section' => 'required|string|max:255',
            'reason' => 'required|string|max:500',
            'return_date' => 'required|date',
            'checklist' => 'nullable|array',
            'remarks' => 'nullable|array',
            'support' => 'nullable|array',
            'other_support' => 'nullable|string|max:255',
            'additional_comments' => 'nullable|string|max:1000',
        ]);
        
        // Prepare form data
        $formData = [
            'learner_name' => $validated['learner_name'],
            'grade_section' => $validated['grade_section'],
            'reason' => $validated['reason'],
            'return_date' => $validated['return_date'],
            'checklist' => $validated['checklist'] ?? [],
            'remarks' => $validated['remarks'] ?? [],
            'support' => $validated['support'] ?? [],
            'other_support' => $validated['other_support'] ?? null,
            'additional_comments' => $validated['additional_comments'] ?? null,
        ];
        
        // Create submission
        \App\Models\StudentFormSubmission::create([
            'student_id' => Auth::id(),
            'form_type' => 'reintegration_clearance',
            'form_title' => 'Learner Reintegration Clearance',
            'form_data' => $formData,
            'status' => 'submitted',
        ]);
        
        return redirect()->route('student.new-here')
            ->with('success', 'Your Learner Reintegration Clearance form has been submitted successfully! A counselor will review it soon.');
    }
    
    public function viewNewHere($id)
    {
        $submission = \App\Models\StudentFormSubmission::where('student_id', Auth::id())
            ->where('id', $id)
            ->where('form_type', 'reintegration_clearance')
            ->firstOrFail();
        
        return view('student.new-here.view', compact('submission'));
    }

    public function resourcesIndex()
    {
        // Get student's own submissions
        $mySubmissions = \App\Models\StudentSubmission::where('student_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Get featured submissions (approved and featured)
        $featuredSubmissions = \App\Models\StudentSubmission::with('student')
            ->where('status', 'approved')
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('student.resources.index', compact('mySubmissions', 'featuredSubmissions'));
    }

    public function realTalk()
    {
        return redirect()->route('student.resources.index', ['section' => 'real-talk']);
    }

    public function unfiltered()
    {
        return redirect()->route('student.resources.index', ['section' => 'unfiltered']);
    }

    public function findPeople()
    {
        return redirect()->route('student.resources.index', ['section' => 'find-people']);
    }

    public function exitCheck()
    {
        return redirect()->route('student.resources.index', ['section' => 'exit-check']);
    }

    public function futureMe()
    {
        return redirect()->route('student.resources.index', ['section' => 'future-me']);
    }

    // ─── Student Forms ─────────────────────────────────────────────────────────

    public function formsIndex()
    {
        $submissions = \App\Models\StudentFormSubmission::where('student_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('student.forms.index', compact('submissions'));
    }

    public function showFormType($type)
    {
        $formTypes = ['exit-survey', 'personal-inventory', 'clearance-return'];
        
        if (!in_array($type, $formTypes)) {
            abort(404);
        }

        return view('student.forms.' . $type);
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'form_type' => 'required|in:exit_survey,personal_inventory,clearance_return',
            'form_data' => 'required|array',
        ]);

        $formTitles = [
            'exit_survey' => 'Curriculum Exit Survey (Annex B)',
            'personal_inventory' => 'Personal Inventory Form (Annex C)',
            'clearance_return' => 'Clearance to Return (Annex D)',
        ];

        \App\Models\StudentFormSubmission::create([
            'student_id' => Auth::id(),
            'form_type' => $request->form_type,
            'form_title' => $formTitles[$request->form_type],
            'form_data' => $request->form_data,
            'status' => 'submitted',
        ]);

        return redirect()->route('student.forms.index')
            ->with('success', 'Form submitted successfully! The counselor will review it soon.');
    }

    public function viewSubmission(\App\Models\StudentFormSubmission $submission)
    {
        if ($submission->student_id != Auth::id()) {
            abort(403);
        }

        return view('student.forms.view', compact('submission'));
    }

    // ─── Creative Submissions ─────────────────────────────────────────────────

    public function submissionsIndex()
    {
        $submissions = \App\Models\StudentSubmission::where('student_id', Auth::id())
            ->with('reviewer')
            ->latest()
            ->paginate(10);
            
        return view('student.submissions.index', compact('submissions'));
    }

    public function createSubmission()
    {
        return view('student.submissions.create');
    }

    public function storeSubmission(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:poetry,artwork,photography',
            'content' => 'required_if:type,poetry|nullable|string',
            'file' => 'required_unless:type,poetry|nullable|file|mimes:jpg,jpeg,png,gif|max:5120', // 5MB max
            'is_anonymous' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'student_id' => Auth::id(),
            'status' => 'pending',
            'is_anonymous' => $request->has('is_anonymous') ? true : false,
        ];

        // Handle text content for poetry
        if ($request->type === 'poetry') {
            $data['content'] = $request->content;
        }

        // Handle file upload for artwork/photography
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('student-submissions', $fileName, 'public');
            
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $filePath;
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_size'] = $file->getSize();
        }

        \App\Models\StudentSubmission::create($data);

        return redirect()->route('student.resources.index')
            ->with('success', 'Your submission has been sent! It will be reviewed by our counselors.');
    }

    public function showSubmission(\App\Models\StudentSubmission $submission)
    {
        if ($submission->student_id != Auth::id()) {
            abort(403);
        }

        $submission->load('reviewer');
        return view('student.submissions.show', compact('submission'));
    }

    public function mySubmissions()
    {
        return $this->submissionsIndex();
    }

    public function destroySubmission(\App\Models\StudentSubmission $submission)
    {
        if ($submission->student_id != Auth::id()) {
            abort(403);
        }

        // Only allow deletion of pending submissions
        if ($submission->status !== 'pending') {
            return redirect()->back()->with('error', 'You can only delete pending submissions.');
        }

        // Delete file if exists
        if ($submission->hasFile() && \Storage::disk('public')->exists($submission->file_path)) {
            \Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();

        return redirect()->route('student.submissions.index')
            ->with('success', 'Submission deleted successfully!');
    }
}
