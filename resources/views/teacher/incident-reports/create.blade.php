@extends('layouts.dashboard')
@section('title', 'Submit Incident Report')

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
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Submit Incident Report</h1>
            <p class="modern-page-subtitle">Fill in all required fields. A case number will be auto-generated.</p>
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
<form action="{{ route('teacher.incident-reports.store') }}" method="POST" enctype="multipart/form-data">
@csrf
        <!-- Student Information -->
        <div class="modern-card mb-4">
            <h6 class="modern-form-section-title">
                <i class="bi bi-person" style="color: var(--green);"></i>
                Student Information
            </h6>
            <div class="row g-3">
                <div class="col-md-5">
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
                <div class="col-md-5">
                    <label class="modern-form-label">
                        <span>Address</span>
                    </label>
                    <input type="text" name="student_address" class="form-control modern-form-control @error('student_address') is-invalid @enderror" value="{{ old('student_address') }}" placeholder="Home address">
                    @error('student_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="modern-form-label">
                        <span>Grade & Section</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="grade_section" class="form-control modern-form-control @error('grade_section') is-invalid @enderror" value="{{ old('grade_section') }}" placeholder="e.g. Grade 10 - Rizal" required>
                    @error('grade_section')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="modern-form-label">
                        <span>Date of Referral</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="date_of_referral" class="form-control modern-form-control @error('date_of_referral') is-invalid @enderror" value="{{ old('date_of_referral', date('Y-m-d')) }}" required>
                    @error('date_of_referral')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="modern-form-label">
                        <span>Time of Incident</span>
                    </label>
                    <input type="time" name="time_of_incident" class="form-control modern-form-control @error('time_of_incident') is-invalid @enderror" value="{{ old('time_of_incident') }}">
                    @error('time_of_incident')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <!-- Incident Classification -->
        <div class="modern-card mb-4">
            <h6 class="modern-form-section-title">
                <i class="bi bi-tag" style="color: var(--green);"></i>
                Incident Classification
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="modern-form-label">
                        <span>Incident Category</span>
                        <span class="text-danger">*</span>
                    </label>
                    <select name="incident_category" class="form-select modern-form-control @error('incident_category') is-invalid @enderror" required>
                        <option value="">-- Select Category --</option>
                        <option value="bullying" {{ old('incident_category')=='bullying'?'selected':'' }}>Bullying</option>
                        <option value="behavioral_concern" {{ old('incident_category')=='behavioral_concern'?'selected':'' }}>Behavioral Concern</option>
                        <option value="mental_health" {{ old('incident_category')=='mental_health'?'selected':'' }}>Mental Health Concern</option>
                        <option value="academic_risk" {{ old('incident_category')=='academic_risk'?'selected':'' }}>Academic Risk</option>
                        <option value="child_protection" {{ old('incident_category')=='child_protection'?'selected':'' }}>Child Protection Concern</option>
                        <option value="classroom_incident" {{ old('incident_category')=='classroom_incident'?'selected':'' }}>Classroom Incident</option>
                    </select>
                    @error('incident_category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="modern-form-label">
                        <span>Concern Type</span>
                        <span class="text-danger">*</span>
                    </label>
                    <select name="concern_type" class="form-select modern-form-control @error('concern_type') is-invalid @enderror" required>
                        <option value="">-- Select Concern Type --</option>
                        <option value="academic" {{ old('concern_type')=='academic'?'selected':'' }}>Academic</option>
                        <option value="emotional_mental" {{ old('concern_type')=='emotional_mental'?'selected':'' }}>Emotional and Mental Wellness</option>
                        <option value="social_peer" {{ old('concern_type')=='social_peer'?'selected':'' }}>Social and Peer</option>
                        <option value="family" {{ old('concern_type')=='family'?'selected':'' }}>Family</option>
                        <option value="behavioral" {{ old('concern_type')=='behavioral'?'selected':'' }}>Behavioral</option>
                        <option value="personal_relationship" {{ old('concern_type')=='personal_relationship'?'selected':'' }}>Personal and Relationship</option>
                        <option value="bullying_safety" {{ old('concern_type')=='bullying_safety'?'selected':'' }}>Bullying/Safety</option>
                        <option value="career_future" {{ old('concern_type')=='career_future'?'selected':'' }}>Career and Future</option>
                        <option value="counseling_support" {{ old('concern_type')=='counseling_support'?'selected':'' }}>Counseling and Support</option>
                    </select>
                    @error('concern_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="modern-form-label">
                        <span>Urgency Level</span>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="d-flex gap-3 flex-wrap mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="urgency_level" value="low" id="urgLow"
                                {{ old('urgency_level','low')=='low'?'checked':'' }}>
                            <label class="form-check-label" for="urgLow">
                                <span class="modern-badge modern-badge-success"><i class="bi bi-check-circle-fill"></i> Low</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="urgency_level" value="moderate" id="urgMod"
                                {{ old('urgency_level')=='moderate'?'checked':'' }}>
                            <label class="form-check-label" for="urgMod">
                                <span class="modern-badge modern-badge-warning"><i class="bi bi-dash-circle-fill"></i> Moderate</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="urgency_level" value="high" id="urgHigh"
                                {{ old('urgency_level')=='high'?'checked':'' }}>
                            <label class="form-check-label" for="urgHigh">
                                <span class="modern-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;"><i class="bi bi-exclamation-circle-fill"></i> High</span>
                            </label>
                        </div>
                    </div>
                    @error('urgency_level')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <!-- Incident Details -->
        <div class="modern-card mb-4">
            <h6 class="modern-form-section-title">
                <i class="bi bi-card-text" style="color: var(--green);"></i>
                Incident Details
            </h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="modern-form-label">
                        <span>Incident Description</span>
                        <span class="text-danger">*</span>
                    </label>
                    <textarea name="incident_description" class="form-control modern-form-control @error('incident_description') is-invalid @enderror" rows="5" placeholder="Provide a detailed description of the incident..." required>{{ old('incident_description') }}</textarea>
                    <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                        <i class="bi bi-info-circle me-1"></i>
                        Include what happened, when, where, and who was involved
                    </small>
                    @error('incident_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="modern-form-label">
                        <span>Initial Intervention Conducted</span>
                        <span class="text-muted fw-normal">(Optional)</span>
                    </label>
                    <textarea name="initial_intervention" class="form-control modern-form-control @error('initial_intervention') is-invalid @enderror" rows="3" placeholder="What initial actions were taken before this report?">{{ old('initial_intervention') }}</textarea>
                    @error('initial_intervention')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="modern-form-label">
                        <span>Attachment</span>
                        <span class="text-muted fw-normal">(Optional)</span>
                    </label>
                    <input type="file" name="attachment" class="form-control modern-form-control @error('attachment') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                    <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
                        <i class="bi bi-file-earmark me-1"></i>
                        JPG, PNG, PDF, DOC • Max 2MB
                    </small>
                    @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <!-- Parent/Guardian Information -->
        <div class="modern-card mb-4">
            <h6 class="modern-form-section-title">
                <i class="bi bi-house" style="color: var(--green);"></i>
                Parent / Guardian Information
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="modern-form-label">
                        <span>Parent / Guardian Name</span>
                        <span class="text-muted fw-normal">(Optional)</span>
                    </label>
                    <input type="text" name="parent_guardian_name" class="form-control modern-form-control @error('parent_guardian_name') is-invalid @enderror" value="{{ old('parent_guardian_name') }}" placeholder="Full name">
                    @error('parent_guardian_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="modern-form-label">
                        <span>Contact Number</span>
                        <span class="text-muted fw-normal">(Optional)</span>
                    </label>
                    <input type="text" name="parent_guardian_contact" class="form-control modern-form-control @error('parent_guardian_contact') is-invalid @enderror" value="{{ old('parent_guardian_contact') }}" placeholder="e.g. 09XX-XXX-XXXX">
                    @error('parent_guardian_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <!-- Referred By -->
        <div class="modern-card mb-4">
            <h6 class="modern-form-section-title">
                <i class="bi bi-person-badge" style="color: var(--green);"></i>
                Referred By
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="modern-form-label">
                        <span>Teacher Name</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="referred_by_name" class="form-control modern-form-control @error('referred_by_name') is-invalid @enderror" value="{{ old('referred_by_name', Auth::user()->name) }}" required>
                    @error('referred_by_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="modern-form-label">
                        <span>Designation</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="referred_by_designation" class="form-control modern-form-control @error('referred_by_designation') is-invalid @enderror" value="{{ old('referred_by_designation') }}" placeholder="e.g. Subject Teacher, Class Adviser" required>
                    @error('referred_by_designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-3 flex-wrap">
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-send-fill"></i>
                Submit Incident Report
            </button>
            <a href="{{ route('teacher.dashboard') }}" class="modern-btn modern-btn-outline" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-arrow-left"></i>
                Cancel
            </a>
        </div>

</form>
@endsection
