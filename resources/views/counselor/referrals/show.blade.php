@extends('layouts.dashboard')
@section('title', 'Referral Details')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('counselor.referrals.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Student Referrals
        </a>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ $studentReferral->referral_number }} &mdash; {{ $studentReferral->student_name }}</h5>
                @if($studentReferral->status == 'pending')
                    <span class="badge badge-warning">Pending</span>
                @elseif($studentReferral->status == 'ongoing')
                    <span class="badge badge-info">Ongoing</span>
                @else
                    <span class="badge badge-success">Closed</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-person me-1"></i>Student Name</small>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar">{{ strtoupper(substr($studentReferral->student_name, 0, 2)) }}</div>
                                <strong>{{ $studentReferral->student_name }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-book me-1"></i>Grade & Section</small>
                            <strong>{{ $studentReferral->grade_section }}</strong>
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

                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-text-paragraph me-1"></i>Reason for Referral</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $studentReferral->reason_for_referral }}</p>
                </div>

                @if($studentReferral->observed_behavior)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-eye me-1"></i>Observed Behavior</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $studentReferral->observed_behavior }}</p>
                </div>
                @endif

                @if($studentReferral->actions_taken)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-bandaid me-1"></i>Actions Already Taken</h6>
                    <div class="alert alert-success mb-0">
                        <p class="mb-0" style="white-space:pre-wrap;">{{ $studentReferral->actions_taken }}</p>
                    </div>
                </div>
                @endif

                @if($studentReferral->additional_notes)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-chat-left-text me-1"></i>Additional Notes</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $studentReferral->additional_notes }}</p>
                </div>
                @endif

                @if($studentReferral->counselor_notes)
                <div class="alert alert-info">
                    <h6 class="alert-heading fw-semibold"><i class="bi bi-person-check-fill me-1"></i>Counselor Notes</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $studentReferral->counselor_notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0"><i class="bi bi-reply me-1"></i>Update Status & Notes</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('counselor.referrals.update', $studentReferral) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $studentReferral->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="ongoing" {{ $studentReferral->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="closed" {{ $studentReferral->status == 'closed' ? 'selected' : '' }}>Closed</option>
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

        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Referral Details</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Referral Number</small>
                        <strong style="color:#20B2AA;">{{ $studentReferral->referral_number }}</strong>
                    </div>
                    @if($studentReferral->preferred_followup)
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Preferred Follow-Up</small>
                        <strong>{{ $studentReferral->preferred_followup }}</strong>
                    </div>
                    @endif
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Assigned Counselor</small>
                        <strong>{{ $studentReferral->counselor->name ?? 'Unassigned' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
