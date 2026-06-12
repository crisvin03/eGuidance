@extends('layouts.dashboard')
@section('title', 'Talk to Counselor')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Talk to Counselor</h5>
    <small class="text-muted">Contact a guidance counselor for consultation, referral discussions, or student concerns.</small>
</div>

@if($counselors->isEmpty())
    <div class="text-center py-5 text-muted">
        <i class="bi bi-person-x fs-2 d-block mb-2 opacity-50"></i>
        No active counselors found.
    </div>
@else
    <div class="row g-4">
        @foreach($counselors as $counselor)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                <div class="card-body p-4 text-center d-flex flex-column align-items-center">
                    @if($counselor->profile_photo)
                        <img src="{{ asset('storage/' . $counselor->profile_photo) }}"
                             alt="{{ $counselor->name }}"
                             class="rounded-circle mb-3"
                             style="width:80px;height:80px;object-fit:cover;">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 fw-bold fs-4 text-white"
                             style="width:80px;height:80px;background:linear-gradient(135deg,#20B2AA,#008B8B);">
                            {{ strtoupper(substr($counselor->name, 0, 2)) }}
                        </div>
                    @endif
                    <h6 class="fw-bold mb-1">{{ $counselor->name }}</h6>
                    <span class="badge mb-3" style="background:rgba(32,178,170,0.1);color:#20B2AA;">Guidance Counselor</span>
                    <div class="w-100">
                        @if($counselor->email)
                        <a href="mailto:{{ $counselor->email }}" class="btn btn-outline-secondary btn-sm w-100 mb-2">
                            <i class="bi bi-envelope me-2"></i>{{ $counselor->email }}
                        </a>
                        @endif
                        @if($counselor->phone)
                        <a href="tel:{{ $counselor->phone }}" class="btn btn-sm w-100 text-white"
                           style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                            <i class="bi bi-telephone me-2"></i>{{ $counselor->phone }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="alert border-0 mt-4 small" style="border-radius:12px;background:rgba(32,178,170,0.08);border-left:4px solid #20B2AA !important;">
        <i class="bi bi-lightbulb me-2" style="color:#20B2AA;"></i>
        <strong>Tip:</strong> For urgent student concerns, use the
        <a href="{{ route('teacher.incident-reports.create') }}" class="fw-semibold" style="color:#20B2AA;">Incident Report</a>
        or
        <a href="{{ route('teacher.referrals.create') }}" class="fw-semibold" style="color:#20B2AA;">Referral</a>
        forms so the counselor receives an immediate system notification.
    </div>
@endif
@endsection
