@extends('layouts.dashboard')
@section('title', 'Submit Incident Report')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('teacher.dashboard') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 class="fw-bold mb-0">Submit Incident Report</h5>
        <small class="text-muted">Fill in all required fields. A case number will be auto-generated.</small>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('teacher.incident-reports.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row g-4">

    <!-- Student & Referral Info -->
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-person me-2" style="color:#20B2AA;"></i>Student Information</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Student Name <span class="text-danger">*</span></label>
                        <input type="text" name="student_name" class="form-control" value="{{ old('student_name') }}" placeholder="Full name of student" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Age</label>
                        <input type="number" name="student_age" class="form-control" value="{{ old('student_age') }}" placeholder="e.g. 15" min="1" max="30">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Address</label>
                        <input type="text" name="student_address" class="form-control" value="{{ old('student_address') }}" placeholder="Home address of student">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Grade & Section <span class="text-danger">*</span></label>
                        <input type="text" name="grade_section" class="form-control" value="{{ old('grade_section') }}" placeholder="e.g. Grade 10 - Rizal" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date of Referral <span class="text-danger">*</span></label>
                        <input type="date" name="date_of_referral" class="form-control" value="{{ old('date_of_referral', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Time of Incident</label>
                        <input type="time" name="time_of_incident" class="form-control" value="{{ old('time_of_incident') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incident Classification -->
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-tag me-2" style="color:#20B2AA;"></i>Incident Classification</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Incident Category <span class="text-danger">*</span></label>
                        <select name="incident_category" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <option value="bullying" {{ old('incident_category')=='bullying'?'selected':'' }}>Bullying</option>
                            <option value="behavioral_concern" {{ old('incident_category')=='behavioral_concern'?'selected':'' }}>Behavioral Concern</option>
                            <option value="mental_health" {{ old('incident_category')=='mental_health'?'selected':'' }}>Mental Health Concern</option>
                            <option value="academic_risk" {{ old('incident_category')=='academic_risk'?'selected':'' }}>Academic Risk</option>
                            <option value="child_protection" {{ old('incident_category')=='child_protection'?'selected':'' }}>Child Protection Concern</option>
                            <option value="classroom_incident" {{ old('incident_category')=='classroom_incident'?'selected':'' }}>Classroom Incident</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Concern Type <span class="text-danger">*</span></label>
                        <select name="concern_type" class="form-select" required>
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
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Urgency Level <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 flex-wrap mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="urgency_level" value="low" id="urgLow"
                                    {{ old('urgency_level','low')=='low'?'checked':'' }}>
                                <label class="form-check-label" for="urgLow">
                                    <span class="badge bg-success">Low</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="urgency_level" value="moderate" id="urgMod"
                                    {{ old('urgency_level')=='moderate'?'checked':'' }}>
                                <label class="form-check-label" for="urgMod">
                                    <span class="badge bg-warning">Moderate</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="urgency_level" value="high" id="urgHigh"
                                    {{ old('urgency_level')=='high'?'checked':'' }}>
                                <label class="form-check-label" for="urgHigh">
                                    <span class="badge bg-danger">High</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incident Details -->
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-card-text me-2" style="color:#20B2AA;"></i>Incident Details</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Incident Description <span class="text-danger">*</span></label>
                        <textarea name="incident_description" class="form-control" rows="4" placeholder="Provide a detailed description of the incident..." required>{{ old('incident_description') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Initial Intervention Conducted</label>
                        <textarea name="initial_intervention" class="form-control" rows="3" placeholder="What initial actions were taken before this report?">{{ old('initial_intervention') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Attachment <small class="text-muted">(JPG, PNG, PDF, DOC – max 2MB)</small></label>
                        <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Parent/Guardian -->
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-house me-2" style="color:#20B2AA;"></i>Parent / Guardian Information</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Parent / Guardian Name</label>
                        <input type="text" name="parent_guardian_name" class="form-control" value="{{ old('parent_guardian_name') }}" placeholder="Full name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Number</label>
                        <input type="text" name="parent_guardian_contact" class="form-control" value="{{ old('parent_guardian_contact') }}" placeholder="e.g. 09XX-XXX-XXXX">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Referred By -->
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-person-badge me-2" style="color:#20B2AA;"></i>Referred By</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Teacher Name <span class="text-danger">*</span></label>
                        <input type="text" name="referred_by_name" class="form-control" value="{{ old('referred_by_name', Auth::user()->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Designation <span class="text-danger">*</span></label>
                        <input type="text" name="referred_by_designation" class="form-control" value="{{ old('referred_by_designation') }}" placeholder="e.g. Subject Teacher, Class Adviser" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="col-12">
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn text-white px-4 fw-semibold" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                <i class="bi bi-send me-2"></i>Submit Incident Report
            </button>
        </div>
    </div>

</div>
</form>
@endsection
