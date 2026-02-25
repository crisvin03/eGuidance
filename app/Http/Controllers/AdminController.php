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

    private function xlsStyles(): string
    {
        return '<style>
body{font-family:Calibri,Arial,sans-serif;font-size:11pt;}
.report-title{font-size:15pt;font-weight:bold;color:#fff;background:#1a5276;padding:6px 10px;}
.report-meta{font-size:10pt;color:#555;background:#d6eaf8;padding:3px 10px;}
.section-header{font-size:11pt;font-weight:bold;color:#fff;background:#2e86c1;padding:5px 8px;}
.col-header{font-weight:bold;background:#1a5276;color:#fff;padding:5px 8px;border:1px solid #154360;white-space:nowrap;}
.data-row td{padding:4px 8px;border:1px solid #d5d8dc;vertical-align:top;white-space:nowrap;}
.data-row:nth-child(even) td{background:#eaf4fb;}
.data-row:nth-child(odd) td{background:#fff;}
.b-sub{background:#aed6f1;color:#1a5276;padding:2px 6px;border-radius:3px;}
.b-rev{background:#fdebd0;color:#784212;padding:2px 6px;border-radius:3px;}
.b-sch{background:#d5f5e3;color:#1e8449;padding:2px 6px;border-radius:3px;}
.b-res{background:#d5f5e3;color:#1e8449;padding:2px 6px;border-radius:3px;}
.b-con{background:#d6eaf8;color:#1a5276;padding:2px 6px;border-radius:3px;}
.b-com{background:#d5f5e3;color:#1e8449;padding:2px 6px;border-radius:3px;}
.b-can{background:#fadbd8;color:#922b21;padding:2px 6px;border-radius:3px;}
.b-act{background:#d5f5e3;color:#1e8449;padding:2px 6px;border-radius:3px;}
.b-ina{background:#f2f3f4;color:#717d7e;padding:2px 6px;border-radius:3px;}
.b-src{background:#e8daef;color:#6c3483;padding:2px 6px;border-radius:3px;}
.b-dir{background:#f2f3f4;color:#555;padding:2px 6px;border-radius:3px;}
.ml{font-weight:bold;padding:4px 8px;border:1px solid #d5d8dc;background:#eaf4fb;}
.mv{padding:4px 8px;border:1px solid #d5d8dc;}
table{border-collapse:collapse;width:100%;}
</style>';
    }

    public function exportConcerns()
    {
        $concerns = Concern::with(['student', 'category'])->orderBy('created_at', 'desc')->get();
        $styles   = $this->xlsStyles();
        $generated = now()->format('F d, Y h:i A');
        $total     = $concerns->count();

        $statusMap = [
            'submitted'    => ['Submitted',    'b-sub'],
            'under_review' => ['Under Review', 'b-rev'],
            'scheduled'    => ['Scheduled',    'b-sch'],
            'resolved'     => ['Resolved',     'b-res'],
        ];

        $html  = "<html><head><meta charset='UTF-8'>{$styles}</head><body><table>";
        $html .= "<tr><td colspan='8' class='report-title'>SIGMA eGuidance Portal &mdash; Student Concerns Report</td></tr>";
        $html .= "<tr><td colspan='8' class='report-meta'>Generated: {$generated}</td></tr>";
        $html .= "<tr><td colspan='8' class='report-meta'>Total Records: {$total}</td></tr>";
        $html .= "<tr><td colspan='8'></td></tr>";
        $html .= "<tr><td class='col-header'>#</td><td class='col-header'>Student Name</td><td class='col-header'>Category</td><td class='col-header'>Title</td><td class='col-header'>Status</td><td class='col-header'>Anonymous</td><td class='col-header'>Counseling Date</td><td class='col-header'>Date Submitted</td></tr>";

        $i = 1;
        foreach ($concerns as $c) {
            [$slabel, $sclass] = $statusMap[$c->status] ?? [ucfirst($c->status), 'b-sub'];
            $student  = htmlspecialchars($c->is_anonymous ? 'Anonymous' : ($c->student->name ?? 'N/A'));
            $category = htmlspecialchars($c->category->name ?? 'N/A');
            $title    = htmlspecialchars($c->title);
            $anon     = $c->is_anonymous ? 'Yes' : 'No';
            $cDate    = $c->counseling_date ? \Carbon\Carbon::parse($c->counseling_date)->format('M d, Y h:i A') : '<em style="color:#aaa">Not Scheduled</em>';
            $created  = $c->created_at->format('M d, Y h:i A');
            $html .= "<tr class='data-row'><td>{$i}</td><td>{$student}</td><td>{$category}</td><td>{$title}</td><td><span class='{$sclass}'>{$slabel}</span></td><td>{$anon}</td><td>{$cDate}</td><td>{$created}</td></tr>";
            $i++;
        }

        $html .= "</table></body></html>";

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="concerns_' . now()->format('Y-m-d') . '.xls"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }

    public function exportAppointments()
    {
        $appointments = Appointment::with(['student', 'counselor'])->orderBy('appointment_date', 'desc')->get();
        $styles    = $this->xlsStyles();
        $generated = now()->format('F d, Y h:i A');
        $total     = $appointments->count();

        $statusMap = [
            'scheduled' => ['Scheduled', 'b-sch'],
            'confirmed' => ['Confirmed', 'b-con'],
            'completed' => ['Completed', 'b-com'],
            'cancelled' => ['Cancelled', 'b-can'],
        ];

        $html  = "<html><head><meta charset='UTF-8'>{$styles}</head><body><table>";
        $html .= "<tr><td colspan='9' class='report-title'>SIGMA eGuidance Portal &mdash; Appointments Report</td></tr>";
        $html .= "<tr><td colspan='9' class='report-meta'>Generated: {$generated}</td></tr>";
        $html .= "<tr><td colspan='9' class='report-meta'>Total Records: {$total}</td></tr>";
        $html .= "<tr><td colspan='9'></td></tr>";
        $html .= "<tr><td class='col-header'>#</td><td class='col-header'>Student Name</td><td class='col-header'>Counselor Name</td><td class='col-header'>Appointment Date &amp; Time</td><td class='col-header'>Status</td><td class='col-header'>Source</td><td class='col-header'>Notes</td><td class='col-header'>Cancellation Reason</td><td class='col-header'>Date Created</td></tr>";

        $i = 1;
        foreach ($appointments as $a) {
            [$slabel, $sclass] = $statusMap[$a->status] ?? [ucfirst($a->status), 'b-sch'];
            $source  = $a->concern_id ? "<span class='b-src'>From Concern</span>" : "<span class='b-dir'>Direct Booking</span>";
            $html .= "<tr class='data-row'>";
            $html .= "<td>{$i}</td>";
            $html .= "<td>" . htmlspecialchars($a->student->name ?? 'N/A') . "</td>";
            $html .= "<td>" . htmlspecialchars($a->counselor->name ?? 'N/A') . "</td>";
            $html .= "<td>" . $a->appointment_date->format('M d, Y h:i A') . "</td>";
            $html .= "<td><span class='{$sclass}'>{$slabel}</span></td>";
            $html .= "<td>{$source}</td>";
            $html .= "<td>" . htmlspecialchars($a->notes ?? '') . "</td>";
            $html .= "<td>" . htmlspecialchars($a->cancellation_reason ?? '') . "</td>";
            $html .= "<td>" . $a->created_at->format('M d, Y h:i A') . "</td>";
            $html .= "</tr>";
            $i++;
        }

        $html .= "</table></body></html>";

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="appointments_' . now()->format('Y-m-d') . '.xls"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }

    public function exportUsers()
    {
        $users     = User::with('role')->orderBy('role_id')->orderBy('name')->get();
        $styles    = $this->xlsStyles();
        $generated = now()->format('F d, Y h:i A');
        $total     = $users->count();

        $roleColors = [
            'admin'     => 'background:#fadbd8;color:#922b21;padding:2px 6px;border-radius:3px;',
            'counselor' => 'background:#d5f5e3;color:#1e8449;padding:2px 6px;border-radius:3px;',
            'student'   => 'background:#d6eaf8;color:#1a5276;padding:2px 6px;border-radius:3px;',
        ];

        $html  = "<html><head><meta charset='UTF-8'>{$styles}</head><body><table>";
        $html .= "<tr><td colspan='9' class='report-title'>SIGMA eGuidance Portal &mdash; User Accounts Report</td></tr>";
        $html .= "<tr><td colspan='9' class='report-meta'>Generated: {$generated}</td></tr>";
        $html .= "<tr><td colspan='9' class='report-meta'>Total Records: {$total}</td></tr>";
        $html .= "<tr><td colspan='9'></td></tr>";
        $html .= "<tr><td class='col-header'>#</td><td class='col-header'>Full Name</td><td class='col-header'>Email Address</td><td class='col-header'>Role</td><td class='col-header'>Student ID</td><td class='col-header'>Phone Number</td><td class='col-header'>Gender</td><td class='col-header'>Account Status</td><td class='col-header'>Date Joined</td></tr>";

        $i = 1;
        foreach ($users as $u) {
            $roleName  = strtolower($u->role->name ?? 'student');
            $roleStyle = $roleColors[$roleName] ?? $roleColors['student'];
            $status    = $u->is_active ? "<span class='b-act'>Active</span>" : "<span class='b-ina'>Inactive</span>";
            $html .= "<tr class='data-row'>";
            $html .= "<td>{$i}</td>";
            $html .= "<td>" . htmlspecialchars($u->name) . "</td>";
            $html .= "<td>" . htmlspecialchars($u->email) . "</td>";
            $html .= "<td><span style='{$roleStyle}'>" . ucfirst($roleName) . "</span></td>";
            $html .= "<td>" . htmlspecialchars($u->student_id ?? '') . "</td>";
            $html .= "<td>" . htmlspecialchars($u->phone ?? '') . "</td>";
            $html .= "<td>" . ($u->gender ? ucfirst($u->gender) : '') . "</td>";
            $html .= "<td>{$status}</td>";
            $html .= "<td>" . $u->created_at->format('M d, Y h:i A') . "</td>";
            $html .= "</tr>";
            $i++;
        }

        $html .= "</table></body></html>";

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="users_' . now()->format('Y-m-d') . '.xls"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }

    public function exportFullReport()
    {
        $filename = 'full_report_' . now()->format('Y-m-d') . '.xls';
        $headers = [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $styles            = $this->xlsStyles();
        $generated         = now()->format('F d, Y  h:i A');
        $totalConcerns     = Concern::count();
        $resolvedConcerns  = Concern::where('status', 'resolved')->count();
        $totalAppointments = Appointment::count();
        $completedAppts    = Appointment::where('status', 'completed')->count();
        $resolutionRate    = $totalConcerns > 0 ? round(($resolvedConcerns / $totalConcerns) * 100, 1) : 0;
        $completionRate    = $totalAppointments > 0 ? round(($completedAppts / $totalAppointments) * 100, 1) : 0;

        $byCategory = Concern::join('concern_categories', 'concerns.category_id', '=', 'concern_categories.id')
            ->selectRaw('concern_categories.name, count(*) as count')
            ->groupBy('concern_categories.name')->get();

        $concernsByMonth = Concern::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->groupBy('month')->orderBy('month', 'desc')->take(12)->get();

        $apptsByMonth = Appointment::selectRaw('DATE_FORMAT(appointment_date, "%Y-%m") as month, count(*) as count')
            ->groupBy('month')->orderBy('month', 'desc')->take(12)->get();

        $html  = "<html><head><meta charset='UTF-8'>{$styles}</head><body>";

        // Cover
        $html .= "<table>";
        $html .= "<tr><td colspan='3' class='report-title'>SIGMA eGuidance Portal &mdash; Full System Report</td></tr>";
        $html .= "<tr><td colspan='3' class='report-meta'>Generated: {$generated}</td></tr>";
        $html .= "</table><br>";

        // Section 1 — Summary
        $html .= "<table>";
        $html .= "<tr><td colspan='2' class='section-header'>SECTION 1 &mdash; SYSTEM SUMMARY</td></tr>";
        $html .= "<tr><td class='col-header'>Metric</td><td class='col-header'>Value</td></tr>";
        $metrics = [
            'Total Users'            => User::count(),
            'Total Students'         => User::where('role_id', 1)->count(),
            'Total Counselors'       => User::where('role_id', 2)->count(),
            'Total Concerns'         => $totalConcerns,
            'Resolved Concerns'      => $resolvedConcerns,
            'Resolution Rate'        => $resolutionRate . '%',
            'Total Appointments'     => $totalAppointments,
            'Completed Appointments' => $completedAppts,
            'Completion Rate'        => $completionRate . '%',
        ];
        foreach ($metrics as $label => $value) {
            $html .= "<tr class='data-row'><td class='metric-label'>{$label}</td><td class='metric-value'>{$value}</td></tr>";
        }
        $html .= "</table><br>";

        // Section 2 — Concerns by Category
        $html .= "<table>";
        $html .= "<tr><td colspan='3' class='section-header'>SECTION 2 &mdash; CONCERNS BY CATEGORY</td></tr>";
        $html .= "<tr><td class='col-header'>Category</td><td class='col-header'>Total</td><td class='col-header'>Percentage</td></tr>";
        foreach ($byCategory as $row) {
            $pct   = $totalConcerns > 0 ? round(($row->count / $totalConcerns) * 100, 1) : 0;
            $bar   = str_repeat('█', (int)($pct / 5)) . ' ' . $pct . '%';
            $html .= "<tr class='data-row'><td>" . htmlspecialchars($row->name) . "</td><td>{$row->count}</td><td style='font-family:monospace'>{$bar}</td></tr>";
        }
        $html .= "</table><br>";

        // Section 3 — Monthly Concerns
        $html .= "<table>";
        $html .= "<tr><td colspan='2' class='section-header'>SECTION 3 &mdash; MONTHLY CONCERNS (Last 12 Months)</td></tr>";
        $html .= "<tr><td class='col-header'>Month</td><td class='col-header'>Total Concerns</td></tr>";
        foreach ($concernsByMonth as $row) {
            $month = \Carbon\Carbon::parse($row->month . '-01')->format('F Y');
            $html .= "<tr class='data-row'><td>{$month}</td><td>{$row->count}</td></tr>";
        }
        $html .= "</table><br>";

        // Section 4 — Monthly Appointments
        $html .= "<table>";
        $html .= "<tr><td colspan='2' class='section-header'>SECTION 4 &mdash; MONTHLY APPOINTMENTS (Last 12 Months)</td></tr>";
        $html .= "<tr><td class='col-header'>Month</td><td class='col-header'>Total Appointments</td></tr>";
        foreach ($apptsByMonth as $row) {
            $month = \Carbon\Carbon::parse($row->month . '-01')->format('F Y');
            $html .= "<tr class='data-row'><td>{$month}</td><td>{$row->count}</td></tr>";
        }
        $html .= "</table><br>";

        // Section 5 — Appointment Status Breakdown
        $statusColors = ['scheduled'=>'badge-scheduled','confirmed'=>'badge-confirmed','completed'=>'badge-completed','cancelled'=>'badge-cancelled'];
        $html .= "<table>";
        $html .= "<tr><td colspan='2' class='section-header'>SECTION 5 &mdash; APPOINTMENT STATUS BREAKDOWN</td></tr>";
        $html .= "<tr><td class='col-header'>Status</td><td class='col-header'>Count</td></tr>";
        foreach (['scheduled','confirmed','completed','cancelled'] as $status) {
            $count = Appointment::where('status', $status)->count();
            $cls   = $statusColors[$status];
            $html .= "<tr class='data-row'><td><span class='{$cls}'>" . ucfirst($status) . "</span></td><td>{$count}</td></tr>";
        }
        $html .= "</table>";

        $html .= "</body></html>";

        return response($html, 200, $headers);
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
