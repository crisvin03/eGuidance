@extends('layouts.dashboard')

@section('title', 'Learner Reintegration Clearance')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-shield-check"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Learner Reintegration Clearance</h1>
            <p class="modern-page-subtitle">For Return to Regular Classroom Participation</p>
        </div>
    </div>
</div>

<!-- Instructions -->
<div class="modern-alert modern-alert-info mb-4">
    <div class="modern-alert-icon">
        <i class="bi bi-info-circle-fill"></i>
    </div>
    <div>
        <h6 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--green);">Complete this form carefully</h6>
        <p style="margin: 0; font-size: 0.9rem; color: var(--text-muted);">
            This clearance request will be reviewed by the guidance counselor. Please provide accurate information.
        </p>
    </div>
</div>

<form method="POST" action="{{ route('student.forms.submit') }}">
    @csrf
    <input type="hidden" name="form_type" value="clearance_return">

    <div class="row" style="gap: 0;">
        <div class="col-12">
            <!-- Basic Information -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Learner Information</h3>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Name of Learner</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control @error('form_data.learner_name') is-invalid @enderror" 
                               name="form_data[learner_name]" value="{{ old('form_data.learner_name', auth()->user()->name) }}" required>
                        @error('form_data.learner_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Grade & Section</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control @error('form_data.grade_section') is-invalid @enderror" 
                               name="form_data[grade_section]" value="{{ old('form_data.grade_section') }}" 
                               placeholder="e.g., Grade 11 - STEM A" required>
                        @error('form_data.grade_section')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Reason for Intervention/Suspension</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control @error('form_data.reason') is-invalid @enderror" 
                               name="form_data[reason]" value="{{ old('form_data.reason') }}" 
                               placeholder="Brief description" required>
                        @error('form_data.reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Date of Return</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control modern-form-control @error('form_data.return_date') is-invalid @enderror" 
                               name="form_data[return_date]" value="{{ old('form_data.return_date') }}" required>
                        @error('form_data.return_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Reintegration Checklist -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Reintegration Checklist</h3>
                </div>
                <p class="text-muted small mb-3" style="font-size: 0.875rem;">Please indicate your understanding and readiness for each requirement:</p>

                @php
                    $checklist = [
                        ['key' => 'case_review', 'title' => 'Case Review', 'desc' => 'I understand my situation will be reviewed.'],
                        ['key' => 'intervention', 'title' => 'Intervention', 'desc' => 'I am willing to receive appropriate intervention or support.'],
                        ['key' => 'conference', 'title' => 'Learner Conference', 'desc' => 'I am prepared to attend orientation regarding expectations.'],
                        ['key' => 'parent_coord', 'title' => 'Parent Coordination', 'desc' => 'My parent/guardian has been informed or will be consulted.'],
                        ['key' => 'readiness', 'title' => 'Readiness Assessment', 'desc' => 'I believe I am ready to return with appropriate support.'],
                        ['key' => 'followup', 'title' => 'Follow-Up Plan', 'desc' => 'I understand monitoring or follow-up support may be needed.'],
                    ];
                @endphp

                @foreach($checklist as $index => $item)
                <div style="padding: 1rem 0; border-bottom: 1px solid rgba(30, 122, 74, 0.08); {{ $loop->last ? 'border-bottom: none;' : '' }}">
                    <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 0.75rem;">
                        <div style="flex-shrink: 0;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="form_data[checklist][{{ $item['key'] }}]" value="1" 
                                       id="check_{{ $item['key'] }}" {{ old('form_data.checklist.' . $item['key']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="check_{{ $item['key'] }}" style="font-size: 0.95rem; font-weight: 600; color: var(--navy);">
                                    {{ $index + 1 }}. {{ $item['title'] }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <small style="color: var(--text-muted); font-size: 0.875rem; display: block; margin-bottom: 0.5rem; padding-left: 2rem;">
                        {{ $item['desc'] }}
                    </small>
                    <input type="text" class="form-control form-control-sm" name="form_data[remarks][{{ $item['key'] }}]" 
                           value="{{ old('form_data.remarks.' . $item['key']) }}" 
                           placeholder="Optional remarks" style="font-size: 0.875rem; margin-left: 2rem;">
                </div>
                @endforeach
            </div>

            <!-- Support Needs -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-hand-thumbs-up"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Follow-Up Support Needed</h3>
                </div>
                <p class="text-muted small mb-3" style="font-size: 0.875rem;">Select any support you feel you might need:</p>

                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @php
                        $supportOptions = [
                            ['value' => 'counseling', 'icon' => 'chat-dots', 'color' => 'primary', 'label' => 'Counseling Follow-Up'],
                            ['value' => 'teacher_monitoring', 'icon' => 'person-video3', 'color' => 'success', 'label' => 'Teacher Monitoring'],
                            ['value' => 'parent_coordination', 'icon' => 'people', 'color' => 'info', 'label' => 'Parent/Guardian Coordination'],
                            ['value' => 'behavior_monitoring', 'icon' => 'clipboard-check', 'color' => 'warning', 'label' => 'Behavior Monitoring'],
                            ['value' => 'academic_support', 'icon' => 'book', 'color' => 'danger', 'label' => 'Academic Support'],
                            ['value' => 'other', 'icon' => 'three-dots', 'color' => 'secondary', 'label' => 'Other'],
                        ];
                    @endphp

                    @foreach($supportOptions as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[support][]" value="{{ $option['value'] }}" 
                               id="support_{{ $option['value'] }}" 
                               {{ in_array($option['value'], old('form_data.support', [])) ? 'checked' : '' }}
                               @if($option['value'] === 'other') onclick="toggleOtherSupport()" @endif>
                        <label class="form-check-label" for="support_{{ $option['value'] }}" style="font-size: 0.9rem;">
                            <i class="bi bi-{{ $option['icon'] }} text-{{ $option['color'] }} me-1"></i> {{ $option['label'] }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <div id="otherSupportField" class="mt-3" style="display: {{ in_array('other', old('form_data.support', [])) ? 'block' : 'none' }};">
                    <label class="modern-form-label">
                        <span>Please specify:</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[other_support]" 
                           value="{{ old('form_data.other_support') }}" placeholder="Describe the support you need">
                </div>
            </div>

            <!-- Additional Comments -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-chat-left-text"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Additional Comments (Optional)</h3>
                </div>
                <textarea class="form-control modern-form-control" name="form_data[additional_comments]" rows="5" 
                          placeholder="Share any additional information that might help the counselor understand your situation better..." 
                          style="font-size: 0.9rem;">{{ old('form_data.additional_comments') }}</textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                    <i class="bi bi-send-fill"></i>
                    <span>Submit Clearance Form</span>
                </button>
                <a href="{{ route('student.forms.index') }}" class="modern-btn modern-btn-outline" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                    <i class="bi bi-x-circle"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </div>


    </div>
</form>

<script>
function toggleOtherSupport() {
    const checkbox = document.getElementById('support_other');
    const field = document.getElementById('otherSupportField');
    field.style.display = checkbox.checked ? 'block' : 'none';
}
</script>

<style>
@media (max-width: 768px) {
    .d-flex.gap-3.flex-wrap {
        flex-direction: column;
    }
    
    .modern-btn {
        width: 100%;
    }
}
</style>
@endsection
