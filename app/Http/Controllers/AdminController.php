<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Concern;
use App\Models\Appointment;
use App\Models\ConcernCategory;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalStudents = User::where('role_id', 1)->count();
        $totalCounselors = User::where('role_id', 2)->count();
        $totalConcerns = Concern::count();
        $pendingConcerns = Concern::where('status', 'submitted')->count();
        $resolvedConcerns = Concern::where('status', 'resolved')->count();
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalStudents', 'totalCounselors', 
            'totalConcerns', 'pendingConcerns', 'resolvedConcerns',
            'totalAppointments', 'todayAppointments'
        ));
    }

    public function users()
    {
        $users = User::with('role')->orderBy('role_id')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'student_id' => 'nullable|string|unique:users,student_id',
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'student_id' => $request->student_id,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'student_id' => 'nullable|string|unique:users,student_id,' . $user->id,
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'student_id' => $request->student_id,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'required|string|min:8|confirmed']);
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function deactivateUser(User $user)
    {
        $user->update(['is_active' => false]);
        return redirect()->back()->with('success', 'User deactivated successfully.');
    }

    public function activateUser(User $user)
    {
        $user->update(['is_active' => true]);
        return redirect()->back()->with('success', 'User activated successfully.');
    }

    public function categories()
    {
        $categories = ConcernCategory::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:concern_categories',
            'description' => 'nullable|string',
        ]);

        ConcernCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, ConcernCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:concern_categories,name,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function reports()
    {
        $concernsByCategory = Concern::join('concern_categories', 'concerns.category_id', '=', 'concern_categories.id')
            ->selectRaw('concern_categories.name, count(*) as count')
            ->groupBy('concern_categories.name')
            ->get();

        $concernsByMonth = Concern::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        $appointmentsByMonth = Appointment::selectRaw('DATE_FORMAT(appointment_date, "%Y-%m") as month, count(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        return view('admin.reports.index', compact('concernsByCategory', 'concernsByMonth', 'appointmentsByMonth'));
    }
}
