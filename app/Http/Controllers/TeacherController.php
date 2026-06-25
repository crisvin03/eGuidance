<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IncidentReport;
use App\Models\StudentReferral;
use App\Models\InterventionGuide;
use App\Models\Appointment;
use App\Models\User;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:teacher']);
    }

    // ─── Dashboard ────────────────────────────────────────────────────────────

    public function dashboard()
    {
        $teacher = Auth::user();
        $totalReports   = IncidentReport::where('teacher_id', $teacher->id)->count();
        $pendingReports = IncidentReport::where('teacher_id', $teacher->id)->where('status', 'pending')->count();
        $totalReferrals = StudentReferral::where('teacher_id', $teacher->id)->count();
        $pendingReferrals = StudentReferral::where('teacher_id', $teacher->id)->where('status', 'pending')->count();

        $recentReports = IncidentReport::where('teacher_id', $teacher->id)
            ->orderByDesc('created_at')->take(5)->get();
        $recentReferrals = StudentReferral::where('teacher_id', $teacher->id)
            ->orderByDesc('created_at')->take(5)->get();

        return view('teacher.dashboard', compact(
            'totalReports', 'pendingReports',
            'totalReferrals', 'pendingReferrals',
            'recentReports', 'recentReferrals'
        ));
    }

    // ─── Incident Reports ─────────────────────────────────────────────────────

    public function incidentReports(Request $request)
    {
        $query = IncidentReport::where('teacher_id', Auth::id());
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('case_number', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%")
                  ->orWhere('grade_section', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('urgency')) {
            $query->where('urgency_level', $request->urgency);
        }
        
        $reports = $query->orderByDesc('created_at')->paginate(15)->appends($request->query());
        return view('teacher.incident-reports.index', compact('reports'));
    }

    public function createIncidentReport()
    {
        return view('teacher.incident-reports.create');
    }

    public function storeIncidentReport(Request $request)
    {
        $data = $request->validate([
            'student_name'           => 'required|string|max:255',
            'grade_section'          => 'required|string|max:100',
            'date_of_referral'       => 'required|date',
            'incident_category'      => 'required|in:bullying,behavioral_concern,mental_health,academic_risk,child_protection,classroom_incident',
            'concern_type'           => 'required|in:academic,emotional_mental,social_peer,family,behavioral,relationships_personal,safety_protection,career_future,counseling_support,other',
            'incident_description'   => 'required|string',
            'initial_intervention'   => 'nullable|string',
            'parent_guardian_name'   => 'nullable|string|max:255',
            'parent_guardian_contact'=> 'nullable|string|max:50',
            'referred_by_name'       => 'required|string|max:255',
            'referred_by_designation'=> 'required|string|max:255',
            'urgency_level'          => 'required|in:low,moderate,high',
            'attachment'             => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $attachmentPath = null;
        $attachmentName = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentName = $file->getClientOriginalName();
            $attachmentPath = $file->store('incident-attachments', 'public');
        }

        IncidentReport::create([
            'case_number'            => IncidentReport::generateCaseNumber(),
            'teacher_id'             => Auth::id(),
            'student_name'           => $data['student_name'],
            'grade_section'          => $data['grade_section'],
            'date_of_referral'       => $data['date_of_referral'],
            'incident_category'      => $data['incident_category'],
            'concern_type'           => $data['concern_type'],
            'incident_description'   => $data['incident_description'],
            'initial_intervention'   => $data['initial_intervention'],
            'parent_guardian_name'   => $data['parent_guardian_name'],
            'parent_guardian_contact'=> $data['parent_guardian_contact'],
            'referred_by_name'       => $data['referred_by_name'],
            'referred_by_designation'=> $data['referred_by_designation'],
            'urgency_level'          => $data['urgency_level'],
            'attachment_path'        => $attachmentPath,
            'attachment_name'        => $attachmentName,
            'status'                 => 'pending',
        ]);

        return redirect()->route('teacher.incident-reports.index')
            ->with('success', 'Incident report submitted successfully. The CARE Center has been notified.');
    }

    public function showIncidentReport(IncidentReport $incidentReport)
    {
        if ($incidentReport->teacher_id !== Auth::id()) abort(403);
        return view('teacher.incident-reports.show', compact('incidentReport'));
    }

    // ─── Student Referrals ────────────────────────────────────────────────────

    public function referrals(Request $request)
    {
        $query = StudentReferral::where('teacher_id', Auth::id());
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('referral_number', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%")
                  ->orWhere('grade_section', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $referrals = $query->orderByDesc('created_at')->paginate(15)->appends($request->query());
        return view('teacher.referrals.index', compact('referrals'));
    }

    public function createReferral()
    {
        return view('teacher.referrals.create');
    }

    public function storeReferral(Request $request)
    {
        $data = $request->validate([
            'student_name'       => 'required|string|max:255',
            'grade_section'      => 'required|string|max:100',
            'referral_category'  => 'required|string|max:255',
            'reason_for_referral'=> 'required|string',
            'observed_behavior'  => 'nullable|string',
            'actions_taken'      => 'nullable|string',
            'preferred_followup' => 'nullable|string|max:255',
            'additional_notes'   => 'nullable|string',
        ]);

        StudentReferral::create([
            'referral_number'    => StudentReferral::generateReferralNumber(),
            'teacher_id'         => Auth::id(),
            'student_name'       => $data['student_name'],
            'grade_section'      => $data['grade_section'],
            'referral_category'  => $data['referral_category'],
            'reason_for_referral'=> $data['reason_for_referral'],
            'observed_behavior'  => $data['observed_behavior'],
            'actions_taken'      => $data['actions_taken'],
            'preferred_followup' => $data['preferred_followup'],
            'additional_notes'   => $data['additional_notes'],
            'status'             => 'pending',
        ]);

        return redirect()->route('teacher.referrals.index')
            ->with('success', 'Student referral submitted successfully.');
    }

    public function showReferral(StudentReferral $studentReferral)
    {
        if ($studentReferral->teacher_id !== Auth::id()) abort(403);
        return view('teacher.referrals.show', compact('studentReferral'));
    }

    // ─── Form Generator ───────────────────────────────────────────────────────

    public function formGenerator()
    {
        return view('teacher.forms.index');
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'form_type'    => 'required|string',
            'form_title'   => 'required|string',
            'student_name' => 'nullable|string|max:255',
            'grade_section'=> 'nullable|string|max:100',
            'form_data'    => 'required',
        ]);

        \App\Models\TeacherFormSubmission::create([
            'teacher_id'    => Auth::id(),
            'form_type'     => $request->form_type,
            'form_title'    => $request->form_title,
            'student_name'  => $request->student_name,
            'grade_section' => $request->grade_section,
            'form_data'     => is_array($request->form_data)
                                ? $request->form_data
                                : json_decode($request->form_data, true) ?? [],
            'status'        => 'submitted',
        ]);

        return response()->json(['success' => true, 'message' => 'Form sent to counselor successfully.']);
    }

    public function myFormSubmissions(Request $request)
    {
        $query = \App\Models\TeacherFormSubmission::where('teacher_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('form_title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('form_type')) {
            $query->where('form_type', $request->form_type);
        }

        $submissions = $query->orderByDesc('created_at')->paginate(10)->appends($request->query());

        return view('teacher.forms.submissions', compact('submissions'));
    }

    public function showFormSubmission(\App\Models\TeacherFormSubmission $submission)
    {
        if ($submission->teacher_id !== Auth::id()) abort(403);
        return view('teacher.forms.show', compact('submission'));
    }

    // ─── Case Tracking ────────────────────────────────────────────────────────

    public function caseTracking(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');
        
        $reportsQuery = IncidentReport::where('teacher_id', Auth::id());
        $referralsQuery = StudentReferral::where('teacher_id', Auth::id());
        
        if ($search) {
            $reportsQuery->where(function($q) use ($search) {
                $q->where('case_number', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%");
            });
            $referralsQuery->where(function($q) use ($search) {
                $q->where('referral_number', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%");
            });
        }

        $reports = $reportsQuery->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')->paginate(15, ['*'], 'reports_page')->appends($request->query());

        $referrals = $referralsQuery->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')->paginate(15, ['*'], 'referrals_page')->appends($request->query());

        return view('teacher.case-tracking.index', compact('reports', 'referrals', 'status', 'search'));
    }

    // ─── Intervention Guides ──────────────────────────────────────────────────

    public function interventionGuides(Request $request)
    {
        $search   = $request->get('search');
        $category = $request->get('category');

        $guides = InterventionGuide::where('is_active', true)
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"))
            ->when($category, fn($q) => $q->where('category', $category))
            ->orderBy('category')->orderBy('title')
            ->get();

        $categories = [
            'adult_learner'     => 'Adult-to-Learner Protection Protocol',
            'learner_learner'   => 'Learner-to-Learner Protection Protocol',
            'learner_community' => 'Learner-to-Community Concern Protocol',
            'panic_attack'      => 'Panic Attack Classroom Response Guide',
            'referral_guide'    => 'Referral vs Classroom Management Guide',
            'career'            => 'Career Landas Toolkits',
        ];

        return view('teacher.intervention-guides.index', compact('guides', 'categories', 'search', 'category'));
    }

    // ─── Talk to Counselor ────────────────────────────────────────────────────

    public function talkToCounselor()
    {
        $counselors = User::whereHas('role', fn($q) => $q->where('name', 'counselor'))->where('is_active', true)->get();
        $appointments = Appointment::where('student_id', Auth::id())
            ->with('counselor')
            ->orderByDesc('appointment_date')
            ->get();
        return view('teacher.talk-to-counselor', compact('counselors', 'appointments'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'counselor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
        ]);

        Appointment::create([
            'student_id' => Auth::id(),
            'counselor_id' => $request->counselor_id,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        return redirect()->route('teacher.talk-to-counselor')
            ->with('success', 'Appointment scheduled successfully. The counselor will be notified.');
    }

    // ─── Virtual ID ───────────────────────────────────────────────────────────

    public function virtualId()
    {
        return view('teacher.virtual-id');
    }
}
