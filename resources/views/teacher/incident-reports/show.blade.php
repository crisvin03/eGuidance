@extends('layouts.dashboard')
@section('title', 'Incident Report Details')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('teacher.incident-reports.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Incident Report &mdash; {{ $incidentReport->case_number }}</h5>
        <small class="text-muted">Submitted {{ $incidentReport->created_at->format('F d, Y \a\t h:i A') }}</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Student Info -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-person me-2" style="color:#20B2AA;"></i>Student Information</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-sm-5">
                        <div class="text-muted small mb-1">Student Name</div>
                        <div class="fw-semibold">{{ $incidentReport->student_name }}</div>
                    </div>
                    <div class="col-sm-2">
                        <div class="text-muted small mb-1">Age</div>
                        <div class="fw-semibold">{{ $incidentReport->student_age ?? '—' }}</div>
                    </div>
                    <div class="col-sm-5">
                        <div class="text-muted small mb-1">Address</div>
                        <div class="fw-semibold">{{ $incidentReport->student_address ?? '—' }}</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-muted small mb-1">Grade & Section</div>
                        <div class="fw-semibold">{{ $incidentReport->grade_section }}</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-muted small mb-1">Date of Referral</div>
                        <div class="fw-semibold">{{ $incidentReport->date_of_referral->format('M d, Y') }}</div>
                    </div>
                    @if($incidentReport->time_of_incident)
                    <div class="col-sm-4">
                        <div class="text-muted small mb-1">Time of Incident</div>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($incidentReport->time_of_incident)->format('h:i A') }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Incident Details -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-card-text me-2" style="color:#20B2AA;"></i>Incident Details</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="mb-3">
                    <div class="text-muted small mb-1">Incident Description</div>
                    <div class="p-3 rounded-3" style="background:#f8fafc;">{{ $incidentReport->incident_description }}</div>
                </div>
                @if($incidentReport->initial_intervention)
                <div>
                    <div class="text-muted small mb-1">Initial Intervention Conducted</div>
                    <div class="p-3 rounded-3" style="background:#f0fdf4;border-left:4px solid #22c55e;">{{ $incidentReport->initial_intervention }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Parent / Guardian -->
        @if($incidentReport->parent_guardian_name)
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-house me-2" style="color:#20B2AA;"></i>Parent / Guardian</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="text-muted small mb-1">Name</div>
                        <div class="fw-semibold">{{ $incidentReport->parent_guardian_name }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small mb-1">Contact</div>
                        <div class="fw-semibold">{{ $incidentReport->parent_guardian_contact ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Counselor Notes -->
        @if($incidentReport->counselor_notes)
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;border-left:4px solid #20B2AA !important;">
            <div class="card-body px-4 py-3">
                <div class="text-muted small mb-1">Counselor Notes</div>
                <div>{{ $incidentReport->counselor_notes }}</div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Status Card -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-body px-4 py-4">
                <div class="mb-3">
                    <div class="text-muted small mb-1">Case Number</div>
                    <div class="fw-bold fs-6" style="color:#20B2AA;">{{ $incidentReport->case_number }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small mb-1">Status</div>
                    <span class="badge bg-{{ $incidentReport->status_badge }} text-capitalize px-3 py-2">{{ $incidentReport->status }}</span>
                </div>
                <div class="mb-3">
                    <div class="text-muted small mb-1">Urgency Level</div>
                    <span class="badge bg-{{ $incidentReport->urgency_badge }} text-capitalize px-3 py-2">{{ $incidentReport->urgency_level }}</span>
                </div>
                <div class="mb-3">
                    <div class="text-muted small mb-1">Category</div>
                    <div class="fw-semibold small">{{ $incidentReport->incident_category_label }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small mb-1">Concern Type</div>
                    <div class="fw-semibold small">{{ $incidentReport->concern_type_label }}</div>
                </div>
                @if($incidentReport->counselor)
                <div class="mb-3">
                    <div class="text-muted small mb-1">Assigned Counselor</div>
                    <div class="fw-semibold small">{{ $incidentReport->counselor->name }}</div>
                </div>
                @endif
                @if($incidentReport->attachment_path)
                <hr>
                <div>
                    <div class="text-muted small mb-2">Attachment</div>
                    <a href="{{ asset('storage/' . $incidentReport->attachment_path) }}" target="_blank"
                       class="btn btn-sm btn-outline-secondary w-100">
                        <i class="bi bi-paperclip me-1"></i>{{ $incidentReport->attachment_name }}
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Referred By -->
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-body px-4 py-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-person-badge me-2" style="color:#20B2AA;"></i>Referred By</h6>
                <div class="mb-2">
                    <div class="text-muted small">Name</div>
                    <div class="fw-semibold">{{ $incidentReport->referred_by_name }}</div>
                </div>
                <div>
                    <div class="text-muted small">Designation</div>
                    <div class="fw-semibold">{{ $incidentReport->referred_by_designation }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
