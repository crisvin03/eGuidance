@extends('layouts.dashboard')
@section('title', 'Referral Details')

@section('content')

@php
    $badgeMap = [
        'pending' => ['bg'=>'#fef3c7','color'=>'#92400e','border'=>'#fbbf24','label'=>'Pending'],
        'ongoing' => ['bg'=>'#eff6ff','color'=>'#1e40af','border'=>'#93c5fd','label'=>'Ongoing'],
        'closed'  => ['bg'=>'#ecfdf5','color'=>'#065f46','border'=>'#6ee7b7','label'=>'Closed'],
    ];
    $badge = $badgeMap[$studentReferral->status] ?? $badgeMap['pending'];
@endphp

<div class="col-12 mb-3">
    <a href="{{ route('counselor.referrals.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Student Referrals
    </a>
</div>

<div class="row g-4">

    {{-- Left --}}
    <div class="col-md-8">

        {{-- Student Info --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header d-flex align-items-center justify-content-between py-3 px-4"
                 style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0"><i class="bi bi-person me-2" style="color:#20B2AA;"></i>Student Information</h6>
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

        {{-- Referral Details --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0"><i class="bi bi-card-text me-2" style="color:#20B2AA;"></i>Referral Details</h6>
            </div>
            <div class="card-body p-4">
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

        {{-- Counselor Notes --}}
        @if($studentReferral->counselor_notes)
        <div class="alert alert-info mb-4">
            <h6 class="alert-heading fw-semibold"><i class="bi bi-person-check-fill me-1"></i>Counselor Notes</h6>
            <p class="mb-0" style="white-space:pre-wrap;">{{ $studentReferral->counselor_notes }}</p>
        </div>
        @endif
    </div>

    {{-- Right sidebar --}}
    <div class="col-md-4">

        {{-- Update form --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0"><i class="bi bi-reply me-2" style="color:#20B2AA;"></i>Update Status & Notes</h6>
            </div>
            <div class="card-body p-4">
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

        {{-- Quick Info --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0">Quick Info</h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Referral Number</small>
                        <span class="fw-bold" style="color:#20B2AA;">{{ $studentReferral->referral_number }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Status</small>
                        <span class="badge fw-semibold"
                              style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};border:1px solid {{ $badge['border'] }};">
                            {{ $badge['label'] }}
                        </span>
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
