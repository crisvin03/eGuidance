@extends('layouts.dashboard')
@section('title', 'Incident Report Details')

@section('content')
@include('student.partials.modern-styles')

<style>
/* Mobile Responsive Styles */
@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 1fr"] {
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
    .col-md-6, .col-md-4, .col-md-3, .col-12, .col-sm-2, .col-sm-4, .col-sm-5, .col-sm-6 {
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
    <a href="{{ route('teacher.incident-reports.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
        <i class="bi bi-arrow-left"></i> Back to Incident Reports
    </a>
</div>

<!-- Page Header -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--green); margin: 0 0 0.5rem 0;">{{ $incidentReport->case_number }}</h1>
            <p style="color: var(--text-muted); margin: 0;">Submitted {{ $incidentReport->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>
        @if($incidentReport->status == 'pending')
            <span class="modern-badge modern-badge-warning" style="font-size: 0.9rem;"><i class="bi bi-clock-fill"></i> Pending</span>
        @elseif($incidentReport->status == 'ongoing')
            <span class="modern-badge modern-badge-info" style="font-size: 0.9rem;"><i class="bi bi-arrow-repeat"></i> Ongoing</span>
        @else
            <span class="modern-badge modern-badge-success" style="font-size: 0.9rem;"><i class="bi bi-check-circle-fill"></i> Closed</span>
        @endif
    </div>
</div>

<!-- Main Content Grid 2x2 -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
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
                        <div class="user-avatar">{{ strtoupper(substr($incidentReport->student_name, 0, 2)) }}</div>
                        <strong>{{ $incidentReport->student_name }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted d-block mb-1">Age</small>
                    <strong>{{ $incidentReport->student_age ?? '—' }}</strong>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted d-block mb-1"><i class="bi bi-mortarboard me-1"></i>Grade & Section</small>
                    <strong>{{ $incidentReport->grade_section }}</strong>
                </div>
            </div>
            <div class="col-12">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted d-block mb-1"><i class="bi bi-geo-alt me-1"></i>Address</small>
                    <strong>{{ $incidentReport->student_address ?? '—' }}</strong>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted d-block mb-1"><i class="bi bi-calendar me-1"></i>Date of Referral</small>
                    <strong>{{ $incidentReport->date_of_referral->format('M d, Y') }}</strong>
                </div>
            </div>
            @if($incidentReport->time_of_incident)
            <div class="col-sm-6">
                <div class="p-3 bg-light rounded">
                    <small class="text-muted d-block mb-1"><i class="bi bi-clock me-1"></i>Time of Incident</small>
                    <strong>{{ \Carbon\Carbon::parse($incidentReport->time_of_incident)->format('h:i A') }}</strong>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Info -->
    <div class="modern-card" style="padding: 1.5rem;">
        <h6 class="fw-bold mb-3" style="color: var(--navy);">Quick Info</h6>
        <div class="d-flex flex-column gap-3">
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Case Number</small>
                <span class="fw-bold" style="color:#1e7a4a;">{{ $incidentReport->case_number }}</span>
            </div>
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Status</small>
                @if($incidentReport->status == 'pending')
                    <span class="modern-badge modern-badge-warning"><i class="bi bi-clock-fill"></i> Pending</span>
                @elseif($incidentReport->status == 'ongoing')
                    <span class="modern-badge modern-badge-info"><i class="bi bi-arrow-repeat"></i> Ongoing</span>
                @else
                    <span class="modern-badge modern-badge-success"><i class="bi bi-check-circle-fill"></i> Closed</span>
                @endif
            </div>
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Urgency Level</small>
                @if($incidentReport->urgency_level == 'high')
                    <span class="modern-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;"><i class="bi bi-exclamation-circle-fill"></i> High</span>
                @elseif($incidentReport->urgency_level == 'moderate')
                    <span class="modern-badge modern-badge-warning"><i class="bi bi-dash-circle-fill"></i> Moderate</span>
                @else
                    <span class="modern-badge modern-badge-success"><i class="bi bi-check-circle-fill"></i> Low</span>
                @endif
            </div>
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Category</small>
                <span class="fw-semibold small">{{ $incidentReport->incident_category_label }}</span>
            </div>
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Concern Type</small>
                <span class="fw-semibold small">{{ $incidentReport->concern_type_label }}</span>
            </div>
            @if($incidentReport->counselor)
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Assigned Counselor</small>
                <span class="fw-semibold small">{{ $incidentReport->counselor->name }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Incident Details -->
    <div class="modern-card" style="padding: 1.5rem;">
        <h6 class="fw-bold mb-3" style="color: var(--navy);">
            <i class="bi bi-card-text me-2" style="color:#1e7a4a;"></i>Incident Details
        </h6>
        <div class="mb-4">
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                <i class="bi bi-text-paragraph me-1"></i>Incident Description
            </label>
            <div class="p-3 rounded-3" style="background:#f8fafc; white-space:pre-wrap;">{{ $incidentReport->incident_description }}</div>
        </div>
        @if($incidentReport->initial_intervention)
        <div class="mb-0">
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                <i class="bi bi-bandaid me-1"></i>Initial Intervention Conducted
            </label>
            <div class="p-3 rounded-3" style="background:#f0fdf4; border-left:4px solid #22c55e; white-space:pre-wrap;">{{ $incidentReport->initial_intervention }}</div>
        </div>
        @endif
    </div>

    <!-- Referred By -->
    <div class="modern-card" style="padding: 1.5rem;">
        <h6 class="fw-bold mb-3" style="color: var(--navy);">
            <i class="bi bi-person-badge me-2" style="color:#1e7a4a;"></i>Referred By
        </h6>
        <div class="d-flex flex-column gap-3 mb-4">
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Name</small>
                <span class="fw-semibold small">{{ $incidentReport->referred_by_name }}</span>
            </div>
            <div>
                <small class="text-muted d-block" style="font-size:.72rem; text-transform:uppercase; letter-spacing:.4px;">Designation</small>
                <span class="fw-semibold small">{{ $incidentReport->referred_by_designation }}</span>
            </div>
        </div>
        @if($incidentReport->attachment_path)
        <div class="pt-3 border-top">
            <h6 class="fw-bold mb-2" style="color: var(--navy); font-size: 0.9rem;">
                <i class="bi bi-paperclip me-1" style="color:#1e7a4a;"></i>Attachment
            </h6>
            <a href="{{ asset('storage/' . $incidentReport->attachment_path) }}" target="_blank"
               class="modern-btn modern-btn-secondary" style="width: 100%; padding: 0.625rem 1rem; font-size: 0.875rem; justify-content: center;">
                <i class="bi bi-download me-1"></i>{{ $incidentReport->attachment_name }}
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Parent / Guardian Information (Full Width) -->
@if($incidentReport->parent_guardian_name)
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <h6 class="fw-bold mb-3" style="color: var(--navy);">
        <i class="bi bi-house me-2" style="color:#1e7a4a;"></i>Parent / Guardian Information
    </h6>
    <div class="row g-3">
        <div class="col-sm-6">
            <div class="p-3 bg-light rounded">
                <small class="text-muted d-block mb-1">Name</small>
                <strong>{{ $incidentReport->parent_guardian_name }}</strong>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="p-3 bg-light rounded">
                <small class="text-muted d-block mb-1">Contact</small>
                <strong>{{ $incidentReport->parent_guardian_contact ?? '—' }}</strong>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Counselor Notes (Full Width) -->
@if($incidentReport->counselor_notes)
<div class="modern-card" style="padding: 1.5rem; background: #eff6ff; border-left: 4px solid #3b82f6;">
    <h6 class="fw-bold mb-2" style="color: #1e40af;">
        <i class="bi bi-person-check-fill me-1"></i>Counselor Notes
    </h6>
    <p class="mb-0" style="white-space:pre-wrap; color: #1e40af;">{{ $incidentReport->counselor_notes }}</p>
</div>
@endif

@endsection
