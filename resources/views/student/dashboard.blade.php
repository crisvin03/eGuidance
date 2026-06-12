@extends('layouts.dashboard')

@section('title', 'Student Dashboard')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Welcome Banner -->
<div class="card border-0 mb-4" style="background:linear-gradient(135deg,#20B2AA,#008B8B);border-radius:16px;">
    <div class="card-body p-4 text-white">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Good day, {{ Auth::user()->name }}! 👋</h4>
                <p class="mb-0 opacity-75">SIGMA Student Portal &mdash; {{ now()->format('l, F d, Y') }}</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('student.concerns.create') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-plus-circle me-1"></i> Submit Concern
                </a>
                <a href="{{ route('student.kamustaka') }}" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-heart-pulse me-1"></i> Kamusta Ka?
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(32,178,170,0.1);">
                    <i class="bi bi-chat-dots-fill fs-5" style="color:#20B2AA;"></i>
                </div>
                <div class="fs-3 fw-bold" style="color:#20B2AA;">{{ $concerns->count() }}</div>
                <div class="text-muted small">Total Concerns</div>
                <div class="text-success" style="font-size:0.75rem;">{{ $concerns->where('status','resolved')->count() }} resolved</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(245,158,11,0.1);">
                    <i class="bi bi-hourglass-split fs-5 text-warning"></i>
                </div>
                <div class="fs-3 fw-bold text-warning">{{ $concerns->where('status','submitted')->count() }}</div>
                <div class="text-muted small">Pending Concerns</div>
                <div class="text-muted" style="font-size:0.75rem;">awaiting review</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(59,130,246,0.1);">
                    <i class="bi bi-calendar3 fs-5 text-primary"></i>
                </div>
                <div class="fs-3 fw-bold text-primary">{{ $appointments->count() }}</div>
                <div class="text-muted small">Total Appointments</div>
                <div class="text-success" style="font-size:0.75rem;">{{ $appointments->where('status','completed')->count() }} completed</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(16,185,129,0.1);">
                    <i class="bi bi-calendar-check fs-5 text-success"></i>
                </div>
                <div class="fs-3 fw-bold text-success">{{ $appointments->where('appointment_date','>',now())->count() }}</div>
                <div class="text-muted small">Upcoming Sessions</div>
                <div class="text-muted" style="font-size:0.75rem;">scheduled ahead</div>
            </div>
        </div>
    </div>
</div>

<!-- Kamusta Ka? Check-in Card -->
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;background:linear-gradient(135deg,rgba(32,178,170,0.06),rgba(0,139,139,0.04));">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:52px;height:52px;background:linear-gradient(135deg,#20B2AA,#008B8B);">
                    <i class="bi bi-heart-pulse-fill text-white fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Kamusta Ka? — Emotional Check-In</h6>
                    <p class="text-muted small mb-0">How are you feeling today? Take a moment to check in with yourself.</p>
                </div>
            </div>
            <a href="{{ route('student.kamustaka') }}" class="btn fw-semibold text-white flex-shrink-0"
               style="background:linear-gradient(135deg,#20B2AA,#008B8B);border-radius:50px;">
                <i class="bi bi-emoji-smile me-1"></i> Check In Now
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
        <h6 class="fw-bold mb-0"><i class="bi bi-lightning-charge me-2" style="color:#20B2AA;"></i>Quick Actions</h6>
    </div>
    <div class="card-body px-4 pb-4">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('student.concerns.create') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card">
                        <i class="bi bi-plus-circle fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Submit Concern</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('student.appointments.create') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card">
                        <i class="bi bi-calendar-plus fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Book Appointment</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('student.concerns.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card">
                        <i class="bi bi-chat-dots fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">My Concerns</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('student.resources') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card">
                        <i class="bi bi-journal-bookmark fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Resources</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Concerns & Appointments -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-chat-dots me-2" style="color:#20B2AA;"></i>My Concerns</h6>
                <a href="{{ route('student.concerns.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body px-4 pb-4">
                @forelse($concerns->take(5) as $concern)
                    <div class="d-flex justify-content-between align-items-start py-3 border-bottom">
                        <div>
                            <div class="fw-semibold text-dark small">{{ Str::limit($concern->title, 35) }}</div>
                            <div class="text-muted" style="font-size:0.78rem;">{{ $concern->category->name ?? '—' }} &bull; {{ $concern->created_at->format('M d, Y') }}</div>
                        </div>
                        @if($concern->status == 'resolved')
                            <span class="badge bg-success">Resolved</span>
                        @elseif($concern->status == 'scheduled')
                            <span class="badge bg-info">Scheduled</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                        <small>No concerns yet. <a href="{{ route('student.concerns.create') }}">Submit one.</a></small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-calendar3 me-2" style="color:#20B2AA;"></i>My Appointments</h6>
                <a href="{{ route('student.appointments.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body px-4 pb-4">
                @forelse($appointments->take(5) as $appointment)
                    <div class="d-flex justify-content-between align-items-start py-3 border-bottom">
                        <div>
                            <div class="fw-semibold text-dark small">{{ $appointment->counselor->name }}</div>
                            <div class="text-muted" style="font-size:0.78rem;">{{ $appointment->appointment_date->format('M d, Y \a\t h:i A') }}</div>
                        </div>
                        @if($appointment->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                        @elseif($appointment->status == 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-info">Scheduled</span>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                        <small>No appointments yet. <a href="{{ route('student.appointments.create') }}">Book one.</a></small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.quick-action-card { transition:all 0.2s ease; cursor:pointer; color:#334155; background:#f8fafc; }
.quick-action-card:hover { background:rgba(32,178,170,0.06); border-color:#20B2AA !important; transform:translateY(-3px); box-shadow:0 8px 20px rgba(32,178,170,0.15); }
</style>
@endsection
