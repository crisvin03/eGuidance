@extends('layouts.dashboard')
@section('title', 'Referral Details')

@section('content')
@include('student.partials.modern-styles')

<style>
/* Mobile Responsive Styles for Counselor Pages */
@media (max-width: 768px) {
    /* Two-column grid becomes single column */
    div[style*="grid-template-columns: 1fr 380px"] {
        display: block !important;
    }
    
    /* Remove fixed widths on mobile */
    .modern-card {
        margin-bottom: 1rem !important;
    }
    
    /* Stack action buttons vertically */
    div[style*="display: flex"][style*="gap"] {
        flex-direction: column !important;
    }
    
    /* Full width buttons on mobile */
    .modern-btn {
        width: 100% !important;
        justify-content: center !important;
    }
    
    /* Reduce padding on cards */
    .modern-card[style*="padding: 1.5rem"] {
        padding: 1rem !important;
    }
    
    /* Make badges smaller */
    .modern-badge, .badge {
        font-size: 0.75rem !important;
    }
    
    /* Responsive grid for info boxes */
    .row.g-3 {
        gap: 0.5rem !important;
    }
    
    /* Full width columns on mobile */
    .col-md-6, .col-md-4, .col-md-3, .col-12 {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Smaller text on mobile */
    h1[style*="font-size: 1.5rem"] {
        font-size: 1.25rem !important;
    }
    
    h6.fw-bold {
        font-size: 0.95rem !important;
    }
    
    /* User avatar smaller */
    .user-avatar {
        width: 32px !important;
        height: 32px !important;
        font-size: 0.75rem !important;
    }
    
    /* Textareas more compact */
    textarea.form-control {
        font-size: 0.875rem !important;
    }
}
</style>

<!-- Back Button & Actions -->
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
    <a href="{{ route('counselor.referrals.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
        <i class="bi bi-arrow-left"></i> Back to Student Referrals
    </a>
    <a href="{{ route('counselor.referrals.print', $studentReferral) }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1rem; font-size: 0.875rem;" target="_blank">
        <i class="bi bi-printer-fill"></i> Print/Download PDF
    </a>
</div>

<!-- Page Header -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--green); margin: 0 0 0.5rem 0;">{{ $studentReferral->referral_number }}</h1>
            <p style="color: var(--text-muted); margin: 0;">Student Referral Details</p>
        </div>
        @if($studentReferral->status == 'pending')
            <span class="modern-badge modern-badge-warning" style="font-size: 0.9rem;"><i class="bi bi-clock-fill"></i> Pending</span>
        @elseif($studentReferral->status == 'ongoing')
            <span class="modern-badge modern-badge-info" style="font-size: 0.9rem;"><i class="bi bi-arrow-repeat"></i> Ongoing</span>
        @else
            <span class="modern-badge modern-badge-success" style="font-size: 0.9rem;"><i class="bi bi-check-circle-fill"></i> Closed</span>
        @endif
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 1.5rem;">
    <!-- Main Content -->
    <div>
        <!-- Student Info -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-person me-2" style="color:#1e7a4a;"></i>Student Information
            </h6>
            <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-person me-1"></i>Student Name</small>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar">{{ strtoupper(substr($studentReferral->student_name, 0, 2)) }}</div>
                                <strong>{{ $studentReferral->student_name }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-123 me-1"></i>Age</small>
                            <strong>{{ $studentReferral->student_age ?? '—' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-book me-1"></i>Grade & Section</small>
                            <strong>{{ $studentReferral->grade_section }}</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-geo-alt me-1"></i>Address</small>
                            <strong>{{ $studentReferral->student_address ?? '—' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-calendar me-1"></i>Submitted</small>
                            <strong>{{ $studentReferral->created_at->format('M d, Y h:i A') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-person-badge me-1"></i>Submitted By</small>
                            <strong>{{ $studentReferral->teacher->name ?? '—' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Update form --}}
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-reply me-2" style="color:#1e7a4a;"></i>Update Status & Notes
            </h6>
            <div>
                <form method="POST" action="{{ route('counselor.referrals.update', $studentReferral) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $studentReferral->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="ongoing" {{ $studentReferral->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="closed"  {{ $studentReferral->status === 'closed'  ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Counselor Notes</label>
                        <textarea class="form-control" name="counselor_notes" rows="4"
                                  placeholder="Add observations, recommendations, or follow-up actions...">{{ $studentReferral->counselor_notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg me-1"></i> Update Referral
                    </button>
                </form>
            </div>
        </div>

        {{-- Counselor Notes --}}
        @if($studentReferral->counselor_notes)
        <div class="alert alert-info mb-4">
            <h6 class="alert-heading fw-semibold"><i class="bi bi-person-check-fill me-1"></i>Counselor Notes</h6>
            <p class="mb-0" style="white-space:pre-wrap;">{{ $studentReferral->counselor_notes }}</p>
        </div>
        @endif
    </div>

    {{-- Right sidebar --}}
    <div>

        {{-- Referral Details --}}
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-card-text me-2" style="color:#1e7a4a;"></i>Referral Details
            </h6>
            <div>
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-text-paragraph me-1"></i>Reason for Referral</h6>
                    <div class="p-3 rounded-3" style="background:#f8fafc;white-space:pre-wrap;">{{ $studentReferral->reason_for_referral }}</div>
                </div>

                @if($studentReferral->observed_behavior)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-eye me-1"></i>Observed Behavior</h6>
                    <div class="p-3 rounded-3" style="background:#f8fafc;white-space:pre-wrap;">{{ $studentReferral->observed_behavior }}</div>
                </div>
                @endif

                @if($studentReferral->actions_taken)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-bandaid me-1"></i>Actions Already Taken</h6>
                    <div class="alert alert-success mb-0" style="white-space:pre-wrap;">{{ $studentReferral->actions_taken }}</div>
                </div>
                @endif

                @if($studentReferral->additional_notes)
                <div class="mb-0">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-chat-left-text me-1"></i>Additional Notes</h6>
                    <div class="p-3 rounded-3" style="background:#f8fafc;white-space:pre-wrap;">{{ $studentReferral->additional_notes }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Quick Info --}}
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                Quick Info
            </h6>
            <div>
                <div class="d-flex flex-column gap-3">
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Referral Number</small>
                        <span class="fw-bold" style="color:#1e7a4a;">{{ $studentReferral->referral_number }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Status</small>
                        @if($studentReferral->status == 'pending')
                            <span class="modern-badge modern-badge-warning" style="font-size: 0.85rem;"><i class="bi bi-clock-fill"></i> Pending</span>
                        @elseif($studentReferral->status == 'ongoing')
                            <span class="modern-badge modern-badge-info" style="font-size: 0.85rem;"><i class="bi bi-arrow-repeat"></i> Ongoing</span>
                        @else
                            <span class="modern-badge modern-badge-success" style="font-size: 0.85rem;"><i class="bi bi-check-circle-fill"></i> Closed</span>
                        @endif
                    </div>
                    @if($studentReferral->preferred_followup)
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Preferred Follow-Up</small>
                        <span class="fw-semibold small">{{ $studentReferral->preferred_followup }}</span>
                    </div>
                    @endif
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Assigned Counselor</small>
                        <span class="fw-semibold small">{{ $studentReferral->counselor->name ?? 'Unassigned' }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Date Submitted</small>
                        <span class="fw-semibold small">{{ $studentReferral->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
