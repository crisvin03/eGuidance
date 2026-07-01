@extends('layouts.dashboard')
@section('title', 'Talk to Counselor')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Talk to Counselor</h5>
    <small class="text-muted">Schedule an appointment with a guidance counselor for consultation, referral discussions, or student concerns.</small>
</div>

<!-- Schedule Appointment Section -->
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h6 class="fw-bold mb-0"><i class="bi bi-calendar-plus me-2" style="color:#20B2AA;"></i>Schedule an Appointment</h6>
    </div>
    <div class="card-body px-4 pb-4">
        <form method="POST" action="{{ route('teacher.appointments.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Select Counselor <span class="text-danger">*</span></label>
                    <select name="counselor_id" class="form-select" required>
                        <option value="">Choose a counselor...</option>
                        @foreach($counselors as $counselor)
                            <option value="{{ $counselor->id }}">{{ $counselor->name }}</option>
                        @endforeach
                    </select>
                    @error('counselor_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="appointment_date" class="form-control"
                           min="{{ now()->addHour()->format('Y-m-d\TH:i') }}" required>
                    @error('appointment_date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Purpose/Notes</label>
                    <input type="text" name="notes" class="form-control" placeholder="Brief reason for the meeting..." maxlength="500">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn text-white fw-semibold" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                        <i class="bi bi-calendar-check me-1"></i> Schedule Appointment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- My Appointments Link -->
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-body px-4 py-3 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-circle"
                 style="width:46px;height:46px;min-width:46px;background:rgba(32,178,170,0.10);">
                <i class="bi bi-calendar3 fs-5" style="color:#20B2AA;"></i>
            </div>
            <div>
                <div class="fw-bold mb-0" style="font-size:0.95rem;">My Appointments</div>
                <small class="text-muted">View all your scheduled and past counselor appointments.</small>
            </div>
        </div>
        <a href="{{ route('teacher.appointments.index') }}"
           class="btn btn-sm text-white fw-semibold flex-shrink-0"
           style="background:linear-gradient(135deg,#20B2AA,#008B8B);border-radius:10px;">
            <i class="bi bi-arrow-right me-1"></i> View Appointments
        </a>
    </div>
</div>

<!-- Available Counselors -->
<h6 class="fw-bold text-muted mb-3"><i class="bi bi-people me-2"></i>Available Counselors</h6>
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
@endif

<div class="alert border-0 mt-4 small" style="border-radius:12px;background:rgba(32,178,170,0.08);border-left:4px solid #20B2AA !important;">
    <i class="bi bi-lightbulb me-2" style="color:#20B2AA;"></i>
    <strong>Tip:</strong> For urgent student concerns, use the
    <a href="{{ route('teacher.incident-reports.create') }}" class="fw-semibold" style="color:#20B2AA;">Incident Report</a>
    or
    <a href="{{ route('teacher.referrals.create') }}" class="fw-semibold" style="color:#20B2AA;">Referral</a>
    forms so the counselor receives an immediate system notification.
</div>
@endsection
