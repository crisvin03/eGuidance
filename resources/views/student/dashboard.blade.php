@extends('layouts.dashboard')

@section('title', 'Tambayan - Student Portal')

@section('content')
@include('student.partials.modern-styles')

<!-- Welcome Hero Section -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Kumusta, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
            <p class="modern-page-subtitle">Welcome back to your Care Konek. {{ now()->format('l, F d, Y') }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('student.spill-tea') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-chat-heart-fill"></i>
                <span>Share</span>
            </a>
            <a href="{{ route('student.mind-check') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-heart-pulse-fill"></i>
                <span>Check-in</span>
            </a>
            <a href="{{ route('student.connect') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-people-fill"></i>
                <span>Connect</span>
            </a>
        </div>
    </div>
</div>

<!-- Status Cards Grid -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">
    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-chat-dots-fill"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $concerns->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Concerns</div>
        </div>
        <a href="{{ route('student.concerns.index') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-calendar-check"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $appointments->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Sessions</div>
        </div>
        <a href="{{ route('student.connect') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $concerns->where('status','resolved')->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Resolved</div>
        </div>
        <a href="{{ route('student.concerns.index') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-calendar-event"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $appointments->where('appointment_date','>',now())->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Upcoming</div>
        </div>
        <a href="{{ route('student.connect') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Main Content Grid -->
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
    <!-- Recent Concerns -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon modern-page-icon-green" style="width: 40px; height: 40px; font-size: 1.1rem;">
                <i class="bi bi-chat-dots-fill"></i>
            </div>
            <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Recent Concerns</h2>
            <a href="{{ route('student.concerns.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                View All
            </a>
        </div>
        
        <div class="modern-list">
            @forelse($concerns->take(4) as $concern)
                <div class="modern-list-item" style="padding: 1rem 0;">
                    <div style="flex: 1;">
                        <div style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">{{ Str::limit($concern->title, 40) }}</div>
                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; font-size: 0.8rem; color: var(--text-muted);">
                            <span class="modern-badge modern-badge-secondary">{{ $concern->category->name ?? 'General' }}</span>
                            <span>{{ $concern->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div>
                        @if($concern->status == 'resolved')
                            <span class="modern-badge modern-badge-success" style="font-size: 0.8rem;"><i class="bi bi-check-circle-fill"></i> Resolved</span>
                        @elseif($concern->status == 'scheduled')
                            <span class="modern-badge modern-badge-info" style="font-size: 0.8rem;"><i class="bi bi-calendar-check"></i> Scheduled</span>
                        @else
                            <span class="modern-badge modern-badge-warning" style="font-size: 0.8rem;"><i class="bi bi-clock-fill"></i> Pending</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="modern-empty-state" style="padding: 2.5rem 1.5rem;">
                    <div class="modern-empty-icon" style="width: 60px; height: 60px; font-size: 1.75rem;">
                        <i class="bi bi-chat-heart"></i>
                    </div>
                    <h3 class="modern-empty-title" style="font-size: 1.05rem;">No concerns yet</h3>
                    <p class="modern-empty-text" style="font-size: 0.9rem;">When you're ready to talk, we're here to listen.</p>
                    <a href="{{ route('student.spill-tea') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">Share a concern</a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Upcoming Sessions -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon modern-page-icon-green" style="width: 40px; height: 40px; font-size: 1.1rem;">
                <i class="bi bi-calendar3"></i>
            </div>
            <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Upcoming Sessions</h2>
            <a href="{{ route('student.connect') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                View All
            </a>
        </div>
        
        <div class="modern-list">
            @forelse($appointments->where('appointment_date', '>', now())->take(4) as $appointment)
                <div class="modern-list-item" style="padding: 1rem 0;">
                    <div style="flex: 1;">
                        <div style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">{{ $appointment->counselor->name }}</div>
                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; font-size: 0.8rem; color: var(--text-muted);">
                            <span><i class="bi bi-calendar3"></i> {{ $appointment->appointment_date->format('M d') }}</span>
                            <span><i class="bi bi-clock"></i> {{ $appointment->appointment_date->format('h:i A') }}</span>
                        </div>
                    </div>
                    <div>
                        @if($appointment->status == 'confirmed')
                            <span class="modern-badge modern-badge-success" style="font-size: 0.8rem;"><i class="bi bi-check-circle-fill"></i> Confirmed</span>
                        @elseif($appointment->status == 'cancelled')
                            <span class="modern-badge modern-badge-danger" style="font-size: 0.8rem;"><i class="bi bi-x-circle-fill"></i> Cancelled</span>
                        @else
                            <span class="modern-badge modern-badge-info" style="font-size: 0.8rem;"><i class="bi bi-clock-fill"></i> Scheduled</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="modern-empty-state" style="padding: 2.5rem 1.5rem;">
                    <div class="modern-empty-icon" style="width: 60px; height: 60px; font-size: 1.75rem;">
                        <i class="bi bi-calendar-heart"></i>
                    </div>
                    <h3 class="modern-empty-title" style="font-size: 1.05rem;">No sessions scheduled</h3>
                    <p class="modern-empty-text" style="font-size: 0.9rem;">Book a session with a counselor when you need support.</p>
                    <a href="{{ route('student.connect') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">Book a session</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
/* Responsive adjustments */
@media (max-width: 1200px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"],
    div[style*="grid-template-columns: repeat(2, 1fr)"] {
        grid-template-columns: 1fr !important;
    }
    
    .modern-page-header-compact {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .modern-list-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
}
</style>
@endsection
