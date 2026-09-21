@extends('layouts.dashboard')

@section('title', 'Learner Reintegration Clearance')

@section('content')
@include('student.partials.modern-styles')

<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('student.new-here') }}" class="modern-btn modern-btn-secondary">
        <i class="bi bi-arrow-left"></i>
        <span>Back</span>
    </a>
</div>

<!-- Page Header -->
<div class="modern-card mb-4" style="text-align: center; padding: 2rem;">
    <h2 class="fw-bold mb-2" style="color: var(--green); font-size: 1.75rem;">LEARNER REINTEGRATION CLEARANCE</h2>
    <p class="text-muted mb-0" style="font-size: 1.05rem;">For Return to Regular Classroom Participation</p>
</div>

<form method="POST" action="{{ route('student.new-here.submit') }}">
    @csrf

    <!-- Basic Information -->
    <div class="modern-card mb-4">
        <h6 class="fw-bold mb-3" style="color: #111827;">
            <i class="bi bi-person-fill me-2" style="color: var(--green);"></i>Learner Information
        </h6>
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Name of Learner <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input @error('learner_name') is-invalid @enderror" 
                       name="learner_name" value="{{ old('learner_name', auth()->user()->name) }}" required>
                @error('learner_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Grade & Section <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input @error('grade_section') is-invalid @enderror" 
                       name="grade_section" value="{{ old('grade_section') }}" 
                       placeholder="e.g., Grade 11 - STEM A" required>
                @error('grade_section')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Reason for Intervention/Suspension <span class="text-danger">*</span></label>
                <input type="text" class="form-control modern-input @error('reason') is-invalid @enderror" 
                       name="reason" value="{{ old('reason') }}" 
                       placeholder="Brief description" required>
                @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Date of Return <span class="text-danger">*</span></label>
                <input type="date" class="form-control modern-input @error('return_date') is-invalid @enderror" 
                       name="return_date" value="{{ old('return_date') }}" required>
                @error('return_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Reintegration Checklist -->
    <div class="modern-card mb-4">
        <h6 class="fw-bold mb-3" style="color: #111827;">
            <i class="bi bi-clipboard-check me-2" style="color: var(--green);"></i>Reintegration Checklist
        </h6>
        <p class="text-muted small mb-3">Please indicate your understanding and readiness for each requirement:</p>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead style="background: rgba(30, 122, 74, 0.08);">
                    <tr>
                        <th style="width: 50%;">Requirement</th>
                        <th style="width: 10%; text-align: center;">Aware</th>
                        <th style="width: 40%;">Remarks (Optional)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>1. Case Review</strong><br>
                            <small class="text-muted">I understand my situation will be reviewed.</small>
                        </td>
                        <td style="text-align: center;">
                            <input type="checkbox" class="form-check-input" name="checklist[case_review]" value="1" {{ old('checklist.case_review') ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" name="remarks[case_review]" value="{{ old('remarks.case_review') }}" placeholder="Optional notes">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>2. Intervention</strong><br>
                            <small class="text-muted">I am willing to receive appropriate intervention or support.</small>
                        </td>
                        <td style="text-align: center;">
                            <input type="checkbox" class="form-check-input" name="checklist[intervention]" value="1" {{ old('checklist.intervention') ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" name="remarks[intervention]" value="{{ old('remarks.intervention') }}" placeholder="Optional notes">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>3. Learner Conference</strong><br>
                            <small class="text-muted">I am prepared to attend orientation regarding expectations.</small>
                        </td>
                        <td style="text-align: center;">
                            <input type="checkbox" class="form-check-input" name="checklist[conference]" value="1" {{ old('checklist.conference') ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" name="remarks[conference]" value="{{ old('remarks.conference') }}" placeholder="Optional notes">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>4. Parent Coordination</strong><br>
                            <small class="text-muted">My parent/guardian has been informed or will be consulted.</small>
                        </td>
                        <td style="text-align: center;">
                            <input type="checkbox" class="form-check-input" name="checklist[parent_coord]" value="1" {{ old('checklist.parent_coord') ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" name="remarks[parent_coord]" value="{{ old('remarks.parent_coord') }}" placeholder="Optional notes">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>5. Readiness Assessment</strong><br>
                            <small class="text-muted">I believe I am ready to return with appropriate support.</small>
                        </td>
                        <td style="text-align: center;">
                            <input type="checkbox" class="form-check-input" name="checklist[readiness]" value="1" {{ old('checklist.readiness') ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" name="remarks[readiness]" value="{{ old('remarks.readiness') }}" placeholder="Optional notes">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>6. Follow-Up Plan</strong><br>
                            <small class="text-muted">I understand monitoring or follow-up support may be needed.</small>
                        </td>
                        <td style="text-align: center;">
                            <input type="checkbox" class="form-check-input" name="checklist[followup]" value="1" {{ old('checklist.followup') ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm" name="remarks[followup]" value="{{ old('remarks.followup') }}" placeholder="Optional notes">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Support Needs -->
    <div class="modern-card mb-4">
        <h6 class="fw-bold mb-3" style="color: #111827;">
            <i class="bi bi-hand-thumbs-up me-2" style="color: var(--green);"></i>Follow-Up Support Needed
        </h6>
        <p class="text-muted small mb-3">Select any support you feel you might need:</p>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="support[]" value="counseling" id="support1" {{ in_array('counseling', old('support', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="support1">
                        <i class="bi bi-chat-dots text-primary me-1"></i> Counseling Follow-Up
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="support[]" value="teacher_monitoring" id="support2" {{ in_array('teacher_monitoring', old('support', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="support2">
                        <i class="bi bi-person-video3 text-success me-1"></i> Teacher Monitoring
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="support[]" value="parent_coordination" id="support3" {{ in_array('parent_coordination', old('support', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="support3">
                        <i class="bi bi-people text-info me-1"></i> Parent/Guardian Coordination
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="support[]" value="behavior_monitoring" id="support4" {{ in_array('behavior_monitoring', old('support', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="support4">
                        <i class="bi bi-clipboard-check text-warning me-1"></i> Behavior Monitoring
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="support[]" value="academic_support" id="support5" {{ in_array('academic_support', old('support', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="support5">
                        <i class="bi bi-book text-danger me-1"></i> Academic Support
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="support[]" value="other" id="support6" onclick="toggleOtherSupport()" {{ in_array('other', old('support', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="support6">
                        <i class="bi bi-three-dots text-secondary me-1"></i> Other
                    </label>
                </div>
            </div>
        </div>

        <div id="otherSupportField" class="mt-3" style="display: {{ in_array('other', old('support', [])) ? 'block' : 'none' }};">
            <label class="form-label fw-semibold">Please specify:</label>
            <input type="text" class="form-control modern-input" name="other_support" value="{{ old('other_support') }}" placeholder="Describe the support you need">
        </div>
    </div>

    <!-- Additional Comments -->
    <div class="modern-card mb-4">
        <h6 class="fw-bold mb-3" style="color: #111827;">
            <i class="bi bi-chat-left-text me-2" style="color: var(--green);"></i>Additional Comments or Concerns (Optional)
        </h6>
        <textarea class="form-control modern-input" name="additional_comments" rows="5" placeholder="Share any additional information that might help the counselor understand your situation better...">{{ old('additional_comments') }}</textarea>
    </div>

    <!-- Submit Button -->
    <div class="d-grid gap-2 mb-4">
        <button type="submit" class="modern-btn modern-btn-primary" style="padding: 1rem; font-size: 1.05rem; justify-content: center;">
            <i class="bi bi-send-fill"></i>
            <span>Submit Reintegration Clearance Form</span>
        </button>
        <a href="{{ route('student.new-here') }}" class="modern-btn modern-btn-secondary" style="padding: 1rem; font-size: 1.05rem; justify-content: center;">
            <i class="bi bi-x-circle"></i>
            <span>Cancel</span>
        </a>
    </div>

    <!-- Note -->
    <div class="alert" style="background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 12px;">
        <h6 class="fw-bold mb-2" style="color: #3b82f6;">
            <i class="bi bi-info-circle-fill me-2"></i>Important Note
        </h6>
        <small class="text-muted">
            This clearance request will be reviewed by the guidance counselor. The final clearance decision will be based on your current assessment and intervention outcomes. You may be subject to continued monitoring and appropriate support following reintegration.
        </small>
    </div>
</form>

<script>
function toggleOtherSupport() {
    const checkbox = document.getElementById('support6');
    const field = document.getElementById('otherSupportField');
    field.style.display = checkbox.checked ? 'block' : 'none';
}
</script>

@endsection
