@extends('layouts.dashboard')

@section('title', 'Personal Inventory Submission')

@section('content')
@include('student.partials.modern-styles')

<!-- Back Button -->
<div class="mb-3">
    <a href="{{ route('student.new-here') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
        <i class="bi bi-arrow-left"></i>
        <span>Back to New Here</span>
    </a>
</div>

<div class="row" style="gap: 0;">
    <div class="col-lg-10 mx-auto">
        <!-- Header Card -->
        <div class="modern-card mb-3" style="padding: 1.5rem;">
            <div style="display: flex; align-items: start; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <h5 style="font-size: 1.15rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">{{ $submission->form_title }}</h5>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                        <i class="bi bi-calendar3"></i>
                        Submitted on {{ $submission->created_at->format('F d, Y \a\t g:i A') }}
                    </p>
                </div>
                <div>
                    @if($submission->status === 'submitted')
                        <span class="modern-badge modern-badge-warning">Pending Review</span>
                    @elseif($submission->status === 'reviewed')
                        <span class="modern-badge modern-badge-success">Reviewed</span>
                    @elseif($submission->status === 'requires_action')
                        <span class="modern-badge modern-badge-danger">Action Required</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Counselor Feedback (if available) -->
        @if($submission->counselor_notes)
            <div class="modern-alert mb-3" style="background: rgba(59, 130, 246, 0.08); border-left: 4px solid #3b82f6;">
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="bi bi-chat-left-text-fill" style="font-size: 1.25rem; color: #3b82f6; flex-shrink: 0;"></i>
                    <div style="flex: 1;">
                        <h6 style="font-size: 0.95rem; font-weight: 700; color: #3b82f6; margin-bottom: 0.5rem;">Counselor's Feedback</h6>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; white-space: pre-wrap;">{{ $submission->counselor_notes }}</p>
                        @if($submission->reviewed_at)
                            <small style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 0.5rem;">
                                <i class="bi bi-clock"></i>
                                Reviewed on {{ $submission->reviewed_at->format('F d, Y \a\t g:i A') }}
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Status Alert -->
        @if($submission->status === 'submitted')
            <div class="modern-alert modern-alert-warning mb-3">
                <div class="modern-alert-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <span>Your form is pending review by a counselor.</span>
            </div>
        @elseif($submission->status === 'reviewed')
            <div class="modern-alert modern-alert-success mb-3">
                <div class="modern-alert-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <span>Your form has been reviewed by a counselor.</span>
            </div>
        @endif

        <!-- Form Data Display -->
        @if($submission->form_data)
            
            @php
                $fieldLabels = [
                    // Personal Information
                    'last_name' => 'Last Name',
                    'first_name' => 'First Name',
                    'middle_name' => 'Middle Name',
                    'date_of_birth' => 'Date of Birth',
                    'age' => 'Age',
                    'sex' => 'Sex',
                    'place_of_birth' => 'Place of Birth',
                    'religion' => 'Religion',
                    'address' => 'Complete Address',
                    'contact_number' => 'Contact Number',
                    'email' => 'Email Address',
                    'grade_section' => 'Grade & Section',
                    'lrn' => 'LRN (Learner Reference Number)',
                    
                    // Family Background
                    'father_name' => 'Father\'s Full Name',
                    'father_age' => 'Father\'s Age',
                    'father_occupation' => 'Father\'s Occupation',
                    'father_contact' => 'Father\'s Contact',
                    'mother_name' => 'Mother\'s Full Name',
                    'mother_age' => 'Mother\'s Age',
                    'mother_occupation' => 'Mother\'s Occupation',
                    'mother_contact' => 'Mother\'s Contact',
                    'guardian_name' => 'Guardian\'s Name',
                    'guardian_relationship' => 'Guardian\'s Relationship',
                    'guardian_occupation' => 'Guardian\'s Occupation',
                    'guardian_contact' => 'Guardian\'s Contact',
                    'number_of_siblings' => 'Number of Siblings',
                    'birth_order' => 'Birth Order',
                    
                    // Educational Background
                    'last_elementary_school' => 'Last Elementary School',
                    'elementary_school_address' => 'Elementary School Address',
                    'elementary_year_graduated' => 'Year Graduated',
                    'elementary_general_average' => 'General Average',
                    'honors_awards' => 'Honors/Awards',
                    
                    // Interests & Hobbies
                    'hobbies_interests' => 'Hobbies & Interests',
                    'strengths_talents' => 'Strengths & Talents',
                    'career_interests' => 'Career Interests',
                    
                    // Support Needs
                    'concerns' => 'Concerns',
                    'additional_info' => 'Additional Information',
                ];
                
                $sections = [
                    'Personal Information' => ['last_name', 'first_name', 'middle_name', 'date_of_birth', 'age', 'sex', 'place_of_birth', 'religion', 'address', 'contact_number', 'email', 'grade_section', 'lrn'],
                    'Family Background' => ['father_name', 'father_age', 'father_occupation', 'father_contact', 'mother_name', 'mother_age', 'mother_occupation', 'mother_contact', 'guardian_name', 'guardian_relationship', 'guardian_occupation', 'guardian_contact', 'number_of_siblings', 'birth_order'],
                    'Educational Background' => ['last_elementary_school', 'elementary_school_address', 'elementary_year_graduated', 'elementary_general_average', 'honors_awards'],
                    'Interests & Hobbies' => ['hobbies_interests', 'strengths_talents', 'career_interests'],
                    'Support Needs' => ['concerns', 'additional_info'],
                ];
            @endphp

            @foreach($sections as $sectionTitle => $fields)
                <div class="modern-card mb-3" style="padding: 1.5rem;">
                    <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 2px solid rgba(0, 0, 0, 0.06);">
                        {{ $sectionTitle }}
                    </h6>

                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @foreach($fields as $field)
                            @if(isset($submission->form_data[$field]))
                                @php
                                    $value = $submission->form_data[$field];
                                    $hasValue = is_array($value) ? !empty($value) : ($value !== null && $value !== '');
                                @endphp
                                
                                @if($hasValue)
                                    <div style="padding: 0.875rem; background: rgba(248, 250, 252, 0.6); border-radius: 8px; border: 1px solid rgba(0, 0, 0, 0.04);">
                                        <div style="font-size: 0.75rem; font-weight: 700; color: var(--green); margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                            {{ $fieldLabels[$field] ?? ucwords(str_replace('_', ' ', $field)) }}
                                        </div>
                                        <div style="font-size: 0.9rem; color: var(--navy); line-height: 1.5;">
                                            @if(is_array($value))
                                                @foreach($value as $item)
                                                    <span class="modern-badge modern-badge-secondary" style="margin-right: 0.25rem; margin-bottom: 0.25rem;">{{ $item }}</span>
                                                @endforeach
                                            @else
                                                {{ $value }}
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

        @else
            <div class="modern-card" style="padding: 2rem; text-align: center;">
                <i class="bi bi-exclamation-circle" style="font-size: 3rem; color: var(--text-muted); opacity: 0.3;"></i>
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 1rem 0 0.5rem;">No Data Available</h6>
                <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0;">No form data could be found for this submission.</p>
            </div>
        @endif
    </div>
</div>
@endsection
