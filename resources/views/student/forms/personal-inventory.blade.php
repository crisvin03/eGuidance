@extends('layouts.dashboard')

@section('title', 'Student Profile and Inventory Form')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-person-lines-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Student Profile and Inventory Form</h1>
            <p class="modern-page-subtitle">Annex C - Help us know you better</p>
        </div>
    </div>
</div>

<!-- Instructions -->
<div class="modern-alert modern-alert-info mb-4">
    <div class="modern-alert-icon">
        <i class="bi bi-info-circle-fill"></i>
    </div>
    <div>
        <h6 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--green);">Confidentiality</h6>
        <p style="margin: 0; font-size: 0.9rem; color: var(--text-muted);">
            The information provided in this form will be used for guidance and counseling services only. It will be treated with strict confidentiality.
        </p>
    </div>
</div>

<form method="POST" action="{{ route('student.forms.submit') }}" id="personalInventoryForm">
    @csrf
    <input type="hidden" name="form_type" value="personal_inventory">

    <div class="row" style="gap: 0;">
        <div class="col-12">
            
            <!-- I. PERSONAL INFORMATION -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">I. Personal Information</h3>
                </div>
                
                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Name</span>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control modern-form-control" name="form_data[last_name]" placeholder="Last Name" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control modern-form-control" name="form_data[first_name]" placeholder="First Name" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control modern-form-control" name="form_data[middle_name]" placeholder="Middle Name">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>Date of Birth</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control modern-form-control" name="form_data[date_of_birth]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>Age</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control modern-form-control" name="form_data[age]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>Sex</span>
                            <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="form_data[sex]" value="Male" id="sex_male" required>
                                <label class="form-check-label" for="sex_male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="form_data[sex]" value="Female" id="sex_female" required>
                                <label class="form-check-label" for="sex_female">Female</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>Grade Level</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[grade_level]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>Section/Strand</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[section_strand]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">
                            <span>LRN</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[lrn]" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="modern-form-label">
                            <span>Home Address</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[home_address]" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Contact Number</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[contact_number]" required>
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Email Address (if any)</span>
                        </label>
                        <input type="email" class="form-control modern-form-control" name="form_data[email_address]">
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Religion (Optional)</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[religion]">
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Nationality</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[nationality]" value="Filipino">
                    </div>
                </div>
            </div>

            <!-- II. FAMILY BACKGROUND -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">II. Family Background</h3>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Name of Father/Guardian</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[father_name]">
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Name of Mother/Guardian</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[mother_name]">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Occupation (Father/Guardian)</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[father_occupation]">
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Occupation (Mother/Guardian)</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[mother_occupation]">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Educational Attainment (Father/Guardian)</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[father_education]">
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Educational Attainment (Mother/Guardian)</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[mother_education]">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Contact Number (Father/Guardian)</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[father_contact]">
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Contact Number (Mother/Guardian)</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[mother_contact]">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="modern-form-label">
                            <span>No. of Siblings</span>
                        </label>
                        <input type="number" class="form-control modern-form-control" name="form_data[no_of_siblings]">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="modern-form-label">
                            <span>Your Position in the Family</span>
                        </label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['Oldest', 'Middle', 'Youngest', 'Only Child', 'Others'] as $position)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="form_data[family_position]" value="{{ $position }}" id="position_{{ strtolower(str_replace(' ', '_', $position)) }}">
                                <label class="form-check-label" for="position_{{ strtolower(str_replace(' ', '_', $position)) }}">{{ $position }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="modern-form-label">
                            <span>Family Structure</span>
                        </label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['Nuclear', 'Extended', 'Single Parent'] as $structure)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="form_data[family_structure]" value="{{ $structure }}" id="struct_{{ strtolower(str_replace(' ', '_', $structure)) }}">
                                <label class="form-check-label" for="struct_{{ strtolower(str_replace(' ', '_', $structure)) }}">{{ $structure }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-12">
                        <label class="modern-form-label">
                            <span>Languages spoken at home</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[languages_spoken]" placeholder="e.g., Tagalog, Bicol, English">
                    </div>
                </div>
            </div>


            <!-- III. HEALTH INFORMATION -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">III. Health Information</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>General Health</span>
                    </label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach(['Excellent', 'Very Good', 'Good', 'Fair', 'Poor'] as $health)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="form_data[general_health]" value="{{ $health }}" id="health_{{ strtolower(str_replace(' ', '_', $health)) }}">
                            <label class="form-check-label" for="health_{{ strtolower(str_replace(' ', '_', $health)) }}">{{ $health }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Do you have any medical condition/illness/allergy?</span>
                    </label>
                    <div class="d-flex gap-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="form_data[has_medical_condition]" value="Yes" id="med_yes" onchange="toggleMedicalFields()">
                            <label class="form-check-label" for="med_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="form_data[has_medical_condition]" value="No" id="med_no" onchange="toggleMedicalFields()">
                            <label class="form-check-label" for="med_no">No</label>
                        </div>
                    </div>
                    <input type="text" class="form-control modern-form-control" id="medicalConditionField" name="form_data[medical_condition_specify]" placeholder="If yes, please specify" style="display: none;">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Are you currently taking any maintenance medication?</span>
                    </label>
                    <div class="d-flex gap-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="form_data[has_maintenance_meds]" value="Yes" id="meds_yes" onchange="toggleMaintenanceFields()">
                            <label class="form-check-label" for="meds_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="form_data[has_maintenance_meds]" value="No" id="meds_no" onchange="toggleMaintenanceFields()">
                            <label class="form-check-label" for="meds_no">No</label>
                        </div>
                    </div>
                    <input type="text" class="form-control modern-form-control" id="maintenanceMedsField" name="form_data[maintenance_meds_specify]" placeholder="If yes, please specify" style="display: none;">
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>Person to contact in case of emergency</span>
                    </label>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control modern-form-control mb-2" name="form_data[emergency_contact_name]" placeholder="Name">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control modern-form-control mb-2" name="form_data[emergency_contact_relationship]" placeholder="Relationship">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control modern-form-control mb-2" name="form_data[emergency_contact_number]" placeholder="Contact No.">
                        </div>
                    </div>
                </div>
            </div>

            <!-- IV. ACADEMIC PROFILE -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-book"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">IV. Academic Profile</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Previous/Former School (Last School Year)</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[previous_school]">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Academic Strengths (Subjects)</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[academic_strengths]" placeholder="e.g., Math, Science, English">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Subjects/Areas Needing Improvement</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[areas_improvement]" placeholder="e.g., Filipino, History">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Study Habits</span>
                    </label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach(['Excellent', 'Good', 'Needs Improvement'] as $habit)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="form_data[study_habits]" value="{{ $habit }}" id="habit_{{ strtolower(str_replace(' ', '_', $habit)) }}">
                            <label class="form-check-label" for="habit_{{ strtolower(str_replace(' ', '_', $habit)) }}">{{ $habit }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Preferred Learning Style</span>
                    </label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach(['Visual', 'Auditory', 'Read/Write', 'Kinesthetic', 'Mixed'] as $style)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="form_data[learning_style][]" value="{{ $style }}" id="style_{{ strtolower(str_replace('/', '_', $style)) }}">
                            <label class="form-check-label" for="style_{{ strtolower(str_replace('/', '_', $style)) }}">{{ $style }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>Do you participate in any academic/enrichment activities?</span>
                    </label>
                    <div class="d-flex gap-3 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="form_data[has_academic_activities]" value="Yes" id="acad_yes" onchange="toggleAcademicFields()">
                            <label class="form-check-label" for="acad_yes">Yes</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="form_data[has_academic_activities]" value="No" id="acad_no" onchange="toggleAcademicFields()">
                            <label class="form-check-label" for="acad_no">No</label>
                        </div>
                    </div>
                    <input type="text" class="form-control modern-form-control" id="academicActivitiesField" name="form_data[academic_activities_specify]" placeholder="If yes, please specify" style="display: none;">
                </div>
            </div>

            <!-- V. INTERESTS AND HOBBIES & SOCIAL-EMOTIONAL PROFILE -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-palette"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">V. Interests and Hobbies & Social-Emotional Profile</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Hobbies/Interests</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[hobbies]" placeholder="e.g., Reading, Sports, Music">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Talents/Skills</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[talents]" placeholder="e.g., Singing, Drawing, Coding">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Extra-curricular Activities</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[extracurricular]" placeholder="e.g., Basketball team, Debate club">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Awards/Recognitions (if any)</span>
                    </label>
                    <textarea class="form-control modern-form-control" name="form_data[awards]" rows="2" placeholder="List any awards or recognitions received"></textarea>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>How would you describe yourself? (Check all that apply)</span>
                    </label>
                    <div class="row">
                        @foreach(['Happy', 'Shy', 'Sad', 'Quiet', 'Anxious', 'Angry', 'Others'] as $mood)
                        <div class="col-md-3 col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="form_data[describe_yourself][]" value="{{ $mood }}" id="mood_{{ strtolower($mood) }}">
                                <label class="form-check-label" for="mood_{{ strtolower($mood) }}">{{ $mood }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>I get along with:</span>
                    </label>
                    <div class="row">
                        @foreach(['Family', 'Friends', 'Teachers', 'Others'] as $relation)
                        <div class="col-md-3 col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="form_data[get_along_with][]" value="{{ $relation }}" id="along_{{ strtolower($relation) }}">
                                <label class="form-check-label" for="along_{{ strtolower($relation) }}">{{ $relation }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>Who do you usually talk to when you have a problem?</span>
                    </label>
                    <input type="text" class="form-control modern-form-control" name="form_data[talk_to_when_problem]" placeholder="e.g., Parents, Friends, Teacher">
                </div>
            </div>

            <!-- VI. GUIDANCE NEEDS ASSESSMENT -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">VI. Guidance Needs Assessment</h3>
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>Which of the following areas do you need help or support in? (Check all that apply)</span>
                    </label>
                    <div class="row">
                        @foreach(['Academic Performance', 'Career Guidance', 'Personal Concerns', 'Peer Relationships', 'Family Concerns', 'Time Management', 'Self-Confidence', 'Stress/Anxiety', 'Others'] as $need)
                        <div class="col-md-4 col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="form_data[guidance_needs][]" value="{{ $need }}" id="need_{{ strtolower(str_replace(['/', ' '], ['_', '_'], $need)) }}">
                                <label class="form-check-label" for="need_{{ strtolower(str_replace(['/', ' '], ['_', '_'], $need)) }}">{{ $need }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- VII. STUDENT REFLECTION -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">VII. Student Reflection</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>My goals this school year:</span>
                    </label>
                    <textarea class="form-control modern-form-control" name="form_data[goals_this_year]" rows="3" placeholder="Share your academic and personal goals..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Challenges I expect to face:</span>
                    </label>
                    <textarea class="form-control modern-form-control" name="form_data[expected_challenges]" rows="3" placeholder="What challenges do you anticipate?"></textarea>
                </div>

                <div class="mb-0">
                    <label class="modern-form-label">
                        <span>How I plan to overcome them:</span>
                    </label>
                    <textarea class="form-control modern-form-control" name="form_data[plan_to_overcome]" rows="3" placeholder="What strategies will you use?"></textarea>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                    <i class="bi bi-send-fill"></i>
                    <span>Submit Form</span>
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
function toggleMedicalFields() {
    const field = document.getElementById('medicalConditionField');
    const yesRadio = document.getElementById('med_yes');
    field.style.display = yesRadio.checked ? 'block' : 'none';
}

function toggleMaintenanceFields() {
    const field = document.getElementById('maintenanceMedsField');
    const yesRadio = document.getElementById('meds_yes');
    field.style.display = yesRadio.checked ? 'block' : 'none';
}

function toggleAcademicFields() {
    const field = document.getElementById('academicActivitiesField');
    const yesRadio = document.getElementById('acad_yes');
    field.style.display = yesRadio.checked ? 'block' : 'none';
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

/* Form check styling */
.form-check {
    padding-left: 1.5rem;
    margin-bottom: 0.5rem;
}

.form-check-input {
    margin-left: -1.5rem;
}
</style>

@endsection
