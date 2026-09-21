@extends('layouts.dashboard')

@section('title', 'Curriculum Exit Survey')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Curriculum Exit Survey</h1>
            <p class="modern-page-subtitle">Senior High School Graduating Learners</p>
        </div>
    </div>
</div>

<!-- Instructions -->
<div class="modern-alert modern-alert-info mb-4">
    <div class="modern-alert-icon">
        <i class="bi bi-info-circle-fill"></i>
    </div>
    <div>
        <h6 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--green);">Purpose & Confidentiality</h6>
        <p style="margin: 0 0 0.5rem 0; font-size: 0.9rem; color: var(--text-muted);">
            This survey determines your intended curriculum exit and factors influencing your decisions after graduation. Information supports learner tracking, career guidance planning, and program improvement.
        </p>
        <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted); font-style: italic;">
            Your responses are confidential and used only for educational purposes in accordance with RA 10173 (Data Privacy Act of 2012).
        </p>
    </div>
</div>

<form method="POST" action="{{ route('student.forms.submit') }}" id="curriculumExitForm">
    @csrf
    <input type="hidden" name="form_type" value="exit_survey">

    <div class="row" style="gap: 0;">
        <div class="col-12">

            
            <!-- SECTION I: LEARNER INFORMATION -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section I: Learner Information</h3>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>1. Sex</span>
                            <span class="text-danger">*</span>
                        </label>
                        @foreach(['Male', 'Female', 'Prefer not to say'] as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="form_data[sex]" value="{{ $option }}" id="sex_{{ strtolower(str_replace(' ', '_', $option)) }}" required>
                            <label class="form-check-label" for="sex_{{ strtolower(str_replace(' ', '_', $option)) }}">{{ $option }}</label>
                        </div>
                        @endforeach
                    </div>

                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>2. Learner's Reference Number (LRN)</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[lrn]" required>
                    </div>

                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>3. Age</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control modern-form-control" name="form_data[age]" placeholder="years old" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>4. Contact Number</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[contact]" required>
                    </div>

                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>5. Grade Level</span>
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-control modern-form-control" name="form_data[grade_level]" required>
                            <option value="">Select grade level</option>
                            <option value="Grade 12">Grade 12</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>6. Senior High School Track</span>
                            <span class="text-danger">*</span>
                        </label>
                        @foreach(['Academic', 'Tech-Pro'] as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="form_data[track]" value="{{ $option }}" id="track_{{ strtolower($option) }}" required>
                            <label class="form-check-label" for="track_{{ strtolower($option) }}">{{ $option }}</label>
                        </div>
                        @endforeach
                    </div>

                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>7. Strand / Elective</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[strand]" placeholder="e.g., STEM, HUMSS, ICT" required>
                    </div>
                </div>
            </div>

            <!-- SECTION II: CURRICULUM EXIT INFORMATION -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-signpost-split"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section II: Curriculum Exit Information</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>8. What is your intended curriculum exit after graduating from Senior High School?</span>
                        <span class="text-danger">*</span>
                    </label>
                    @foreach(['College Education', 'Employment', 'Entrepreneurship / Business', 'Middle-Level Skills Development / Technical-Vocational Training', 'None / Undecided'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[intended_exit]" value="{{ $option }}" id="exit_{{ strtolower(str_replace(['/', ' '], ['_', '_'], $option)) }}" required onchange="toggleSections()">
                        <label class="form-check-label" for="exit_{{ strtolower(str_replace(['/', ' '], ['_', '_'], $option)) }}">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>9. How certain are you about your chosen curriculum exit?</span>
                        <span class="text-danger">*</span>
                    </label>
                    @foreach(['Very certain', 'Certain', 'Somewhat certain', 'Uncertain', 'Very uncertain'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[certainty]" value="{{ $option }}" id="certainty_{{ strtolower(str_replace(' ', '_', $option)) }}" required>
                        <label class="form-check-label" for="certainty_{{ strtolower(str_replace(' ', '_', $option)) }}">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- SECTION III: GUIDANCE AND DECISION-MAKING -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-compass"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section III: Guidance and Decision-Making</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>10. Who guided or helped you in deciding what to do after graduating from Senior High School?</span>
                        <span class="text-danger">*</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Guidance Counselor / Guidance Designate', 'Career Advocate', 'Class Adviser / Homeroom Adviser', 'Subject Teacher', 'Parent / Guardian / Relative', 'Friend / Classmate', 'School Administrator', 'Community Member', 'Employer / Industry Representative', 'No one'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[guided_by][]" value="{{ $option }}" id="guided_{{ $loop->index }}">
                        <label class="form-check-label" for="guided_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[guided_by][]" value="other" id="guided_other" onchange="toggleOtherField('guidedOtherField', this)">
                        <label class="form-check-label" for="guided_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="guidedOtherField" name="form_data[guided_by_other]" placeholder="Please specify" style="display: none;">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>11. What school services or activities helped you decide what to do after Senior High School?</span>
                        <span class="text-danger">*</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Guidance and Counseling Services', 'Career Guidance Program', 'Homeroom Guidance', 'Career Assessment / Career Interest Assessment', 'Individual Career Counseling', 'Career Orientation / Career Talk', 'College Admission Orientation', 'Job Fair / Career Fair', 'TESDA / Technical-Vocational Orientation', 'Entrepreneurship Activities', 'Work Immersion', 'School-Based Career Activities', 'None'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[services_helped][]" value="{{ $option }}" id="service_{{ $loop->index }}">
                        <label class="form-check-label" for="service_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[services_helped][]" value="other" id="service_other" onchange="toggleOtherField('serviceOtherField', this)">
                        <label class="form-check-label" for="service_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="serviceOtherField" name="form_data[services_helped_other]" placeholder="Please specify" style="display: none;">
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>12. How helpful were the school's career guidance services in helping you decide your next step?</span>
                        <span class="text-danger">*</span>
                    </label>
                    @foreach(['Very helpful', 'Helpful', 'Somewhat helpful', 'Slightly helpful', 'Not helpful at all', 'I did not participate in career guidance activities'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[guidance_helpfulness]" value="{{ $option }}" id="helpful_{{ $loop->index }}" required>
                        <label class="form-check-label" for="helpful_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>
            </div>


            <!-- SECTION IV: COLLEGE EDUCATION (Conditional) -->
            <div class="modern-card mb-4 conditional-section" id="section_college" style="padding: 1.5rem; display: none;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-building"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section IV: College Education</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>13. If you intend to pursue College Education, what is your preferred college course/program?</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[college_course]" placeholder="e.g., BS Computer Science">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>14. What are your reasons for choosing College Education as your curriculum exit?</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Personal choice', 'Interest in a specific profession', 'Influence of parents or relatives', 'Peer influence', 'Career guidance received', 'Prospect for employment in the future', 'Opportunity for higher income', 'Opportunity for employment abroad', 'Status or prestige associated with a college degree', 'Requirement for my preferred profession', 'Scholarship opportunity', 'Personal development', 'No particular choice / no better idea'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[college_reasons][]" value="{{ $option }}" id="college_reason_{{ $loop->index }}">
                        <label class="form-check-label" for="college_reason_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[college_reasons][]" value="other" id="college_reason_other" onchange="toggleOtherField('collegeReasonOtherField', this)">
                        <label class="form-check-label" for="college_reason_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="collegeReasonOtherField" name="form_data[college_reasons_other]" placeholder="Please specify" style="display: none;">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>15. Which college or university do you intend to attend?</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[college_name]">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>16. What is your current status regarding college admission?</span>
                    </label>
                    @foreach(['Already enrolled', 'Accepted / admitted', 'Applying', 'Planning to apply', 'Not yet decided', 'Not planning to enroll'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[college_status]" value="{{ $option }}" id="college_status_{{ $loop->index }}">
                        <label class="form-check-label" for="college_status_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>17. What challenges may prevent or delay you from pursuing college?</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Financial constraints', 'Lack of scholarship / financial assistance', 'Transportation or distance', 'Family responsibilities', 'Need to work first', 'Lack of available college/university nearby', 'Academic concerns', 'Admission requirements', 'No preferred course available', 'Health or personal concerns', 'None'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[college_challenges][]" value="{{ $option }}" id="college_challenge_{{ $loop->index }}">
                        <label class="form-check-label" for="college_challenge_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[college_challenges][]" value="other" id="college_challenge_other" onchange="toggleOtherField('collegeChallengeOtherField', this)">
                        <label class="form-check-label" for="college_challenge_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="collegeChallengeOtherField" name="form_data[college_challenges_other]" placeholder="Please specify" style="display: none;">
                </div>
            </div>

            <!-- SECTION V: EMPLOYMENT (Conditional) -->
            <div class="modern-card mb-4 conditional-section" id="section_employment" style="padding: 1.5rem; display: none;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section V: Employment</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>18. If you intend to seek employment, what type of work would you prefer?</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[employment_type]" placeholder="e.g., Office work, Customer service">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>19. What are your reasons for choosing employment as your curriculum exit?</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Personal choice', 'Financial need', 'Desire to support my family', 'Influence of parents or relatives', 'Peer influence', 'Inspired by a role model', 'To gain work experience', 'To become financially independent', 'Attractive work and compensation', 'Employment opportunity is readily available', 'To save money for college', 'Lack of interest in pursuing college or other training', 'Was not accepted into my preferred college course', 'No available college/university nearby'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[employment_reasons][]" value="{{ $option }}" id="emp_reason_{{ $loop->index }}">
                        <label class="form-check-label" for="emp_reason_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[employment_reasons][]" value="other" id="emp_reason_other" onchange="toggleOtherField('empReasonOtherField', this)">
                        <label class="form-check-label" for="emp_reason_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="empReasonOtherField" name="form_data[employment_reasons_other]" placeholder="Please specify" style="display: none;">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>20. What type of employment are you interested in?</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Local employment', 'Employment in another province/city', 'Overseas employment', 'Government employment', 'Private-sector employment', 'Family business', 'Any available employment', 'Not yet decided'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[employment_interest][]" value="{{ $option }}" id="emp_interest_{{ $loop->index }}">
                        <label class="form-check-label" for="emp_interest_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[employment_interest][]" value="other" id="emp_interest_other" onchange="toggleOtherField('empInterestOtherField', this)">
                        <label class="form-check-label" for="emp_interest_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="empInterestOtherField" name="form_data[employment_interest_other]" placeholder="Please specify" style="display: none;">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>21. Do you already have a prospective employer or job opportunity?</span>
                    </label>
                    @foreach(['Yes', 'No', 'Still looking', 'Prefer not to say'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[has_employer]" value="{{ $option }}" id="has_employer_{{ $loop->index }}">
                        <label class="form-check-label" for="has_employer_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>22. When do you plan to start working?</span>
                    </label>
                    @foreach(['Immediately after graduation', 'Within 3 months after graduation', 'Within 6 months after graduation', 'Within 1 year after graduation', 'Not yet decided'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[work_start]" value="{{ $option }}" id="work_start_{{ $loop->index }}">
                        <label class="form-check-label" for="work_start_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- SECTION VI: ENTREPRENEURSHIP / BUSINESS (Conditional) -->
            <div class="modern-card mb-4 conditional-section" id="section_entrepreneurship" style="padding: 1.5rem; display: none;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-shop"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section VI: Entrepreneurship / Business</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>23. If you intend to pursue Entrepreneurship/Business, what type of business would you like to establish?</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[business_type]" placeholder="e.g., Online selling, Food business">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>24. What are your reasons for choosing Entrepreneurship/Business as your curriculum exit?</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Personal choice', 'Interest in business', 'Influence of parents or relatives', 'Peer influence', 'Inspired by a role model', 'Opportunity to earn income', 'Desire to become financially independent', 'Family already has an existing business', 'Opportunity to provide employment to others', 'Flexible working arrangement', 'Financial constraints', 'Lack of interest in pursuing college', 'No available college/university nearby', 'Was not accepted into my preferred college course'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[business_reasons][]" value="{{ $option }}" id="bus_reason_{{ $loop->index }}">
                        <label class="form-check-label" for="bus_reason_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[business_reasons][]" value="other" id="bus_reason_other" onchange="toggleOtherField('busReasonOtherField', this)">
                        <label class="form-check-label" for="bus_reason_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="busReasonOtherField" name="form_data[business_reasons_other]" placeholder="Please specify" style="display: none;">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>25. Do you currently have an existing business or a plan to start a business?</span>
                    </label>
                    @foreach(['Yes, I already have a business', 'Yes, I have a concrete business plan', 'I have a business idea but no concrete plan yet', 'No'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[business_status]" value="{{ $option }}" id="bus_status_{{ $loop->index }}">
                        <label class="form-check-label" for="bus_status_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>26. If yes, what product or service does/will your business offer?</span>
                    </label>
                    <textarea class="form-control modern-form-control" name="form_data[business_offer]" rows="3"></textarea>
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>27. What support would help you start or expand your business?</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Entrepreneurship training', 'Business planning assistance', 'Financial assistance / capital', 'Marketing training', 'Financial literacy', 'Mentoring', 'Access to markets/customers', 'Equipment/materials', 'Registration/legal assistance'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[business_support][]" value="{{ $option }}" id="bus_support_{{ $loop->index }}">
                        <label class="form-check-label" for="bus_support_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[business_support][]" value="other" id="bus_support_other" onchange="toggleOtherField('busSupportOtherField', this)">
                        <label class="form-check-label" for="bus_support_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="busSupportOtherField" name="form_data[business_support_other]" placeholder="Please specify" style="display: none;">
                </div>
            </div>

            <!-- SECTION VII: MIDDLE-LEVEL SKILLS DEVELOPMENT (Conditional) -->
            <div class="modern-card mb-4 conditional-section" id="section_skills" style="padding: 1.5rem; display: none;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-tools"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section VII: Middle-Level Skills Development</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>28. If you intend to pursue Middle-Level Skills Development, what training program do you plan to take?</span>
                        <small class="text-muted d-block">Example: SMAW, Cookery, Electrical Installation, Computer Systems Servicing</small>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[training_program]">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>29. What are your reasons for choosing Middle-Level Skills Development?</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Personal choice', 'Interest in technical/vocational skills', 'Influence of parents or relatives', 'Peer influence', 'Inspired by a role model', 'Opportunity for employment', 'Opportunity for higher income', 'Opportunity for overseas employment', 'Shorter training period', 'Affordable training', 'Financial constraints', 'Lack of interest in pursuing a college degree', 'No available college/university nearby', 'Was not accepted into my preferred college course', 'Desire to acquire practical skills'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[training_reasons][]" value="{{ $option }}" id="train_reason_{{ $loop->index }}">
                        <label class="form-check-label" for="train_reason_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[training_reasons][]" value="other" id="train_reason_other" onchange="toggleOtherField('trainReasonOtherField', this)">
                        <label class="form-check-label" for="train_reason_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="trainReasonOtherField" name="form_data[training_reasons_other]" placeholder="Please specify" style="display: none;">
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>30. Which training provider do you intend to attend?</span>
                    </label>
                    @foreach(['TESDA Training Institution', 'School-based training program', 'Private training institution', 'Community-based training', 'Not yet decided'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[training_provider]" value="{{ $option }}" id="train_provider_{{ $loop->index }}">
                        <label class="form-check-label" for="train_provider_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[training_provider]" value="other" id="train_provider_other" onchange="toggleOtherField('trainProviderOtherField', this)">
                        <label class="form-check-label" for="train_provider_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="trainProviderOtherField" name="form_data[training_provider_other]" placeholder="Please specify" style="display: none;">
                </div>
            </div>

            <!-- SECTION VIII: NO CHOSEN CURRICULUM EXIT / UNDECIDED (Conditional) -->
            <div class="modern-card mb-4 conditional-section" id="section_undecided" style="padding: 1.5rem; display: none;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section VIII: No Chosen Curriculum Exit / Undecided</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>31. If you are currently undecided, what are the reasons why you have not yet chosen a curriculum exit?</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Personal uncertainty', 'Influence of parents or relatives', 'Financial constraints', 'Lack of information about available opportunities', 'Lack of career guidance', 'Still exploring career options', 'Academic concerns', 'No available college/university nearby', 'Need to help/support my family', 'Need to work first', 'Health or personal concerns', 'Lack of interest in college or training', 'I am considering several options'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[undecided_reasons][]" value="{{ $option }}" id="undec_reason_{{ $loop->index }}">
                        <label class="form-check-label" for="undec_reason_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[undecided_reasons][]" value="other" id="undec_reason_other" onchange="toggleOtherField('undecReasonOtherField', this)">
                        <label class="form-check-label" for="undec_reason_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="undecReasonOtherField" name="form_data[undecided_reasons_other]" placeholder="Please specify" style="display: none;">
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>32. What kind of assistance would help you decide your next step?</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Individual career counseling', 'Career assessment', 'College/course information', 'Scholarship information', 'Employment information', 'Entrepreneurship training', 'TESDA/training program information', 'Parent/guardian consultation', 'Financial assistance information', 'Job/career orientation'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[needed_assistance][]" value="{{ $option }}" id="assist_{{ $loop->index }}">
                        <label class="form-check-label" for="assist_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[needed_assistance][]" value="other" id="assist_other" onchange="toggleOtherField('assistOtherField', this)">
                        <label class="form-check-label" for="assist_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="assistOtherField" name="form_data[needed_assistance_other]" placeholder="Please specify" style="display: none;">
                </div>
            </div>


            <!-- SECTION IX: 21ST-CENTURY SKILLS -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section IX: 21st-Century Skills</h3>
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>33. Which 21st-century skills learned in basic education do you find useful?</span>
                        <span class="text-danger">*</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Creativity and curiosity', 'Visual and information literacy', 'Media literacy', 'Interactive communication', 'Flexibility and adaptability', 'Initiative and self-direction', 'Social and cross-cultural skills', 'Productivity and accountability', 'Critical thinking and problem solving', 'Risk-taking', 'Managing complexity', 'Higher-order thinking and sound reasoning', 'Basic, scientific, economic, and technological literacies', 'Multicultural literacy and global awareness', 'Teamwork, collaboration and interpersonal skills', 'Personal, social and civic responsibility', 'Leadership and responsibility'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[skills_21st][]" value="{{ $option }}" id="skill_{{ $loop->index }}">
                        <label class="form-check-label" for="skill_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[skills_21st][]" value="other" id="skill_other" onchange="toggleOtherField('skillOtherField', this)">
                        <label class="form-check-label" for="skill_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="skillOtherField" name="form_data[skills_21st_other]" placeholder="Please specify" style="display: none;">
                </div>
            </div>

            <!-- SECTION X: VALUES DEVELOPED -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section X: Values Developed</h3>
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>34. Which values learned in basic education do you find useful in your present life and future plans?</span>
                        <span class="text-danger">*</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Respectfulness (Paggalang)', 'Perseverance (Pagtitiyaga)', 'Industriousness (Kasipagan)', 'Prayerfulness (Pagiging Madalasin)', 'Compassion (Pagkamahawain)', 'Courage (Lakas ng loob)', 'Resourcefulness (Pagkamadiskarte)', 'Resilience (Katatagan)', 'Thrift / Frugality (Pagtitipid)', 'Optimism (Pagiging positibo)', 'Helpfulness (Pagkamatulungin)', 'Responsibility (Pananagutan)', 'Honesty / Integrity (Katapatan)', 'Discipline (Disiplina)'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[values][]" value="{{ $option }}" id="value_{{ $loop->index }}">
                        <label class="form-check-label" for="value_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[values][]" value="other" id="value_other" onchange="toggleOtherField('valueOtherField', this)">
                        <label class="form-check-label" for="value_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="valueOtherField" name="form_data[values_other]" placeholder="Please specify" style="display: none;">
                </div>
            </div>

            <!-- SECTION XI: READINESS AND FUTURE PLANS -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section XI: Readiness and Future Plans</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>35. How prepared do you feel for your chosen path after Senior High School?</span>
                        <span class="text-danger">*</span>
                    </label>
                    @foreach(['1 – Not prepared at all', '2 – Slightly prepared', '3 – Moderately prepared', '4 – Prepared', '5 – Very prepared'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[readiness]" value="{{ $option }}" id="ready_{{ $loop->index }}" required>
                        <label class="form-check-label" for="ready_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>36. What skills do you think you still need to develop before pursuing your chosen path?</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Communication skills', 'Digital / ICT skills', 'Financial literacy', 'Problem-solving skills', 'Leadership skills', 'Time-management skills', 'Technical/vocational skills', 'Entrepreneurship skills', 'Job interview skills', 'Resume/CV writing', 'Workplace behavior', 'Academic skills', 'Interpersonal skills'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[skills_needed][]" value="{{ $option }}" id="skill_need_{{ $loop->index }}">
                        <label class="form-check-label" for="skill_need_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[skills_needed][]" value="other" id="skill_need_other" onchange="toggleOtherField('skillNeedOtherField', this)">
                        <label class="form-check-label" for="skill_need_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="skillNeedOtherField" name="form_data[skills_needed_other]" placeholder="Please specify" style="display: none;">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>37. What support do you expect from the school to help you achieve your plans after Senior High School?</span>
                    </label>
                    <textarea class="form-control modern-form-control" name="form_data[expected_support]" rows="4" placeholder="Share your thoughts..."></textarea>
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>38. What suggestions can you give to improve the school's career guidance and curriculum exit programs?</span>
                    </label>
                    <textarea class="form-control modern-form-control" name="form_data[suggestions]" rows="4" placeholder="Your feedback helps us improve..."></textarea>
                </div>
            </div>

            <!-- SECTION XII: FOLLOW-UP TRACKING -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">Section XII: Follow-Up Tracking</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>39. May the school contact you for curriculum exit tracking and follow-up purposes?</span>
                        <span class="text-danger">*</span>
                    </label>
                    @foreach(['Yes', 'No'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[allow_contact]" value="{{ $option }}" id="allow_{{ strtolower($option) }}" required>
                        <label class="form-check-label" for="allow_{{ strtolower($option) }}">{{ $option }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>40. Preferred contact method</span>
                        <span class="text-danger">*</span>
                        <small class="text-muted d-block">Select all that apply</small>
                    </label>
                    @foreach(['Mobile/SMS', 'Phone call', 'Facebook/Messenger', 'Email'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[contact_method][]" value="{{ $option }}" id="contact_{{ $loop->index }}">
                        <label class="form-check-label" for="contact_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="form_data[contact_method][]" value="other" id="contact_other" onchange="toggleOtherField('contactOtherField', this)">
                        <label class="form-check-label" for="contact_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="contactOtherField" name="form_data[contact_method_other]" placeholder="Please specify" style="display: none;">
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>41. What is your current plan immediately after graduation?</span>
                        <span class="text-danger">*</span>
                    </label>
                    @foreach(['Enroll in college', 'Look for employment', 'Start/continue a business', 'Enroll in technical-vocational training', 'Prepare for a licensure/admission examination', 'Take a gap period before deciding', 'Continue helping in the family', 'Still undecided'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[immediate_plan]" value="{{ $option }}" id="plan_{{ $loop->index }}" required>
                        <label class="form-check-label" for="plan_{{ $loop->index }}">{{ $option }}</label>
                    </div>
                    @endforeach
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form_data[immediate_plan]" value="other" id="plan_other" onchange="toggleOtherField('planOtherField', this)" required>
                        <label class="form-check-label" for="plan_other">Other</label>
                    </div>
                    <input type="text" class="form-control modern-form-control mt-2" id="planOtherField" name="form_data[immediate_plan_other]" placeholder="Please specify" style="display: none;">
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                    <i class="bi bi-send-fill"></i>
                    <span>Submit Survey</span>
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
// Toggle conditional sections based on curriculum exit choice
function toggleSections() {
    const selectedExit = document.querySelector('input[name="form_data[intended_exit]"]:checked');
    
    // Hide all conditional sections first
    document.querySelectorAll('.conditional-section').forEach(section => {
        section.style.display = 'none';
    });
    
    if (!selectedExit) return;
    
    const exitValue = selectedExit.value;
    
    // Show relevant section based on selection
    if (exitValue.includes('College')) {
        document.getElementById('section_college').style.display = 'block';
    } else if (exitValue.includes('Employment')) {
        document.getElementById('section_employment').style.display = 'block';
    } else if (exitValue.includes('Entrepreneurship') || exitValue.includes('Business')) {
        document.getElementById('section_entrepreneurship').style.display = 'block';
    } else if (exitValue.includes('Skills') || exitValue.includes('Vocational')) {
        document.getElementById('section_skills').style.display = 'block';
    } else if (exitValue.includes('None') || exitValue.includes('Undecided')) {
        document.getElementById('section_undecided').style.display = 'block';
    }
}

// Toggle "Other" text fields
function toggleOtherField(fieldId, checkbox) {
    const field = document.getElementById(fieldId);
    if (field) {
        field.style.display = checkbox.checked ? 'block' : 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleSections();
});
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

/* Form check styling */
.form-check {
    padding-left: 1.5rem;
    margin-bottom: 0.5rem;
}

.form-check-input {
    margin-left: -1.5rem;
}

/* Section transitions */
.conditional-section {
    transition: all 0.3s ease;
}
</style>

@endsection
