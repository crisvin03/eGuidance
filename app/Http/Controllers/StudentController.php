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

    public function createConcern()
    {
        $categories = ConcernCategory::where('is_active', true)->get();
        return view('student.concerns.create', compact('categories'));
    }

    public function storeConcern(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:concern_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_anonymous' => 'boolean',
        ]);

        Concern::create([
            'student_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'is_anonymous' => $request->boolean('is_anonymous', false),
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

        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'concern' => $concern
            ]);
        }

        // Return view for direct access (if needed)
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
}
