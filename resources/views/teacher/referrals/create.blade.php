@extends('layouts.dashboard')
@section('title', 'Refer a Student')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('teacher.dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Refer a Student</h5>
        <small class="text-muted">Formally refer a student to the CARE Center for support or intervention.</small>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('teacher.referrals.store') }}" method="POST">
@csrf
<div class="row g-4">

    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-person me-2" style="color:#20B2AA;"></i>Student Information</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Student Name <span class="text-danger">*</span></label>
                        <input type="text" name="student_name" class="form-control" value="{{ old('student_name') }}" placeholder="Full name of student" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Grade & Section <span class="text-danger">*</span></label>
                        <input type="text" name="grade_section" class="form-control" value="{{ old('grade_section') }}" placeholder="e.g. Grade 9 - Mabini" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-card-text me-2" style="color:#20B2AA;"></i>Referral Details</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Reason for Referral <span class="text-danger">*</span></label>
                        <textarea name="reason_for_referral" class="form-control" rows="3" placeholder="Primary reason for referring this student..." required>{{ old('reason_for_referral') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Observed Behavior</label>
                        <textarea name="observed_behavior" class="form-control" rows="3" placeholder="Describe specific behaviors you have observed...">{{ old('observed_behavior') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Actions Already Taken</label>
                        <textarea name="actions_taken" class="form-control" rows="3" placeholder="What steps have you already taken to address this?">{{ old('actions_taken') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Preferred Follow-Up</label>
                        <input type="text" name="preferred_followup" class="form-control" value="{{ old('preferred_followup') }}" placeholder="e.g. Individual counseling, parent conference">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Additional Notes</label>
                        <textarea name="additional_notes" class="form-control" rows="3" placeholder="Any other relevant information...">{{ old('additional_notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn text-white px-4 fw-semibold" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                <i class="bi bi-send me-2"></i>Submit Referral
            </button>
        </div>
    </div>
</div>
</form>
@endsection
