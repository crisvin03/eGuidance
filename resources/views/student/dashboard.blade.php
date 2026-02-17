@extends('layouts.dashboard')

@section('title', 'Student Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-chat-dots"></i>
        </div>
        <div class="stat-value">{{ $concerns->count() }}</div>
        <div class="stat-label">Total Concerns</div>
        <div class="stat-change positive">
            <i class="bi bi-file-text"></i>
            {{ $concerns->where('status', 'resolved')->count() }} resolved
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-clock-history"></i>
        </div>
        <div class="stat-value">{{ $concerns->where('status', 'submitted')->count() }}</div>
        <div class="stat-label">Pending Concerns</div>
        <div class="stat-change negative">
            <i class="bi bi-arrow-up"></i>
            {{ $concerns->where('status', 'submitted')->count() }} waiting
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-calendar3"></i>
        </div>
        <div class="stat-value">{{ $appointments->count() }}</div>
        <div class="stat-label">Total Appointments</div>
        <div class="stat-change positive">
            <i class="bi bi-check-circle"></i>
            {{ $appointments->where('status', 'completed')->count() }} completed
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-calendar-check"></i>
        </div>
        <div class="stat-value">{{ $appointments->where('appointment_date', '>', now())->count() }}</div>
        <div class="stat-label">Upcoming Sessions</div>
        <div class="stat-change positive">
            <i class="bi bi-arrow-up"></i>
            Next scheduled
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">My Concerns</h5>
            </div>
            <div class="card-body">
                @if($concerns->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($concerns->take(5) as $concern)
                                    <tr>
                                        <td>{{ Str::limit($concern->title, 30) }}</td>
                                        <td>{{ $concern->category->name }}</td>
                                        <td>
                                            @if($concern->status == 'resolved')
                                                <span class="badge badge-success">Resolved</span>
                                            @elseif($concern->status == 'scheduled')
                                                <span class="badge badge-info">Scheduled</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $concern->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($concerns->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('student.concerns.index') }}" class="btn btn-secondary btn-sm">
                                View All Concerns
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-chat-dots" style="font-size: 3rem; color: #cbd5e1;"></i>
                        <p class="text-muted mt-3">No concerns submitted yet</p>
                        <a href="{{ route('student.concerns.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Submit Your First Concern
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">My Appointments</h5>
            </div>
            <div class="card-body">
                @if($appointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Counselor</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments->take(5) as $appointment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                                    {{ strtoupper(substr($appointment->counselor->name, 0, 2)) }}
                                                </div>
                                                <span>{{ $appointment->counselor->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $appointment->appointment_date->format('M d, h:i A') }}</td>
                                        <td>
                                            @if($appointment->status == 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif($appointment->status == 'cancelled')
                                                <span class="badge badge-danger">Cancelled</span>
                                            @else
                                                <span class="badge badge-info">Scheduled</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($appointments->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('student.appointments.index') }}" class="btn btn-secondary btn-sm">
                                View All Appointments
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x" style="font-size: 3rem; color: #cbd5e1;"></i>
                        <p class="text-muted mt-3">No appointments scheduled yet</p>
                        <a href="{{ route('student.appointments.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Schedule First Appointment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('student.concerns.create') }}" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i>
                            Submit New Concern
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('student.appointments.create') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-calendar-plus"></i>
                            Schedule Appointment
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('student.concerns.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-chat-dots"></i>
                            View All Concerns
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('student.appointments.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-calendar3"></i>
                            View All Appointments
                        </a>
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
                        <th>Activity</th>
                        <th>Details</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if($concerns->count() > 0)
                        @foreach($concerns->take(3) as $concern)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-chat-dots text-primary"></i>
                                        <span>Concern Submitted</span>
                                    </div>
                                </td>
                                <td>{{ Str::limit($concern->title, 40) }}</td>
                                <td>{{ $concern->created_at->format('M d, h:i A') }}</td>
                                <td>
                                    @if($concern->status == 'resolved')
                                        <span class="badge badge-success">Resolved</span>
                                    @elseif($concern->status == 'scheduled')
                                        <span class="badge badge-info">Scheduled</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No recent activity to display
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
