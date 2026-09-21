@extends('layouts.dashboard')
@section('title', 'Talk to Counselor')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-grid-2 { display: block !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    .row.g-3 { gap: 0.5rem !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-chat-dots-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Talk to Counselor</h1>
            <p class="modern-page-subtitle">Schedule an appointment with a guidance counselor for consultation or student concerns</p>
        </div>
    </div>
</div>

<div class="modern-grid-2">
    <!-- Main Content -->
    <div>
        <!-- Schedule Appointment Section -->
        <div class="modern-card mb-4">
            <h6 class="modern-form-section-title">
                <i class="bi bi-calendar-plus" style="color: var(--green);"></i>
                Schedule an Appointment
            </h6>
            <form method="POST" action="{{ route('teacher.appointments.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="modern-form-label">
                            <span>Select Counselor</span>
                            <span class="text-danger">*</span>
                        </label>
                        <select name="counselor_id" class="form-select modern-form-control @error('counselor_id') is-invalid @enderror" required>
                            <option value="">Choose a counselor...</option>
                            @foreach($counselors as $counselor)
                                <option value="{{ $counselor->id }}">{{ $counselor->name }}</option>
                            @endforeach
                        </select>
                        @error('counselor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="modern-form-label">
                            <span>Date & Time</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" name="appointment_date" class="form-control modern-form-control @error('appointment_date') is-invalid @enderror"
                               min="{{ now()->addHour()->format('Y-m-d\TH:i') }}" required>
                        <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                            <i class="bi bi-info-circle me-1"></i>
                            Please schedule at least 1 hour in advance
                        </small>
                        @error('appointment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="modern-form-label">
                            <span>Purpose/Notes</span>
                            <span class="text-muted fw-normal">(Optional)</span>
                        </label>
                        <textarea name="notes" class="form-control modern-form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Brief reason for the meeting..." maxlength="500"></textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                            <i class="bi bi-calendar-check"></i> Schedule Appointment
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- My Appointments Link -->
        <div class="modern-card" style="padding: 1.25rem; cursor: pointer; transition: all 0.2s;" onclick="window.location='{{ route('teacher.appointments.index') }}'">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(30, 122, 74, 0.06)); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: var(--green);">
                        <i class="bi bi-calendar3"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0" style="font-size: 0.95rem; color: var(--navy);">My Appointments</h6>
                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">View all your scheduled and past appointments</p>
                    </div>
                </div>
                <i class="bi bi-arrow-right" style="font-size: 1.25rem; color: var(--green);"></i>
            </div>
        </div>
    </div>
    
    <!-- Sidebar - Available Counselors -->
    <div>
        <div class="modern-card modern-card-compact">
            <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: var(--navy);">
                <i class="bi bi-people me-1" style="color: var(--green);"></i>
                Available Counselors
            </h6>
            
            @if($counselors->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-person-x d-block fs-2 mb-2 opacity-50" style="color: #9ca3af;"></i>
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">No active counselors found</p>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach($counselors as $counselor)
                    <div style="padding: 0.75rem; background: #f9fafb; border-radius: 10px; display: flex; align-items: center; gap: 0.75rem;">
                        @if($counselor->profile_photo)
                            <img src="{{ asset('storage/' . $counselor->profile_photo) }}"
                                 alt="{{ $counselor->name }}"
                                 class="rounded-circle"
                                 style="width:40px; height:40px; object-fit:cover;">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                 style="width:40px; height:40px; background:linear-gradient(135deg,#1e7a4a,#145e38); font-size: 0.75rem;">
                                {{ strtoupper(substr($counselor->name, 0, 2)) }}
                            </div>
                        @endif
                        <div style="flex: 1; min-width: 0;">
                            <div class="fw-semibold" style="font-size: 0.875rem; color: var(--navy);">{{ $counselor->name }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Guidance Counselor</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <!-- Help Card -->
        <div class="modern-card modern-card-compact mt-4" style="background: #f0f9f4;">
            <h6 class="fw-bold mb-3" style="font-size: 0.875rem; color: var(--navy);">
                <i class="bi bi-info-circle me-1" style="color: var(--green);"></i>
                Appointment Tips
            </h6>
            <ul class="mb-0 ps-3" style="font-size: 0.8rem; line-height: 1.8; color: #6b7280;">
                <li>Schedule at least 1 hour in advance</li>
                <li>Be specific about your purpose</li>
                <li>Arrive 5 minutes early</li>
                <li>Prepare any documents needed</li>
            </ul>
        </div>
    </div>
</div>
@endsection
