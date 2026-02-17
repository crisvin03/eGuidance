@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
@php
    // Calculate last month's data for accurate percentage changes
    $lastMonthStart = now()->subMonth()->startOfMonth();
    $lastMonthEnd = now()->subMonth()->endOfMonth();
    
    $lastMonthConcerns = App\Models\Concern::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
    $thisMonthConcerns = App\Models\Concern::whereBetween('created_at', [now()->startOfMonth(), now()])->count();
    
    $lastMonthAppointments = App\Models\Appointment::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
    $thisMonthAppointments = App\Models\Appointment::whereBetween('created_at', [now()->startOfMonth(), now()])->count();
    
    $lastMonthResolved = App\Models\Concern::where('status', 'resolved')->whereBetween('updated_at', [$lastMonthStart, $lastMonthEnd])->count();
    $thisMonthResolved = App\Models\Concern::where('status', 'resolved')->whereBetween('updated_at', [now()->startOfMonth(), now()])->count();
    
    // Calculate percentages
    $concernsChange = $lastMonthConcerns > 0 ? round((($thisMonthConcerns - $lastMonthConcerns) / $lastMonthConcerns) * 100, 1) : 0;
    $appointmentsChange = $lastMonthAppointments > 0 ? round((($thisMonthAppointments - $lastMonthAppointments) / $lastMonthAppointments) * 100, 1) : 0;
    $resolvedChange = $lastMonthResolved > 0 ? round((($thisMonthResolved - $lastMonthResolved) / $lastMonthResolved) * 100, 1) : 0;
    
    // Today's new pending concerns
    $todayPending = App\Models\Concern::where('status', 'submitted')->whereDate('created_at', today())->count();
@endphp

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-chat-dots"></i>
        </div>
        <div class="stat-value">{{ $totalConcerns }}</div>
        <div class="stat-label">Total Concerns</div>
        <div class="stat-change {{ $concernsChange >= 0 ? 'positive' : 'negative' }}">
            <i class="bi bi-arrow-{{ $concernsChange >= 0 ? 'up' : 'down' }}"></i>
            {{ abs($concernsChange) }}% from last month
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-clock-history"></i>
        </div>
        <div class="stat-value">{{ $pendingConcerns }}</div>
        <div class="stat-label">Pending Concerns</div>
        <div class="stat-change {{ $todayPending > 0 ? 'negative' : 'positive' }}">
            <i class="bi bi-arrow-up"></i>
            {{ $todayPending }} new today
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-value">{{ $resolvedConcerns }}</div>
        <div class="stat-label">Resolved Concerns</div>
        <div class="stat-change {{ $resolvedChange >= 0 ? 'positive' : 'negative' }}">
            <i class="bi bi-arrow-{{ $resolvedChange >= 0 ? 'up' : 'down' }}"></i>
            {{ abs($resolvedChange) }}% from last month
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-calendar3"></i>
        </div>
        <div class="stat-value">{{ $totalAppointments }}</div>
        <div class="stat-label">Total Appointments</div>
        <div class="stat-change {{ $appointmentsChange >= 0 ? 'positive' : 'negative' }}">
            <i class="bi bi-arrow-{{ $appointmentsChange >= 0 ? 'up' : 'down' }}"></i>
            {{ abs($appointmentsChange) }}% from last month
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                        <i class="bi bi-people"></i>
                        Manage Users
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="bi bi-tags"></i>
                        Manage Categories
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                        <i class="bi bi-graph-up"></i>
                        View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">System Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <p><strong>System Status:</strong></p>
                        <p><strong>Database:</strong></p>
                        <p><strong>Last Backup:</strong></p>
                        <p><strong>Version:</strong></p>
                    </div>
                    <div class="col-6">
                        <p><span class="badge badge-success">Online</span></p>
                        <p><span class="badge badge-success">Connected</span></p>
                        <p>{{ now()->format('M d, Y') }}</p>
                        <p>1.0.0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title">Recent Activity</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    JD
                                </div>
                                <span>John Doe</span>
                            </div>
                        </td>
                        <td>Submitted new concern</td>
                        <td>{{ now()->subMinutes(30)->format('M d, h:i A') }}</td>
                        <td><span class="badge badge-warning">Pending</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    AS
                                </div>
                                <span>Admin User</span>
                            </div>
                        </td>
                        <td>Created new user account</td>
                        <td>{{ now()->subHours(2)->format('M d, h:i A') }}</td>
                        <td><span class="badge badge-success">Completed</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    SJ
                                </div>
                                <span>Sarah Johnson</span>
                            </div>
                        </td>
                        <td>Scheduled appointment</td>
                        <td>{{ now()->subHours(4)->format('M d, h:i A') }}</td>
                        <td><span class="badge badge-info">Scheduled</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
