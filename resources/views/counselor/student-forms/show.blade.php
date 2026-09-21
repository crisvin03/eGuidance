@extends('layouts.dashboard')

@section('title', 'Form Submission Details')

@section('content')
@include('student.partials.modern-styles')

<style>
/* Mobile Responsive Styles for Counselor Pages */
@media (max-width: 768px) {
    /* Two-column grid becomes single column */
    div[style*="grid-template-columns: 1fr 380px"] {
        display: block !important;
    }
    
    /* Remove fixed widths on mobile */
    .modern-card {
        margin-bottom: 1rem !important;
    }
    
    /* Stack action buttons vertically */
    div[style*="display: flex"][style*="gap"] {
        flex-direction: column !important;
    }
    
    /* Full width buttons on mobile */
    .modern-btn {
        width: 100% !important;
        justify-content: center !important;
    }
    
    /* Reduce padding on cards */
    .modern-card[style*="padding: 1.5rem"] {
        padding: 1rem !important;
    }
    
    /* Make badges smaller */
    .modern-badge, .badge {
        font-size: 0.75rem !important;
    }
    
    /* Responsive grid for info boxes */
    .row.g-3 {
        gap: 0.5rem !important;
    }
    
    /* Full width columns on mobile */
    .col-md-6, .col-md-4, .col-md-3, .col-12 {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Smaller text on mobile */
    h1[style*="font-size: 1.5rem"] {
        font-size: 1.25rem !important;
    }
    
    h6.fw-bold {
        font-size: 0.95rem !important;
    }
    
    /* User avatar smaller */
    .user-avatar {
        width: 32px !important;
        height: 32px !important;
        font-size: 0.75rem !important;
    }
    
    /* Textareas more compact */
    textarea.form-control {
        font-size: 0.875rem !important;
    }
}
</style>

<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('counselor.student-forms.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
            <i class="bi bi-arrow-left"></i> Back to Forms
        </a>
        
        @if($submission->status == 'approved')
        <a href="{{ route('counselor.student-forms.print', $submission) }}" target="_blank" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
            <i class="bi bi-printer"></i> Print Form
        </a>
        @endif
    </div>
</div>

<!-- Page Header -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--green); margin: 0 0 0.5rem 0;">{{ $submission->form_type_name }}</h1>
            <p style="color: var(--text-muted); margin: 0;">Form Submission Details</p>
        </div>
        @if($submission->status == 'submitted')
            <span class="modern-badge modern-badge-warning" style="font-size: 0.9rem;"><i class="bi bi-clock-fill"></i> Submitted</span>
        @elseif($submission->status == 'reviewed')
            <span class="modern-badge modern-badge-info" style="font-size: 0.9rem;"><i class="bi bi-eye-fill"></i> Reviewed</span>
        @elseif($submission->status == 'approved')
            <span class="modern-badge modern-badge-success" style="font-size: 0.9rem;"><i class="bi bi-check-circle-fill"></i> Approved</span>
        @else
            <span class="modern-badge modern-badge-danger" style="font-size: 0.9rem;"><i class="bi bi-x-circle-fill"></i> Rejected</span>
        @endif
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 1.5rem;">
    <!-- Main Content -->
    <div>
        <!-- Student Information -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-person me-2" style="color:#1e7a4a;"></i>Student Information
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1"><i class="bi bi-person me-1"></i>Student Name</small>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar">{{ strtoupper(substr($submission->student->name, 0, 2)) }}</div>
                            <strong>{{ $submission->student->name }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1"><i class="bi bi-envelope me-1"></i>Email</small>
                        <strong>{{ $submission->student->email }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1"><i class="bi bi-calendar me-1"></i>Submitted Date</small>
                        <strong>{{ $submission->created_at->format('F d, Y') }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1"><i class="bi bi-clock me-1"></i>Submitted Time</small>
                        <strong>{{ $submission->created_at->format('h:i A') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Responses -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-file-text me-2" style="color:#1e7a4a;"></i>Form Responses
            </h6>
            @if($submission->form_data)
                @php
                    // Define question labels for each form type
                    $questionLabels = [
                        // Exit Survey Questions
                        'sex' => '1. Sex',
                        'lrn' => '2. Learner\'s Reference Number (LRN)',
                        'age' => '3. Age',
                        'contact' => '4. Contact Number',
                        'grade_level' => '5. Grade Level',
                        'track' => '6. Senior High School Track',
                        'strand' => '7. Strand / Elective',
                        'intended_exit' => '8. What is your intended curriculum exit after graduating from Senior High School?',
                        'certainty' => '9. How certain are you about your chosen curriculum exit?',
                        'guided_by' => '10. Who guided or helped you in deciding what to do after graduating from Senior High School?',
                        'guided_by_other' => '10. Other (Who guided you)',
                        'services_helped' => '11. What school services or activities helped you decide what to do after Senior High School?',
                        'services_helped_other' => '11. Other (Services)',
                        'guidance_helpfulness' => '12. How helpful were the school\'s career guidance services in helping you decide your next step?',
                        'college_course' => '13. If you intend to pursue College Education, what is your preferred college course/program?',
                        'college_reasons' => '14. What are your reasons for choosing College Education as your curriculum exit?',
                        'college_reasons_other' => '14. Other (College reasons)',
                        'college_name' => '15. Which college or university do you intend to attend?',
                        'college_status' => '16. What is your current status regarding college admission?',
                        'college_challenges' => '17. What challenges may prevent or delay you from pursuing college?',
                        'college_challenges_other' => '17. Other (Challenges)',
                        'employment_type' => '18. If you intend to seek employment, what type of work would you prefer?',
                        'employment_reasons' => '19. What are your reasons for choosing employment as your curriculum exit?',
                        'employment_reasons_other' => '19. Other (Employment reasons)',
                        'employment_interest' => '20. What type of employment are you interested in?',
                        'employment_interest_other' => '20. Other (Employment type)',
                        'has_employer' => '21. Do you already have a prospective employer or job opportunity?',
                        'work_start' => '22. When do you plan to start working?',
                        'business_type' => '23. If you intend to pursue Entrepreneurship/Business, what type of business would you like to establish?',
                        'business_reasons' => '24. What are your reasons for choosing Entrepreneurship/Business as your curriculum exit?',
                        'business_reasons_other' => '24. Other (Business reasons)',
                        'business_status' => '25. Do you currently have an existing business or a plan to start a business?',
                        'business_offer' => '26. If yes, what product or service does/will your business offer?',
                        'business_support' => '27. What support would help you start or expand your business?',
                        'business_support_other' => '27. Other (Support needed)',
                        'training_program' => '28. If you intend to pursue Middle-Level Skills Development, what training program do you plan to take?',
                        'training_reasons' => '29. What are your reasons for choosing Middle-Level Skills Development?',
                        'training_reasons_other' => '29. Other (Training reasons)',
                        'training_provider' => '30. Which training provider do you intend to attend?',
                        'training_provider_other' => '30. Other (Training provider)',
                        'undecided_reasons' => '31. If you are currently undecided, what are the reasons why you have not yet chosen a curriculum exit?',
                        'undecided_reasons_other' => '31. Other (Undecided reasons)',
                        'needed_assistance' => '32. What kind of assistance would help you decide your next step?',
                        'needed_assistance_other' => '32. Other (Assistance needed)',
                        'skills_21st' => '33. Which 21st-century skills learned in basic education do you find useful?',
                        'skills_21st_other' => '33. Other (21st-century skills)',
                        'values' => '34. Which values learned in basic education do you find useful in your present life and future plans?',
                        'values_other' => '34. Other (Values)',
                        'readiness' => '35. How prepared do you feel for your chosen path after Senior High School?',
                        'skills_needed' => '36. What skills do you think you still need to develop before pursuing your chosen path?',
                        'skills_needed_other' => '36. Other (Skills needed)',
                        'expected_support' => '37. What support do you expect from the school to help you achieve your plans after Senior High School?',
                        'suggestions' => '38. What suggestions can you give to improve the school\'s career guidance and curriculum exit programs?',
                        'allow_contact' => '39. May the school contact you for curriculum exit tracking and follow-up purposes?',
                        'contact_method' => '40. Preferred contact method',
                        'contact_method_other' => '40. Other (Contact method)',
                        'immediate_plan' => '41. What is your current plan immediately after graduation?',
                        'immediate_plan_other' => '41. Other (Immediate plan)',
                        
                        // Personal Inventory Questions
                        'last_name' => 'Last Name',
                        'first_name' => 'First Name',
                        'middle_name' => 'Middle Name',
                        'date_of_birth' => 'Date of Birth',
                        'section_strand' => 'Section/Strand',
                        'home_address' => 'Home Address',
                        'contact_number' => 'Contact Number',
                        'email_address' => 'Email Address',
                        'religion' => 'Religion',
                        'nationality' => 'Nationality',
                        'father_name' => 'Name of Father/Guardian',
                        'mother_name' => 'Name of Mother/Guardian',
                        'father_occupation' => 'Occupation (Father/Guardian)',
                        'mother_occupation' => 'Occupation (Mother/Guardian)',
                        'father_education' => 'Educational Attainment (Father/Guardian)',
                        'mother_education' => 'Educational Attainment (Mother/Guardian)',
                        'father_contact' => 'Contact Number (Father/Guardian)',
                        'mother_contact' => 'Contact Number (Mother/Guardian)',
                        'no_of_siblings' => 'No. of Siblings',
                        'family_position' => 'Your Position in the Family',
                        'family_structure' => 'Family Structure',
                        'languages_spoken' => 'Languages spoken at home',
                        'general_health' => 'General Health',
                        'has_medical_condition' => 'Do you have any medical condition/illness/allergy?',
                        'medical_condition_specify' => 'Medical condition details',
                        'has_maintenance_meds' => 'Are you currently taking any maintenance medication?',
                        'maintenance_meds_specify' => 'Maintenance medication details',
                        'emergency_contact_name' => 'Emergency Contact Name',
                        'emergency_contact_relationship' => 'Emergency Contact Relationship',
                        'emergency_contact_number' => 'Emergency Contact Number',
                        'previous_school' => 'Previous/Former School (Last School Year)',
                        'academic_strengths' => 'Academic Strengths (Subjects)',
                        'areas_improvement' => 'Subjects/Areas Needing Improvement',
                        'study_habits' => 'Study Habits',
                        'learning_style' => 'Preferred Learning Style',
                        'has_academic_activities' => 'Do you participate in any academic/enrichment activities?',
                        'academic_activities_specify' => 'Academic activities details',
                        'hobbies' => 'Hobbies/Interests',
                        'talents' => 'Talents/Skills',
                        'extracurricular' => 'Extra-curricular Activities',
                        'awards' => 'Awards/Recognitions',
                        'describe_yourself' => 'How would you describe yourself?',
                        'get_along_with' => 'I get along with',
                        'talk_to_when_problem' => 'Who do you usually talk to when you have a problem?',
                        'guidance_needs' => 'Which of the following areas do you need help or support in?',
                        'goals_this_year' => 'My goals this school year',
                        'expected_challenges' => 'Challenges I expect to face',
                        'plan_to_overcome' => 'How I plan to overcome them',
                        
                        // Clearance Form Questions
                        'learner_name' => 'Name of Learner',
                        'grade_section' => 'Grade & Section',
                        'reason' => 'Reason for Intervention/Suspension',
                        'return_date' => 'Date of Return',
                        'checklist' => 'Reintegration Checklist',
                        'remarks' => 'Remarks',
                        'support' => 'Follow-Up Support Needed',
                        'other_support' => 'Other Support Details',
                        'additional_comments' => 'Additional Comments',
                    ];
                @endphp
                
                @foreach($submission->form_data as $key => $value)
                    @if($key !== 'checklist' && $key !== 'remarks')
                        <div class="mb-3 p-3 bg-light rounded">
                            <div class="fw-semibold mb-2" style="color:#1e7a4a; font-size: 0.95rem;">
                                {{ $questionLabels[$key] ?? ucwords(str_replace('_', ' ', $key)) }}
                            </div>
                            <div style="color: #333; font-size: 0.9rem;">
                                @if(is_array($value))
                                    @if(empty($value))
                                        <span class="text-muted">Not answered</span>
                                    @else
                                        @foreach($value as $item)
                                            <span class="badge bg-secondary me-1 mb-1">{{ $item }}</span>
                                        @endforeach
                                    @endif
                                @elseif($key === 'date_of_birth' || $key === 'return_date')
                                    {{ $value ? \Carbon\Carbon::parse($value)->format('F d, Y') : 'N/A' }}
                                @else
                                    {{ $value ?: 'Not answered' }}
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
                
                @if(isset($submission->form_data['checklist']))
                    <div class="mb-3 p-3 bg-light rounded">
                        <div class="fw-semibold mb-2" style="color:#1e7a4a; font-size: 0.95rem;">
                            Reintegration Checklist
                        </div>
                        <div style="color: #333; font-size: 0.9rem;">
                            @php
                                $checklistLabels = [
                                    'case_review' => '1. Case Review – The learner\'s situation has been reviewed.',
                                    'intervention' => '2. Intervention – Appropriate intervention or support has been provided.',
                                    'conference' => '3. Learner Conference – The learner has been oriented regarding expectations upon return.',
                                    'parent_coord' => '4. Parent Coordination – The parent/guardian has been informed or consulted.',
                                    'readiness' => '5. Readiness Assessment – The learner is assessed as ready to return with appropriate support.',
                                    'followup' => '6. Follow-Up Plan – Necessary monitoring or follow-up support has been identified.',
                                ];
                            @endphp
                            @foreach($submission->form_data['checklist'] as $item => $checked)
                                <div class="d-flex align-items-start mb-2">
                                    <i class="bi bi-{{ $checked ? 'check-circle-fill text-success' : 'circle text-muted' }} me-2"></i>
                                    <div>
                                        <div>{{ $checklistLabels[$item] ?? $item }}</div>
                                        @if(isset($submission->form_data['remarks'][$item]) && $submission->form_data['remarks'][$item])
                                            <small class="text-muted">Remarks: {{ $submission->form_data['remarks'][$item] }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <p class="text-muted">No response data available</p>
            @endif
        </div>

        <!-- Counselor Notes (if exists) -->
        @if($submission->counselor_notes)
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-chat-left-text me-2" style="color:#1e7a4a;"></i>Counselor Notes
            </h6>
            <div class="p-3 bg-light rounded">{{ $submission->counselor_notes }}</div>
            @if($submission->reviewer)
            <small class="text-muted d-block mt-3">
                <i class="bi bi-person-check me-1"></i>Reviewed by <strong>{{ $submission->reviewer->name }}</strong> on {{ $submission->reviewed_at->format('M d, Y') }}
            </small>
            @endif
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div>
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-pencil-square me-2" style="color:#1e7a4a;"></i>Review Form
            </h6>
            <form method="POST" action="{{ route('counselor.student-forms.review', $submission) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 0.875rem; color: var(--navy);">
                        Status <span class="text-danger">*</span>
                    </label>
                    <select class="form-control" name="status" required style="border-radius: 10px;">
                        <option value="reviewed" {{ $submission->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="approved" {{ $submission->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $submission->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 0.875rem; color: var(--navy);">Counselor Notes</label>
                    <textarea class="form-control" name="counselor_notes" rows="6" placeholder="Add your review notes..." style="border-radius: 10px;">{{ old('counselor_notes', $submission->counselor_notes) }}</textarea>
                </div>

                <button type="submit" class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.875rem;">
                    <i class="bi bi-check-circle me-1"></i>Update Review
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
