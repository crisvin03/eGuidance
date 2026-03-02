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

    public function myConcerns()
    {
        $concerns = Concern::where('student_id', Auth::id())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('student.concerns.index', compact('concerns'));
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
        $counselors = \App\Models\User::where('role_id', 2)->where('is_active', true)->get();
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

    public function myAppointments()
    {
        $appointments = Appointment::where('student_id', Auth::id())
            ->with('counselor')
            ->orderBy('appointment_date', 'desc')
            ->get();
        
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
}
