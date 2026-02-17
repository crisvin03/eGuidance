@extends('layouts.dashboard')

@section('title', 'Counselor Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-clock-history"></i>
        </div>
        <div class="stat-value">{{ $pendingConcerns }}</div>
        <div class="stat-label">Pending Concerns</div>
        <div class="stat-change negative">
            <i class="bi bi-arrow-up"></i>
            {{ $pendingConcerns }} need attention
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-calendar-check"></i>
        </div>
        <div class="stat-value">{{ $todayAppointments }}</div>
        <div class="stat-label">Today's Appointments</div>
        <div class="stat-change positive">
            <i class="bi bi-calendar"></i>
            {{ $todayAppointments > 0 ? 'Scheduled today' : 'No appointments' }}
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-people"></i>
        </div>
        <div class="stat-value">{{ $upcomingAppointments->count() }}</div>
        <div class="stat-label">Upcoming Sessions</div>
        <div class="stat-change positive">
            <i class="bi bi-arrow-up"></i>
            Next 7 days
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-graph-up"></i>
        </div>
        <div class="stat-value">85%</div>
        <div class="stat-label">Response Rate</div>
        <div class="stat-change positive">
            <i class="bi bi-arrow-up"></i>
            Above average
        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="row">
    <!-- Upcoming Appointments -->
    <div class="col-lg-8 col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="card-title">Upcoming Appointments</h5>
                <a href="{{ route('counselor.appointments.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-list"></i>
                    View All
                </a>
            </div>
            <div class="card-body">
                @if($upcomingAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th class="d-none-tablet">Date & Time</th>
                                    <th class="d-none-lg">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingAppointments as $appointment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="user-avatar">
                                                    {{ strtoupper(substr($appointment->student->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $appointment->student->name }}</div>
                                                    <small class="text-muted d-none-tablet">
                                                        {{ $appointment->appointment_date->format('M d, h:i A') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none-tablet">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-calendar3 text-primary"></i>
                                                <span>{{ $appointment->appointment_date->format('M d, h:i A') }}</span>
                                            </div>
                                        </td>
                                        <td class="d-none-lg">
                                            @if($appointment->appointment_date > now())
                                                <span class="badge badge-info">Scheduled</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('counselor.appointments.show', $appointment) }}" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                    <span class="d-none-mobile"> View</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x" style="font-size: 3rem; color: #cbd5e1;"></i>
                        <h5 class="mt-3 text-muted">No Upcoming Appointments</h5>
                        <p class="text-muted">You don't have any appointments scheduled</p>
                        <a href="{{ route('counselor.appointments.index') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Schedule Appointment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Quick Actions Sidebar -->
    <div class="col-lg-4 col-md-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('counselor.concerns.index') }}" class="btn btn-primary d-flex align-items-center justify-content-between">
                        <span>
                            <i class="bi bi-chat-dots me-2"></i>
                            View Concerns
                        </span>
                        @if($pendingConcerns > 0)
                            <span class="badge bg-danger">{{ $pendingConcerns }}</span>
                        @endif
                    </a>
                    <a href="{{ route('counselor.appointments.index') }}" class="btn btn-secondary">
                        <i class="bi bi-calendar3 me-2"></i>
                        Manage Appointments
                    </a>
                    <a href="#" class="btn btn-secondary">
                        <i class="bi bi-file-text me-2"></i>
                        Session Notes
                    </a>
                    <a href="#" class="btn btn-secondary">
                        <i class="bi bi-graph-up me-2"></i>
                        View Reports
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Counselor Stats Card -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title">Your Stats</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="stat-value-sm">{{ $pendingConcerns }}</div>
                        <div class="stat-label-sm">Pending</div>
                    </div>
                    <div class="col-6">
                        <div class="stat-value-sm">{{ $todayAppointments }}</div>
                        <div class="stat-label-sm">Today</div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Response Rate</span>
                    <span class="badge badge-success">85%</span>
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th class="d-none-tablet">Activity</th>
                        <th class="d-none-lg">Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar">
                                    JD
                                </div>
                                <span>John Doe</span>
                            </div>
                        </td>
                        <td class="d-none-tablet">Submitted new concern</td>
                        <td class="d-none-lg">{{ now()->subMinutes(45)->format('M d, h:i A') }}</td>
                        <td><span class="badge badge-warning">Pending</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar">
                                    MJ
                                </div>
                                <span>Mary Johnson</span>
                            </div>
                        </td>
                        <td class="d-none-tablet">Completed session</td>
                        <td class="d-none-lg">{{ now()->subHours(2)->format('M d, h:i A') }}</td>
                        <td><span class="badge badge-success">Completed</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar">
                                    RS
                                </div>
                                <span>Robert Smith</span>
                            </div>
                        </td>
                        <td class="d-none-tablet">Scheduled follow-up</td>
                        <td class="d-none-lg">{{ now()->subHours(3)->format('M d, h:i A') }}</td>
                        <td><span class="badge badge-info">Scheduled</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Enhanced Mobile Responsive Styles for Counselor Dashboard */

/* Extra Small Devices (Phones: 320px - 575px) */
@media (max-width: 575px) {
    .stats-grid {
        grid-template-columns: 1fr !important;
        gap: 0.75rem !important;
        margin-bottom: 1rem !important;
    }
    
    .stat-card {
        padding: 0.75rem !important;
        min-height: auto !important;
    }
    
    .stat-value {
        font-size: 1.25rem !important;
        margin-bottom: 0.25rem !important;
    }
    
    .stat-label {
        font-size: 0.75rem !important;
        margin-bottom: 0.25rem !important;
    }
    
    .stat-change {
        font-size: 0.7rem !important;
    }
    
    .stat-icon {
        width: 32px !important;
        height: 32px !important;
        font-size: 0.875rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .card {
        margin-bottom: 1rem !important;
    }
    
    .card-header {
        padding: 0.75rem 1rem !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 0.5rem !important;
    }
    
    .card-body {
        padding: 0.75rem !important;
    }
    
    .card-title {
        font-size: 1rem !important;
        margin-bottom: 0.25rem !important;
    }
    
    .table th,
    .table td {
        padding: 0.375rem 0.5rem !important;
        font-size: 0.75rem !important;
        border: none !important;
    }
    
    .table thead th {
        font-weight: 600 !important;
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    
    .user-avatar {
        width: 24px !important;
        height: 24px !important;
        font-size: 0.625rem !important;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.625rem !important;
    }
    
    .badge {
        font-size: 0.625rem !important;
        padding: 0.25rem 0.5rem !important;
    }
    
    .d-none-mobile {
        display: none !important;
    }
    
    .row {
        margin: 0 !important;
    }
    
    .row > div {
        padding: 0 0.5rem !important;
        margin-bottom: 0.75rem !important;
    }
    
    /* Compact layout for mobile */
    .table-responsive {
        margin: 0 -0.5rem !important;
    }
    
    /* Better touch targets */
    .btn {
        min-height: 32px !important;
    }
    
    /* Reduce spacing */
    .mt-4 {
        margin-top: 1rem !important;
    }
    
    .mt-3 {
        margin-top: 0.75rem !important;
    }
    
    .py-5 {
        padding: 1.5rem 0 !important;
    }
}

/* Small Devices (Large Phones: 576px - 767px) */
@media (min-width: 576px) and (max-width: 767px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1rem !important;
    }
    
    .stat-card {
        padding: 1rem !important;
    }
    
    .stat-value {
        font-size: 1.5rem !important;
    }
    
    .stat-icon {
        width: 36px !important;
        height: 36px !important;
        font-size: 1rem !important;
    }
    
    .d-none-tablet {
        display: none !important;
    }
    
    .card-header {
        padding: 1rem 1.25rem !important;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .table th,
    .table td {
        padding: 0.5rem !important;
        font-size: 0.8125rem !important;
    }
    
    .user-avatar {
        width: 28px !important;
        height: 28px !important;
        font-size: 0.6875rem !important;
    }
}

/* Medium Devices (Tablets: 768px - 991px) */
@media (min-width: 768px) and (max-width: 991px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1.25rem !important;
    }
    
    .stat-card {
        padding: 1.25rem !important;
    }
    
    .d-none-md {
        display: none !important;
    }
    
    .table th,
    .table td {
        padding: 0.75rem !important;
        font-size: 0.875rem !important;
    }
    
    .user-avatar {
        width: 32px !important;
        height: 32px !important;
        font-size: 0.75rem !important;
    }
}

/* Large Devices (Desktops: 992px - 1199px) */
@media (min-width: 992px) and (max-width: 1199px) {
    .stats-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 1.5rem !important;
    }
    
    .d-none-lg {
        display: none !important;
    }
}

/* Extra Large Devices (Large Desktops: 1200px and up) */
@media (min-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 1.5rem !important;
    }
}

/* Ensure proper table scrolling on all mobile devices */
@media (max-width: 767px) {
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0 -1rem;
        padding: 0 1rem;
    }
    
    /* Hide scrollbar on mobile for cleaner look */
    .table-responsive::-webkit-scrollbar {
        display: none;
    }
    
    .table-responsive {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
}

/* Optimize for very small screens */
@media (max-width: 380px) {
    .stat-value {
        font-size: 1.125rem !important;
    }
    
    .stat-label {
        font-size: 0.6875rem !important;
    }
    
    .stat-change {
        font-size: 0.625rem !important;
    }
    
    .card-title {
        font-size: 0.9375rem !important;
    }
    
    .btn-sm {
        padding: 0.1875rem 0.375rem !important;
        font-size: 0.5625rem !important;
    }
}

/* Landscape orientation adjustments */
@media (max-height: 600px) and (orientation: landscape) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.5rem !important;
    }
    
    .stat-card {
        padding: 0.5rem !important;
    }
    
    .card-header {
        padding: 0.5rem 0.75rem !important;
    }
    
    .card-body {
        padding: 0.5rem !important;
    }
}
</style>
@endsection
