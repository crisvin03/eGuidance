@extends('layouts.dashboard')

@section('title', 'Personal Inventory Form')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-person-lines-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Personal Inventory Form</h1>
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

<form method="POST" action="{{ route('student.new-here.submit') }}" id="personalInventoryForm">
    @csrf

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
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Place of Birth</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[place_of_birth]" required>
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Religion</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[religion]">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">
                        <span>Complete Address</span>
                        <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control modern-form-control" name="form_data[address]" rows="2" required></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Contact Number</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[contact_number]">
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Email Address</span>
                        </label>
                        <input type="email" class="form-control modern-form-control" name="form_data[email]">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>Grade & Section</span>
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[grade_section]" placeholder="e.g., Grade 7 - A" required>
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">
                            <span>LRN (Learner Reference Number)</span>
                        </label>
                        <input type="text" class="form-control modern-form-control" name="form_data[lrn]">
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

                <!-- Father's Information -->
                <h6 style="font-size: 0.9rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">Father's Information</h6>
                
                <div class="mb-3">
                    <label class="modern-form-label">Father's Full Name</label>
                    <input type="text" class="form-control modern-form-control" name="form_data[father_name]">
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="modern-form-label">Age</label>
                        <input type="number" class="form-control modern-form-control" name="form_data[father_age]">
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">Occupation</label>
                        <input type="text" class="form-control modern-form-control" name="form_data[father_occupation]">
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">Contact Number</label>
                        <input type="text" class="form-control modern-form-control" name="form_data[father_contact]">
                    </div>
                </div>

                <hr style="margin: 1.5rem 0; border-color: rgba(0, 0, 0, 0.08);">

                <!-- Mother's Information -->
                <h6 style="font-size: 0.9rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">Mother's Information</h6>
                
                <div class="mb-3">
                    <label class="modern-form-label">Mother's Full Name</label>
                    <input type="text" class="form-control modern-form-control" name="form_data[mother_name]">
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="modern-form-label">Age</label>
                        <input type="number" class="form-control modern-form-control" name="form_data[mother_age]">
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">Occupation</label>
                        <input type="text" class="form-control modern-form-control" name="form_data[mother_occupation]">
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">Contact Number</label>
                        <input type="text" class="form-control modern-form-control" name="form_data[mother_contact]">
                    </div>
                </div>

                <hr style="margin: 1.5rem 0; border-color: rgba(0, 0, 0, 0.08);">

                <!-- Guardian Information (if applicable) -->
                <h6 style="font-size: 0.9rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">Guardian Information (if applicable)</h6>
                
                <div class="mb-3">
                    <label class="modern-form-label">Guardian's Full Name</label>
                    <input type="text" class="form-control modern-form-control" name="form_data[guardian_name]">
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="modern-form-label">Relationship</label>
                        <input type="text" class="form-control modern-form-control" name="form_data[guardian_relationship]" placeholder="e.g., Aunt, Uncle">
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">Occupation</label>
                        <input type="text" class="form-control modern-form-control" name="form_data[guardian_occupation]">
                    </div>
                    <div class="col-md-4">
                        <label class="modern-form-label">Contact Number</label>
                        <input type="text" class="form-control modern-form-control" name="form_data[guardian_contact]">
                    </div>
                </div>

                <hr style="margin: 1.5rem 0; border-color: rgba(0, 0, 0, 0.08);">

                <!-- Number of Siblings -->
                <div class="row">
                    <div class="col-md-6">
                        <label class="modern-form-label">Number of Siblings</label>
                        <input type="number" class="form-control modern-form-control" name="form_data[number_of_siblings]" min="0">
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">Birth Order</label>
                        <input type="text" class="form-control modern-form-control" name="form_data[birth_order]" placeholder="e.g., 1st, 2nd, 3rd">
                    </div>
                </div>
            </div>

            <!-- III. EDUCATIONAL BACKGROUND -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">III. Educational Background</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">Last School Attended (Elementary)</label>
                    <input type="text" class="form-control modern-form-control" name="form_data[last_elementary_school]">
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">School Address</label>
                    <input type="text" class="form-control modern-form-control" name="form_data[elementary_school_address]">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="modern-form-label">Year Graduated</label>
                        <input type="text" class="form-control modern-form-control" name="form_data[elementary_year_graduated]" placeholder="e.g., 2023">
                    </div>
                    <div class="col-md-6">
                        <label class="modern-form-label">General Average</label>
                        <input type="text" class="form-control modern-form-control" name="form_data[elementary_general_average]">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">Honors/Awards Received</label>
                    <textarea class="form-control modern-form-control" name="form_data[honors_awards]" rows="2" placeholder="List any honors, awards, or recognitions received"></textarea>
                </div>
            </div>

            <!-- IV. INTERESTS & HOBBIES -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-stars"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">IV. Interests & Hobbies</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">What are your hobbies and interests?</label>
                    <textarea class="form-control modern-form-control" name="form_data[hobbies_interests]" rows="3" placeholder="e.g., reading, sports, music, arts, etc."></textarea>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">What are your strengths and talents?</label>
                    <textarea class="form-control modern-form-control" name="form_data[strengths_talents]" rows="3" placeholder="What are you good at?"></textarea>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">What career or course are you interested in pursuing?</label>
                    <textarea class="form-control modern-form-control" name="form_data[career_interests]" rows="2"></textarea>
                </div>
            </div>

            <!-- V. SUPPORT NEEDS -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="modern-section-header" style="padding-bottom: 0.75rem; margin-bottom: 1rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <h3 class="modern-section-title" style="font-size: 1rem;">V. Support Needs</h3>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">Do you have any concerns you'd like to discuss with a counselor?</label>
                    <textarea class="form-control modern-form-control" name="form_data[concerns]" rows="3" placeholder="Optional - Share any concerns about academics, personal life, or relationships"></textarea>
                </div>

                <div class="mb-3">
                    <label class="modern-form-label">Is there any additional information you'd like us to know?</label>
                    <textarea class="form-control modern-form-control" name="form_data[additional_info]" rows="3" placeholder="Optional - Any other information that might help us support you better"></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="modern-card mb-4" style="padding: 1.5rem;">
                <div class="d-flex gap-2">
                    <button type="submit" class="modern-btn modern-btn-primary" style="padding: 1rem; font-size: 1.05rem; justify-content: center; flex: 1;">
                        <i class="bi bi-check-circle"></i>
                        <span>Submit Personal Inventory Form</span>
                    </button>
                    <a href="{{ route('student.new-here') }}" class="modern-btn modern-btn-secondary" style="padding: 1rem; font-size: 1.05rem; justify-content: center;">
                        <i class="bi bi-x-circle"></i>
                        <span>Cancel</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection
