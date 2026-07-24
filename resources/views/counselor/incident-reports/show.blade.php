@extends('layouts.dashboard')
@section('title', 'Incident Report Details')

@section('content')

@php
    $badgeMap = [
        'pending' => ['bg'=>'#fef3c7','color'=>'#92400e','border'=>'#fbbf24','label'=>'Pending'],
        'ongoing' => ['bg'=>'#eff6ff','color'=>'#1e40af','border'=>'#93c5fd','label'=>'Ongoing'],
        'closed'  => ['bg'=>'#ecfdf5','color'=>'#065f46','border'=>'#6ee7b7','label'=>'Closed'],
    ];
    $badge = $badgeMap[$incidentReport->status] ?? $badgeMap['pending'];
@endphp

{{-- Back + header --}}
<div class="col-12 mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
    <a href="{{ route('counselor.incident-reports.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Incident Reports
    </a>
</div>

<div class="row g-4">

    {{-- Left: main content --}}
    <div class="col-md-8">

        {{-- Student Info --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header d-flex align-items-center justify-content-between py-3 px-4"
                 style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-person me-2" style="color:#1e7a4a;"></i>Student Information
                </h6>
                <span class="badge fw-semibold px-3 py-2"
                      style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};border:1px solid {{ $badge['border'] }};font-size:.8rem;">
                    {{ $badge['label'] }}
                </span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-person me-1"></i>Student Name</small>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar">{{ strtoupper(substr($incidentReport->student_name, 0, 2)) }}</div>
                                <strong>{{ $incidentReport->student_name }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-123 me-1"></i>Age</small>
                            <strong>{{ $incidentReport->student_age ?? '—' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-book me-1"></i>Grade & Section</small>
                            <strong>{{ $incidentReport->grade_section }}</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-geo-alt me-1"></i>Address</small>
                            <strong>{{ $incidentReport->student_address ?? '—' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-calendar me-1"></i>Date of Referral</small>
                            <strong>{{ $incidentReport->date_of_referral->format('M d, Y') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-clock me-1"></i>Time of Incident</small>
                            <strong>{{ $incidentReport->time_of_incident ? \Carbon\Carbon::parse($incidentReport->time_of_incident)->format('h:i A') : '—' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-person-badge me-1"></i>Submitted By</small>
                            <strong>{{ $incidentReport->teacher->name ?? '—' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-tag me-1"></i>Category</small>
                            <span class="badge bg-info">{{ $incidentReport->incident_category_label }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-chat-dots me-1"></i>Concern Type</small>
                            <strong>{{ $incidentReport->concern_type_label }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Incident Details --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0"><i class="bi bi-card-text me-2" style="color:#1e7a4a;"></i>Incident Details</h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-text-paragraph me-1"></i>Incident Description</h6>
                    <div class="p-3 rounded-3" style="background:#f8fafc;white-space:pre-wrap;">{{ $incidentReport->incident_description }}</div>
                </div>
                @if($incidentReport->initial_intervention)
                <div class="mb-0">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-bandaid me-1"></i>Initial Intervention Conducted</h6>
                    <div class="alert alert-success mb-0" style="white-space:pre-wrap;">{{ $incidentReport->initial_intervention }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Parent / Guardian --}}
        @if($incidentReport->parent_guardian_name)
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0"><i class="bi bi-house me-2" style="color:#1e7a4a;"></i>Parent / Guardian</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">Name</small>
                            <strong>{{ $incidentReport->parent_guardian_name }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">Contact</small>
                            <strong>{{ $incidentReport->parent_guardian_contact ?? '—' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Attachment --}}
        @if($incidentReport->attachment_path)
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0"><i class="bi bi-paperclip me-2" style="color:#1e7a4a;"></i>Attachment</h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 p-3 border rounded bg-light">
                    <i class="bi bi-file-earmark-text fs-2" style="color:#6366f1;"></i>
                    <div>
                        <div class="fw-semibold">{{ $incidentReport->attachment_name ?? 'Attachment' }}</div>
                        <small class="text-muted">{{ strtoupper(pathinfo($incidentReport->attachment_name ?? '', PATHINFO_EXTENSION)) }} file</small>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ asset('storage/' . $incidentReport->attachment_path) }}" target="_blank"
                           class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-box-arrow-up-right me-1"></i>View
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Counselor Notes --}}
        @if($incidentReport->counselor_notes)
        <div class="alert alert-info mb-4">
            <h6 class="alert-heading fw-semibold"><i class="bi bi-person-check-fill me-1"></i>Counselor Notes</h6>
            <p class="mb-0" style="white-space:pre-wrap;">{{ $incidentReport->counselor_notes }}</p>
        </div>
        @endif
    </div>

    {{-- Right sidebar --}}
    <div class="col-md-4">

        {{-- Update form --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0"><i class="bi bi-reply me-2" style="color:#1e7a4a;"></i>Update Status & Notes</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('counselor.incident-reports.update', $incidentReport) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            <option value="pending"  {{ $incidentReport->status === 'pending'  ? 'selected' : '' }}>Pending</option>
                            <option value="ongoing"  {{ $incidentReport->status === 'ongoing'  ? 'selected' : '' }}>Ongoing</option>
                            <option value="closed"   {{ $incidentReport->status === 'closed'   ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Counselor Notes</label>
                        <textarea class="form-control" name="counselor_notes" rows="4"
                                  placeholder="Add observations, recommendations, or follow-up actions...">{{ $incidentReport->counselor_notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg me-1"></i> Update Report
                    </button>
                </form>
            </div>
        </div>

        {{-- Quick Info --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0">Quick Info</h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Case Number</small>
                        <span class="fw-bold" style="color:#1e7a4a;">{{ $incidentReport->case_number }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Urgency Level</small>
                        <span class="badge bg-{{ $incidentReport->urgency_badge }} text-capitalize">{{ $incidentReport->urgency_level }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Status</small>
                        <span class="badge fw-semibold"
                              style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};border:1px solid {{ $badge['border'] }};">
                            {{ $badge['label'] }}
                        </span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Assigned Counselor</small>
                        <span class="fw-semibold small">{{ $incidentReport->counselor->name ?? 'Unassigned' }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Date Submitted</small>
                        <span class="fw-semibold small">{{ $incidentReport->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Referred By --}}
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0"><i class="bi bi-person-badge me-2" style="color:#1e7a4a;"></i>Referred By</h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Name</small>
                        <span class="fw-semibold small">{{ $incidentReport->referred_by_name }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Designation</small>
                        <span class="fw-semibold small">{{ $incidentReport->referred_by_designation }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
