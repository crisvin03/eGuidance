@extends('layouts.dashboard')
@section('title', 'Referral Details')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('teacher.referrals.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Referral &mdash; {{ $studentReferral->referral_number }}</h5>
        <small class="text-muted">Submitted {{ $studentReferral->created_at->format('F d, Y \a\t h:i A') }}</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-person me-2" style="color:#20B2AA;"></i>Student Information</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-sm-5">
                        <div class="text-muted small mb-1">Student Name</div>
                        <div class="fw-semibold">{{ $studentReferral->student_name }}</div>
                    </div>
                    <div class="col-sm-2">
                        <div class="text-muted small mb-1">Age</div>
                        <div class="fw-semibold">{{ $studentReferral->student_age ?? '—' }}</div>
                    </div>
                    <div class="col-sm-5">
                        <div class="text-muted small mb-1">Address</div>
                        <div class="fw-semibold">{{ $studentReferral->student_address ?? '—' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small mb-1">Grade & Section</div>
                        <div class="fw-semibold">{{ $studentReferral->grade_section }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-card-text me-2" style="color:#20B2AA;"></i>Referral Details</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="mb-3">
                    <div class="text-muted small mb-1">Reason for Referral</div>
                    <div class="p-3 rounded-3" style="background:#f8fafc;">{{ $studentReferral->reason_for_referral }}</div>
                </div>
                @if($studentReferral->observed_behavior)
                <div class="mb-3">
                    <div class="text-muted small mb-1">Observed Behavior</div>
                    <div class="p-3 rounded-3" style="background:#f8fafc;">{{ $studentReferral->observed_behavior }}</div>
                </div>
                @endif
                @if($studentReferral->actions_taken)
                <div class="mb-3">
                    <div class="text-muted small mb-1">Actions Already Taken</div>
                    <div class="p-3 rounded-3" style="background:#f0fdf4;border-left:4px solid #22c55e;">{{ $studentReferral->actions_taken }}</div>
                </div>
                @endif
                @if($studentReferral->additional_notes)
                <div>
                    <div class="text-muted small mb-1">Additional Notes</div>
                    <div class="p-3 rounded-3" style="background:#f8fafc;">{{ $studentReferral->additional_notes }}</div>
                </div>
                @endif
            </div>
        </div>

        @if($studentReferral->counselor_notes)
        <div class="card border-0 shadow-sm" style="border-radius:16px;border-left:4px solid #20B2AA !important;">
            <div class="card-body px-4 py-3">
                <div class="text-muted small mb-1">Counselor Notes</div>
                <div>{{ $studentReferral->counselor_notes }}</div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-body px-4 py-4">
                <div class="mb-3">
                    <div class="text-muted small mb-1">Referral Number</div>
                    <div class="fw-bold" style="color:#20B2AA;">{{ $studentReferral->referral_number }}</div>
                </div>
                <div class="mb-3">
                    <div class="text-muted small mb-1">Status</div>
                    <span class="badge bg-{{ $studentReferral->status_badge }} text-capitalize px-3 py-2">{{ $studentReferral->status }}</span>
                </div>
                @if($studentReferral->preferred_followup)
                <div class="mb-3">
                    <div class="text-muted small mb-1">Preferred Follow-Up</div>
                    <div class="fw-semibold small">{{ $studentReferral->preferred_followup }}</div>
                </div>
                @endif
                @if($studentReferral->counselor)
                <div class="mb-3">
                    <div class="text-muted small mb-1">Assigned Counselor</div>
                    <div class="fw-semibold small">{{ $studentReferral->counselor->name }}</div>
                </div>
                @endif
                <hr>
                <div>
                    <div class="text-muted small mb-1">Referred By</div>
                    <div class="fw-semibold small">{{ $studentReferral->teacher->name }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
