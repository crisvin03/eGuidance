@extends('layouts.dashboard')
@section('title', 'My Appointments')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-page-header-compact { flex-direction: column !important; align-items: flex-start !important; gap: 1rem !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    
    /* Filter Form - Stack Vertically */
    .filter-form {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.75rem !important;
        align-items: stretch !important;
        grid-template-columns: unset !important;
    }
    .filter-form > div {
        width: 100% !important;
    }
    .filter-form .form-control,
    .filter-form .form-select {
        width: 100% !important;
        border-radius: 0.5rem !important;
    }
    .filter-form .modern-btn,
    .filter-form button[type="submit"] {
        width: 100% !important;
        border-radius: 0.5rem !important;
    }
    
    .btn span:not([class*="bi"]),
    .btn-sm span:not([class*="bi"]) { 
        display: none !important; 
    }
    .btn i.bi,
    .btn-sm i.bi { 
        margin: 0 !important; 
    }
    .btn-sm { 
        padding: 0.5rem 0.75rem !important; 
        min-width: auto !important; 
    }
    
    .modern-btn { width: 100% !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-calendar-check-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">My Appointments</h1>
            <p class="modern-page-subtitle">All appointments you have scheduled with the counselor</p>
        </div>
        <a href="{{ route('teacher.talk-to-counselor') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
            <i class="bi bi-calendar-plus"></i> Schedule New
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <form method="GET" class="filter-form" style="display: grid; grid-template-columns: 1fr auto auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Status</label>
            <select name="status" class="form-select" style="border-radius: 10px;">
                <option value="">All Statuses</option>
                <option value="scheduled" {{ request('status')=='scheduled' ? 'selected':'' }}>Scheduled</option>
                <option value="confirmed" {{ request('status')=='confirmed' ? 'selected':'' }}>Confirmed</option>
                <option value="completed" {{ request('status')=='completed' ? 'selected':'' }}>Completed</option>
                <option value="cancelled" {{ request('status')=='cancelled' ? 'selected':'' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </div>
        @if(request('status'))
        <div>
            <a href="{{ route('teacher.appointments.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                <i class="bi bi-x-circle"></i> Clear
            </a>
        </div>
        @endif
    </form>
</div>

<!-- Appointments List -->
<div class="modern-card" style="padding: 1.5rem;">
    @if($appointments->count() > 0)
        <div class="modern-list">
            @foreach($appointments as $appointment)
                <div class="modern-list-item" style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb; display: block;">
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: start;">
                        <!-- Left: Appointment Info -->
                        <div style="display: flex; gap: 1rem;">
                            <!-- Counselor Avatar -->
                            <div>
                                @if($appointment->counselor->profile_photo)
                                    <img src="{{ asset('storage/'.$appointment->counselor->profile_photo) }}"
                                         class="rounded-circle" style="width:48px; height:48px; object-fit:cover;">
                                @else
                                    <div class="modern-section-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; font-size: 0.9rem; font-weight: 700;">
                                        {{ strtoupper(substr($appointment->counselor->name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--green); margin: 0;">{{ $appointment->counselor->name }}</h3>
                                    
                                    @php
                                        $statusBadge = match($appointment->status) {
                                            'confirmed' => 'modern-badge-info',
                                            'completed' => 'modern-badge-success',
                                            'cancelled' => 'modern-badge-danger',
                                            default     => 'modern-badge-warning',
                                        };
                                        $statusIcon = match($appointment->status) {
                                            'confirmed' => 'bi-check-circle-fill',
                                            'completed' => 'bi-check-circle-fill',
                                            'cancelled' => 'bi-x-circle-fill',
                                            default     => 'bi-clock-fill',
                                        };
                                    @endphp
                                    
                                    <span class="modern-badge {{ $statusBadge }}" style="font-size: 0.75rem;">
                                        <i class="bi {{ $statusIcon }}"></i> {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                                
                                <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.75rem;">
                                    <span>
                                        <i class="bi bi-calendar3"></i> 
                                        {{ $appointment->appointment_date->format('M d, Y') }}
                                    </span>
                                    <span>
                                        <i class="bi bi-clock"></i> 
                                        {{ $appointment->appointment_date->format('h:i A') }}
                                    </span>
                                </div>
                                
                                @if($appointment->notes)
                                <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">
                                    {{ \Str::limit($appointment->notes, 120) }}
                                </p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Right: Action -->
                        <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                            <a href="{{ route('teacher.appointments.show', $appointment) }}" 
                               class="modern-btn modern-btn-secondary" 
                               style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;">
                                <i class="bi bi-eye"></i> <span>View</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($appointments->hasPages())
            <div style="margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                <small class="text-muted">
                    Showing <strong>{{ $appointments->firstItem() }}–{{ $appointments->lastItem() }}</strong>
                    of <strong>{{ $appointments->total() }}</strong> appointments
                </small>
                {{ $appointments->onEachSide(1)->links() }}
            </div>
        @endif
    @else
        <div class="modern-empty-state" style="padding: 3rem 1.5rem;">
            <div class="modern-empty-icon" style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="bi bi-calendar-x"></i>
            </div>
            <h3 class="modern-empty-title">No appointments found</h3>
            <p class="modern-empty-text">
                @if(request('status'))
                    No appointments match your filter criteria. Try adjusting your filters.
                @else
                    You haven't scheduled any appointments yet.
                @endif
            </p>
            @if(request('status'))
                <a href="{{ route('teacher.appointments.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; margin-top: 1rem;">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
            @else
                <a href="{{ route('teacher.talk-to-counselor') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; margin-top: 1rem;">
                    <i class="bi bi-calendar-plus"></i> Schedule Appointment
                </a>
            @endif
        </div>
    @endif
</div>

<style>
@media (max-width: 1200px) {
    div[style*="grid-template-columns: 1fr auto auto"] {
        grid-template-columns: 1fr auto !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr auto auto"],
    div[style*="grid-template-columns: 1fr auto"] {
        grid-template-columns: 1fr !important;
    }
    
    .modern-list-item > div {
        flex-direction: column;
    }
    
    .modern-list-item > div > div:last-child {
        width: 100%;
    }
    
    .modern-list-item > div > div:last-child > div {
        width: 100%;
        justify-content: stretch;
    }
    
    .modern-list-item > div > div:last-child a {
        flex: 1;
    }
}

.pagination { margin:0; gap:3px; }
.pagination .page-link { border-radius:8px !important; border:1px solid #e2e8f0; color:#475569; font-size:.875rem; padding:.4rem .75rem; transition:all .2s; }
.pagination .page-link:hover { background:rgba(32,178,170,.1); border-color:#1e7a4a; color:#1e7a4a; }
.pagination .page-item.active .page-link { background:#1e7a4a; border-color:#1e7a4a; color:#fff; }
.pagination .page-item.disabled .page-link { opacity:.5; }
</style>

@endsection
