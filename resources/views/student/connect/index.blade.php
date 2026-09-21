@extends('layouts.dashboard')

@section('title', 'Connect with Ate/Kuya')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-people-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Connect with Ate/Kuya</h1>
            <p class="modern-page-subtitle">Need to talk to someone? We're here for you.</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="modern-grid-3 mb-4" style="gap: 1.5rem;">
    <a href="{{ route('student.connect.counselors') }}" class="text-decoration-none">
        <div class="modern-card modern-card-compact" style="padding: 1.5rem; text-align: center; transition: all 0.3s ease;">
            <div class="modern-section-icon" style="margin: 0 auto 1rem; width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                <i class="bi bi-person-hearts"></i>
            </div>
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Browse Counselors</h6>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">View all available counselors</p>
        </div>
    </a>
    <a href="{{ route('student.appointments.create') }}" class="text-decoration-none">
        <div class="modern-card modern-card-compact" style="padding: 1.5rem; text-align: center; transition: all 0.3s ease;">
            <div class="modern-section-icon" style="margin: 0 auto 1rem; width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                <i class="bi bi-calendar-plus"></i>
            </div>
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Book Appointment</h6>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">Schedule a session at your preferred time</p>
        </div>
    </a>
    <a href="{{ route('student.spill-tea') }}" class="text-decoration-none">
        <div class="modern-card modern-card-compact" style="padding: 1.5rem; text-align: center; transition: all 0.3s ease;">
            <div class="modern-section-icon" style="margin: 0 auto 1rem; width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                <i class="bi bi-chat-heart-fill"></i>
            </div>
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Send a Message</h6>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">Share your concerns anytime</p>
        </div>
    </a>
</div>

<div class="row" style="gap: 0;">
    <!-- Left Column: Main Content -->
    <div class="col-md-8">
        <!-- Available Counselors -->
        <div class="modern-card mb-3" style="padding: 1.5rem;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy);">
                    <i class="bi bi-people me-2" style="font-size: 1.1rem;"></i>
                    Available Counselors
                </h6>
                <a href="{{ route('student.connect.counselors') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                    View All
                </a>
            </div>
            
            <div class="modern-grid-2" style="gap: 1rem;">
                @forelse($counselors->take(4) as $counselor)
                    <div style="padding: 1.25rem; border: 1px solid rgba(30, 122, 74, 0.12); border-radius: 14px; background: rgba(255, 255, 255, 0.5);">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div style="flex: 1;">
                                <h6 style="font-size: 1rem; font-weight: 600; color: var(--navy); margin-bottom: 0.25rem;">{{ $counselor->name }}</h6>
                                <small style="color: var(--text-muted); font-size: 0.85rem;">Guidance Counselor</small>
                            </div>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('student.connect.chat', $counselor->id) }}" 
                               class="modern-btn modern-btn-secondary" style="flex: 1; padding: 0.625rem 1rem; font-size: 0.875rem;">
                                <i class="bi bi-chat-dots"></i>
                                <span>Message</span>
                            </a>
                            <a href="{{ route('student.appointments.create') }}?counselor_id={{ $counselor->id }}" 
                               class="modern-btn modern-btn-primary" style="flex: 1; padding: 0.625rem 1rem; font-size: 0.875rem;">
                                <i class="bi bi-calendar-plus"></i>
                                <span>Book</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: span 2; text-align: center; padding: 3rem 1rem;">
                        <div style="width: 60px; height: 60px; margin: 0 auto 1rem; border-radius: 50%; background: rgba(30, 122, 74, 0.12); display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-inbox" style="font-size: 1.75rem; color: var(--green);"></i>
                        </div>
                        <p style="color: var(--text-muted); margin: 0;">No counselors available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Appointments -->
        @if($upcomingAppointments && $upcomingAppointments->count() > 0)
        <div class="modern-card" style="padding: 1.5rem;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy);">
                    <i class="bi bi-calendar-event me-2" style="font-size: 1.1rem;"></i>
                    Upcoming Sessions
                </h6>
                <a href="{{ route('student.appointments.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                    View All
                </a>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @foreach($upcomingAppointments as $appointment)
                    <div style="padding: 1rem; border: 1px solid rgba(30, 122, 74, 0.12); border-radius: 12px; background: rgba(255, 255, 255, 0.5); display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <div style="font-size: 1rem; font-weight: 600; color: var(--navy); margin-bottom: 0.25rem;">{{ $appointment->counselor->name }}</div>
                                <small style="color: var(--text-muted); font-size: 0.85rem;">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $appointment->appointment_date->format('M d, Y - g:i A') }}
                                </small>
                            </div>
                        </div>
                        <span class="modern-badge modern-badge-info" style="font-size: 0.8rem;">{{ $appointment->status }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column: Sidebar Cards -->
    <div class="col-md-4 d-flex flex-column" style="gap: 1rem;">
        <!-- Need Help Now -->
        <div class="modern-card mb-3" style="padding: 1.25rem; background: linear-gradient(135deg, rgba(239, 68, 68, 0.08), rgba(239, 68, 68, 0.04)); text-align: center;">
            <div style="margin-bottom: 0.75rem;">
                <i class="bi bi-heart-pulse-fill" style="font-size: 2rem; color: #ef4444;"></i>
            </div>
            <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Need help right now?</h6>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.875rem; line-height: 1.4;">
                If this is an emergency or you need immediate support, please reach out.
            </p>
            <a href="{{ route('student.mind-check') }}" class="modern-btn" style="width: 100%; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 0.625rem 1rem; font-size: 0.875rem; margin-bottom: 0.625rem;">
                <i class="bi bi-heart-pulse"></i>
                <span>Take Mind Check</span>
            </a>
            <small style="color: var(--text-muted); display: block; font-size: 0.75rem; line-height: 1.3;">
                Or call the guidance office<br>
                <strong>(Campus Hotline)</strong>
            </small>
        </div>

        <!-- Stats -->
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1.25rem;">Your Stats</h6>
            <div style="margin-bottom: 1.25rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span style="color: var(--text-muted); font-size: 0.875rem;">Total Sessions</span>
                    <span style="font-weight: 700; color: var(--navy);">{{ $recentAppointments->count() }}</span>
                </div>
                <div style="height: 6px; border-radius: 3px; background: rgba(30, 122, 74, 0.12); overflow: hidden;">
                    <div style="width: {{ min(($recentAppointments->count() / 10) * 100, 100) }}%; height: 100%; background: linear-gradient(90deg, var(--green), #145e38);"></div>
                </div>
            </div>
            <div style="margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--text-muted); font-size: 0.875rem;">Upcoming</span>
                    <span style="font-weight: 700; color: var(--navy);">{{ $upcomingAppointments->count() }}</span>
                </div>
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--text-muted); font-size: 0.875rem;">Concerns Shared</span>
                    <span style="font-weight: 700; color: var(--navy);">{{ auth()->user()->concerns()->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Sessions -->
@if($recentAppointments && $recentAppointments->count() > 0)
<div class="modern-card mt-4" style="padding: 1.5rem;">
    <div class="modern-section-header">
        <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-clock-history"></i>
        </div>
        <h2 class="modern-section-title" style="font-size: 1.15rem;">Recent Sessions</h2>
    </div>
    
    <div class="modern-grid-3" style="gap: 1rem;">
        @foreach($recentAppointments as $appointment)
            <div style="padding: 1rem; border: 1px solid rgba(30, 122, 74, 0.12); border-radius: 12px; background: rgba(255, 255, 255, 0.5);">
                <div style="font-weight: 600; color: var(--navy); margin-bottom: 0.5rem; font-size: 0.95rem;">{{ $appointment->counselor->name }}</div>
                <small style="color: var(--text-muted); display: block; margin-bottom: 0.75rem; font-size: 0.85rem;">
                    {{ $appointment->appointment_date->format('M d, Y') }}
                </small>
                <span class="modern-badge modern-badge-success" style="font-size: 0.75rem;">Completed</span>
            </div>
        @endforeach
    </div>
</div>
@endif

<style>
/* Hover effect for action cards */
.modern-grid-3 > a .modern-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(13, 45, 82, 0.15);
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .modern-grid-2 {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .modern-grid-3 {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
