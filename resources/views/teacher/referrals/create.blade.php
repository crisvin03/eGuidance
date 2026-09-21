@extends('layouts.dashboard')
@section('title', 'Refer a Student')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    .row.g-3 { gap: 0.5rem !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-person-check-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Refer a Student</h1>
            <p class="modern-page-subtitle">Formally refer a student to the CARE Center for support or intervention.</p>
        </div>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" style="border-radius: 12px;">
        <h6 class="alert-heading fw-bold"><i class="bi bi-exclamation-circle-fill me-2"></i>Please fix the following errors:</h6>
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Main Form -->
<form action="{{ route('teacher.referrals.store') }}" method="POST">
@csrf
        <!-- Student Information -->
        <div class="modern-card mb-4">
            <h6 class="modern-form-section-title">
                <i class="bi bi-person" style="color: var(--green);"></i>
                Student Information
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="modern-form-label">
                        <span>Student Name</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="student_name" class="form-control modern-form-control @error('student_name') is-invalid @enderror" value="{{ old('student_name') }}" placeholder="Full name of student" required>
                    @error('student_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-2">
                    <label class="modern-form-label">
                        <span>Age</span>
                    </label>
                    <input type="number" name="student_age" class="form-control modern-form-control @error('student_age') is-invalid @enderror" value="{{ old('student_age') }}" placeholder="e.g. 15" min="1" max="30">
                    @error('student_age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="modern-form-label">
                        <span>Grade & Section</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="grade_section" class="form-control modern-form-control @error('grade_section') is-invalid @enderror" value="{{ old('grade_section') }}" placeholder="e.g. Grade 9 - Mabini" required>
                    @error('grade_section')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="modern-form-label">
                        <span>Address</span>
                        <span class="text-muted fw-normal">(Optional)</span>
                    </label>
                    <input type="text" name="student_address" class="form-control modern-form-control @error('student_address') is-invalid @enderror" value="{{ old('student_address') }}" placeholder="Home address of student">
                    @error('student_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <!-- Referral Details -->
        <div class="modern-card mb-4">
            <h6 class="modern-form-section-title">
                <i class="bi bi-card-text" style="color: var(--green);"></i>
                Referral Details
            </h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="modern-form-label">
                        <span>Category for Monitoring and Referral</span>
                        <span class="text-danger">*</span>
                    </label>
                    <select name="referral_category" class="form-select modern-form-control @error('referral_category') is-invalid @enderror" required>
                        <option value="">Select category...</option>
                        <option value="Not applicable">Not applicable</option>
                        <option value="Indigenous Peoples (IP) Learners">Indigenous Peoples (IP) Learners</option>
                        <option value="Muslim Learners">Muslim Learners</option>
                        <option value="Learners with Disabilities (LWDs)">Learners with Disabilities (LWDs)</option>
                        <option value="LGBTQIA+ Learners">LGBTQIA+ Learners</option>
                        <option value="Pregnant Learners">Pregnant Learners</option>
                        <option value="Young Mothers and Fathers">Young Mothers and Fathers</option>
                        <option value="Children in Conflict with the Law (CICL)">Children in Conflict with the Law (CICL)</option>
                        <option value="Learners at Risk of Dropping Out (LARDOs)">Learners at Risk of Dropping Out (LARDOs)</option>
                        <option value="Learner-Victims of Violence Against Women and Their Children (VAWC)">Learner-Victims of Violence Against Women and Their Children (VAWC)</option>
                        <option value="Learner-Victims of Child Abuse, Neglect, Exploitation, and Other Criminal Acts">Learner-Victims of Child Abuse, Neglect, Exploitation, and Other Criminal Acts</option>
                        <option value="Learners Affected by Natural Calamities, Armed Conflict, and Other Emergencies">Learners Affected by Natural Calamities, Armed Conflict, and Other Emergencies</option>
                        <option value="Learners Experiencing Psychosocial Distress or Recent Traumatic Events">Learners Experiencing Psychosocial Distress or Recent Traumatic Events</option>
                        <option value="Learners Requiring Mental Health and Psychosocial Support (MHPSS)">Learners Requiring Mental Health and Psychosocial Support (MHPSS)</option>
                        <option value="Learners with Chronic Health Conditions or Special Medical Needs">Learners with Chronic Health Conditions or Special Medical Needs</option>
                        <option value="Other Learners Requiring Specialized Intervention and Support">Other Learners Requiring Specialized Intervention and Support</option>
                    </select>
                    <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                        <i class="bi bi-info-circle me-1"></i>
                        Select the appropriate category for monitoring and referral purposes
                    </small>
                    @error('referral_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="modern-form-label">
                        <span>Reason for Referral</span>
                        <span class="text-danger">*</span>
                    </label>
                    <textarea name="reason_for_referral" class="form-control modern-form-control @error('reason_for_referral') is-invalid @enderror" rows="4" placeholder="Primary reason for referring this student..." required>{{ old('reason_for_referral') }}</textarea>
                    @error('reason_for_referral')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="modern-form-label">
                        <span>Observed Behavior</span>
                        <span class="text-muted fw-normal">(Optional)</span>
                    </label>
                    <textarea name="observed_behavior" class="form-control modern-form-control @error('observed_behavior') is-invalid @enderror" rows="3" placeholder="Describe specific behaviors you have observed...">{{ old('observed_behavior') }}</textarea>
                    @error('observed_behavior')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="modern-form-label">
                        <span>Actions Already Taken</span>
                        <span class="text-muted fw-normal">(Optional)</span>
                    </label>
                    <textarea name="actions_taken" class="form-control modern-form-control @error('actions_taken') is-invalid @enderror" rows="3" placeholder="What steps have you already taken to address this?">{{ old('actions_taken') }}</textarea>
                    @error('actions_taken')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="modern-form-label">
                        <span>Preferred Follow-Up</span>
                        <span class="text-muted fw-normal">(Optional)</span>
                    </label>
                    <input type="text" name="preferred_followup" class="form-control modern-form-control @error('preferred_followup') is-invalid @enderror" value="{{ old('preferred_followup') }}" placeholder="e.g. Individual counseling">
                    @error('preferred_followup')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="modern-form-label">
                        <span>Additional Notes</span>
                        <span class="text-muted fw-normal">(Optional)</span>
                    </label>
                    <textarea name="additional_notes" class="form-control modern-form-control @error('additional_notes') is-invalid @enderror" rows="3" placeholder="Any other relevant information...">{{ old('additional_notes') }}</textarea>
                    @error('additional_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-3 flex-wrap">
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-send-fill"></i>
                Submit Referral
            </button>
            <a href="{{ route('teacher.dashboard') }}" class="modern-btn modern-btn-outline" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-arrow-left"></i>
                Cancel
            </a>
        </div>

</form>
@endsection
