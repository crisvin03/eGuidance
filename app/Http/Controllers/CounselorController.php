<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Concern;
use App\Models\Appointment;
use App\Models\SessionNote;

class CounselorController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $pendingConcerns = Concern::where('status', 'submitted')->count();
        $todayAppointments = Appointment::where('counselor_id', $user->id)
            ->whereDate('appointment_date', today())
            ->count();
        $upcomingAppointments = Appointment::where('counselor_id', $user->id)
            ->where('appointment_date', '>', now())
            ->orderBy('appointment_date')
            ->take(5)
            ->with('student')
            ->get();
        
        return view('counselor.dashboard', compact('pendingConcerns', 'todayAppointments', 'upcomingAppointments'));
    }

    public function concerns()
    {
        $concerns = Concern::with(['student', 'category'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('counselor.concerns.index', compact('concerns'));
    }

    public function showConcern(Concern $concern)
    {
        $concern->load(['student', 'category']);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'concern' => $concern
            ]);
        }

        return redirect()->route('counselor.concerns.index');
    }

    public function respondToConcern(Request $request, Concern $concern)
    {
        $request->validate([
            'response' => 'required|string',
            'status' => 'required|in:under_review,scheduled,resolved',
            'counseling_date' => 'nullable|date|required_if:status,scheduled',
        ]);

        try {
            $concern->update([
                'counselor_response' => $request->response,
                'status' => $request->status,
                'counseling_date' => $request->counseling_date,
                'resolved_at' => $request->status === 'resolved' ? now() : null,
            ]);

            // Create appointment if status is scheduled and date is provided
            if ($request->status === 'scheduled' && $request->counseling_date) {
                // Check if appointment already exists for this concern
                $existingAppointment = Appointment::where('concern_id', $concern->id)
                    ->where('status', '!=', 'cancelled')
                    ->first();

                if (!$existingAppointment) {
                    Appointment::create([
                        'student_id' => $concern->student_id,
                        'counselor_id' => Auth::id(),
                        'concern_id' => $concern->id,
                        'appointment_date' => $request->counseling_date,
                        'status' => 'scheduled',
                        'notes' => 'Appointment scheduled for concern: ' . $concern->title
                    ]);
                } else {
                    // Update existing appointment
                    $existingAppointment->update([
                        'appointment_date' => $request->counseling_date,
                        'status' => 'scheduled',
                        'notes' => 'Appointment rescheduled for concern: ' . $concern->title
                    ]);
                }
            }

            // Return JSON response for AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Response submitted successfully.',
                    'concern' => $concern->fresh()
                ]);
            }

            return redirect()->back()->with('success', 'Response submitted successfully.');
        } catch (\Exception $e) {
            // Return JSON error for AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to submit response: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to submit response. Please try again.');
        }
    }

    public function appointments()
    {
        $appointments = Appointment::where('counselor_id', Auth::id())
            ->with(['student', 'concern'])
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        return view('counselor.appointments.index', compact('appointments'));
    }

    public function showAppointment(Appointment $appointment)
    {
        if ($appointment->counselor_id != Auth::id()) {
            abort(403);
        }

        $appointment->load(['student', 'concern.category', 'sessionNotes']);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'appointment' => $appointment
            ]);
        }
        
        return view('counselor.appointments.show', compact('appointment'));
    }

    public function respondToAppointment(Request $request, Appointment $appointment)
    {
        if ($appointment->counselor_id != Auth::id()) {
            abort(403);
        }

        try {
            $request->validate([
                'status' => 'required|in:confirmed,completed,cancelled',
                'cancellation_reason' => 'required_if:status,cancelled|nullable|string',
                'notes' => 'nullable|string',
            ]);

            $appointment->update([
                'status' => $request->status,
                'cancellation_reason' => $request->cancellation_reason,
            ]);

            // Create session note if completed
            if ($request->status === 'completed' && $request->notes) {
                SessionNote::create([
                    'appointment_id' => $appointment->id,
                    'counselor_id' => Auth::id(),
                    'notes' => $request->notes,
                    'session_type' => 'follow_up',
                ]);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment updated successfully.'
                ]);
            }

            return redirect()->back()->with('success', 'Appointment updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to update appointment.');
        }
    }

    public function createSessionNote(Appointment $appointment)
    {
        if ($appointment->counselor_id != Auth::id()) {
            abort(403);
        }

        return view('counselor.session-notes.create', compact('appointment'));
    }

    public function storeSessionNote(Request $request, Appointment $appointment)
    {
        if ($appointment->counselor_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'notes' => 'required|string',
            'session_type' => 'required|in:initial,follow_up,crisis,group',
            'recommendations' => 'nullable|string',
            'is_confidential' => 'boolean',
        ]);

        SessionNote::create([
            'appointment_id' => $appointment->id,
            'counselor_id' => Auth::id(),
            'notes' => $request->notes,
            'session_type' => $request->session_type,
            'recommendations' => $request->recommendations,
            'is_confidential' => $request->boolean('is_confidential', true),
        ]);

        return redirect()->route('counselor.appointments.show', $appointment)
            ->with('success', 'Session note created successfully.');
    }
}
