@extends('layouts.dashboard')
@section('title', 'Referral Details')

@section('content')
@include('student.partials.modern-styles')

<style>
/* Mobile Responsive Styles */
@media (max-width: 768px) {
    div[style*="grid-template-columns: 2fr 1fr"] {
        display: block !important;
    }
    .modern-card {
        margin-bottom: 1rem !important;
    }
    div[style*="display: flex"][style*="gap"] {
        flex-direction: column !important;
    }
    .modern-btn {
        width: 100% !important;
        justify-content: center !important;
    }
    .modern-card[style*="padding: 1.5rem"] {
        padding: 1rem !important;
    }
    .modern-badge, .badge {
        font-size: 0.75rem !important;
    }
    .row.g-3 {
        gap: 0.5rem !important;
    }
    .col-md-6, .col-md-4, .col-md-3, .col-12, .col-sm-2, .col-sm-5, .col-sm-6 {
        width: 100% !important;
        max-width: 100% !important;
    }
    h1[style*="font-size: 1.5rem"] {
        font-size: 1.25rem !important;
    }
    h6.fw-bold {
        font-size: 0.95rem !important;
    }
    .user-avatar {
        width: 32px !important;
        height: 32px !important;
        font-size: 0.75rem !important;
    }
}
</style>

<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('teacher.referrals.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
        <i class="bi bi-arrow-left"></i> Back to Referrals
    </a>
</div>

<!-- Page Header -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--green); margin: 0 0 0.5rem 0;">{{ $studentReferral->referral_number }}</h1>
            <p style="color: var(--text-muted); margin: 0;">Submitted {{ $studentReferral->created_at->format('F d, Y \a\t h:i A') }}</p>
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

<!-- Main Content Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
    <!-- Student Information -->
    <div class="modern-card" style="padding: 1.5rem;">
        <h6 class="fw-bold mb-3" style="color: var(--navy);">
            <i class="bi bi-person me-2" style="color:#1e7a4a;"></i>Student Information
        </h6>
        <div class="row g-3">
            <div class="col-sm-5">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted d-block mb-1"><i class="bi bi-person me-1"></i>Student Name</small>
                    <div class="d-flex align-items-center gap-2">
                        <div class="user-avatar">{{ strtoupper(substr($studentReferral->student_name, 0, 2)) }}</div>
                        <strong>{{ $studentReferral->student_name }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted d-block mb-1">Age</small>
                    <strong>{{ $studentReferral->student_age ?? '—' }}</strong>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted d-block mb-1"><i class="bi bi-mortarboard me-1"></i>Grade & Section</small>
                    <strong>{{ $studentReferral->grade_section }}</strong>
                </div>
            </div>
            <div class="col-12">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted d-block mb-1"><i class="bi bi-geo-alt me-1"></i>Address</small>
                    <strong>{{ $studentReferral->student_address ?? '—' }}</strong>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted d-block mb-1"><i class="bi bi-calendar me-1"></i>Date Submitted</small>
                    <strong>{{ $studentReferral->created_at->format('M d, Y') }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Info -->
    <div class="modern-card" style="padding: 1.5rem;">
        <h6 class="fw-bold mb-3" style="color: var(--navy);">Quick Info</h6>
        <div class="d-flex flex-column gap-3">
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Referral Number</small>
                <span class="fw-bold" style="color:#1e7a4a;">{{ $studentReferral->referral_number }}</span>
            </div>
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Status</small>
                @if($studentReferral->status == 'pending')
                    <span class="modern-badge modern-badge-warning"><i class="bi bi-clock-fill"></i> Pending</span>
                @elseif($studentReferral->status == 'ongoing')
                    <span class="modern-badge modern-badge-info"><i class="bi bi-arrow-repeat"></i> Ongoing</span>
                @else
                    <span class="modern-badge modern-badge-success"><i class="bi bi-check-circle-fill"></i> Closed</span>
                @endif
            </div>
            @if($studentReferral->preferred_followup)
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Preferred Follow-Up</small>
                <span class="fw-semibold small">{{ $studentReferral->preferred_followup }}</span>
            </div>
            @endif
            @if($studentReferral->counselor)
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Assigned Counselor</small>
                <span class="fw-semibold small">{{ $studentReferral->counselor->name }}</span>
            </div>
            @endif
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Referred By</small>
                <span class="fw-semibold small">{{ $studentReferral->teacher->name }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Referral Details (Full Width) -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <h6 class="fw-bold mb-3" style="color: var(--navy);">
        <i class="bi bi-card-text me-2" style="color:#1e7a4a;"></i>Referral Details
    </h6>
    <div class="mb-4">
        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
            <i class="bi bi-text-paragraph me-1"></i>Reason for Referral
        </label>
        <div class="p-3 rounded-3" style="background:#f8fafc; white-space:pre-wrap;">{{ $studentReferral->reason_for_referral }}</div>
    </div>
    @if($studentReferral->observed_behavior)
    <div class="mb-4">
        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
            <i class="bi bi-eye me-1"></i>Observed Behavior
        </label>
        <div class="p-3 rounded-3" style="background:#f8fafc; white-space:pre-wrap;">{{ $studentReferral->observed_behavior }}</div>
    </div>
    @endif
    @if($studentReferral->actions_taken)
    <div class="mb-4">
        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
            <i class="bi bi-bandaid me-1"></i>Actions Already Taken
        </label>
        <div class="p-3 rounded-3" style="background:#f0fdf4; border-left:4px solid #22c55e; white-space:pre-wrap;">{{ $studentReferral->actions_taken }}</div>
    </div>
    @endif
    @if($studentReferral->additional_notes)
    <div class="mb-0">
        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
            <i class="bi bi-chat-left-text me-1"></i>Additional Notes
        </label>
        <div class="p-3 rounded-3" style="background:#f8fafc; white-space:pre-wrap;">{{ $studentReferral->additional_notes }}</div>
    </div>
    @endif
</div>

<!-- Counselor Notes (Full Width) -->
@if($studentReferral->counselor_notes)
<div class="modern-card" style="padding: 1.5rem; background: #eff6ff; border-left: 4px solid #3b82f6;">
    <h6 class="fw-bold mb-2" style="color: #1e40af;">
        <i class="bi bi-person-check-fill me-1"></i>Counselor Notes
    </h6>
    <p class="mb-0" style="white-space:pre-wrap; color: #1e40af;">{{ $studentReferral->counselor_notes }}</p>
</div>
@endif

@endsection
