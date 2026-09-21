<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Profile and Inventory Form - {{ $submission->student->name }}</title>
    <style>
        @page { margin: 15mm; }
        body {
            font-family: 'Arial', 'DejaVu Sans', sans-serif;
            font-size: 8pt;
            line-height: 1.3;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #1e7a4a;
        }
        .header h1 {
            font-size: 13pt;
            margin: 0 0 3px 0;
            color: #1e7a4a;
            font-weight: bold;
        }
        .header h2 {
            font-size: 9pt;
            margin: 0;
            color: #333;
            font-weight: normal;
        }
        .section {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 9pt;
            font-weight: bold;
            color: #fff;
            background: #1e7a4a;
            padding: 3px 6px;
            margin: 5px 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 5px 10px;
            margin-bottom: 8px;
        }
        .info-item {
            font-size: 7.5pt;
            padding: 3px;
            border-bottom: 1px solid #ddd;
        }
        .info-label {
            font-weight: bold;
            color: #1e7a4a;
        }
        .response-item {
            margin: 5px 0;
            padding: 5px;
            background: #f9f9f9;
            border-left: 3px solid #1e7a4a;
            font-size: 7.5pt;
        }
        .response-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 2px;
        }
        .response-value {
            color: #555;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            background: #e5e7eb;
            border-radius: 3px;
            font-size: 7pt;
            margin: 1px;
        }
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 6.5pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>STUDENT PROFILE AND INVENTORY FORM</h1>
        <h2>Annex C - Personal and Background Information</h2>
    </div>

    @php
        $data = $submission->form_data;
    @endphp

    <!-- Section I: Personal Information -->
    <div class="section">
        <div class="section-title">I. PERSONAL INFORMATION</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Last Name:</div>
                {{ $data['last_name'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">First Name:</div>
                {{ $data['first_name'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Middle Name:</div>
                {{ $data['middle_name'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Date of Birth:</div>
                {{ isset($data['date_of_birth']) ? \Carbon\Carbon::parse($data['date_of_birth'])->format('M d, Y') : 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Age:</div>
                {{ $data['age'] ?? 'N/A' }} years old
            </div>
            <div class="info-item">
                <div class="info-label">Sex:</div>
                {{ $data['sex'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Grade Level:</div>
                {{ $data['grade_level'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Section/Strand:</div>
                {{ $data['section_strand'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">LRN:</div>
                {{ $data['lrn'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Contact Number:</div>
                {{ $data['contact_number'] ?? 'N/A' }}
            </div>
            <div class="info-item" style="grid-column: span 2;">
                <div class="info-label">Home Address:</div>
                {{ $data['home_address'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Email:</div>
                {{ $data['email_address'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Religion:</div>
                {{ $data['religion'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Nationality:</div>
                {{ $data['nationality'] ?? 'Filipino' }}
            </div>
        </div>
    </div>

    <!-- Section II: Family Background -->
    <div class="section">
        <div class="section-title">II. FAMILY BACKGROUND</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Father/Guardian:</div>
                {{ $data['father_name'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Mother/Guardian:</div>
                {{ $data['mother_name'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Father's Occupation:</div>
                {{ $data['father_occupation'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Mother's Occupation:</div>
                {{ $data['mother_occupation'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Father's Education:</div>
                {{ $data['father_education'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Mother's Education:</div>
                {{ $data['mother_education'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Father's Contact:</div>
                {{ $data['father_contact'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Mother's Contact:</div>
                {{ $data['mother_contact'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">No. of Siblings:</div>
                {{ $data['no_of_siblings'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Position in Family:</div>
                {{ $data['family_position'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Family Structure:</div>
                {{ $data['family_structure'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Languages Spoken:</div>
                {{ $data['languages_spoken'] ?? 'N/A' }}
            </div>
        </div>
    </div>

    <!-- Section III: Health Information -->
    <div class="section">
        <div class="section-title">III. HEALTH INFORMATION</div>
        <div class="response-item">
            <div class="response-label">General Health:</div>
            <div class="response-value">{{ $data['general_health'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Medical Condition:</div>
            <div class="response-value">
                {{ $data['has_medical_condition'] ?? 'N/A' }}
                @if(isset($data['medical_condition_specify']) && $data['medical_condition_specify'])
                    - {{ $data['medical_condition_specify'] }}
                @endif
            </div>
        </div>
        <div class="response-item">
            <div class="response-label">Maintenance Medication:</div>
            <div class="response-value">
                {{ $data['has_maintenance_meds'] ?? 'N/A' }}
                @if(isset($data['maintenance_meds_specify']) && $data['maintenance_meds_specify'])
                    - {{ $data['maintenance_meds_specify'] }}
                @endif
            </div>
        </div>
        <div class="response-item">
            <div class="response-label">Emergency Contact:</div>
            <div class="response-value">
                {{ $data['emergency_contact_name'] ?? 'N/A' }}
                ({{ $data['emergency_contact_relationship'] ?? 'N/A' }})
                - {{ $data['emergency_contact_number'] ?? 'N/A' }}
            </div>
        </div>
    </div>

    <!-- Section IV: Academic Profile -->
    <div class="section">
        <div class="section-title">IV. ACADEMIC PROFILE</div>
        <div class="response-item">
            <div class="response-label">Previous School:</div>
            <div class="response-value">{{ $data['previous_school'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Academic Strengths:</div>
            <div class="response-value">{{ $data['academic_strengths'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Areas Needing Improvement:</div>
            <div class="response-value">{{ $data['areas_improvement'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Study Habits:</div>
            <div class="response-value">{{ $data['study_habits'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Learning Style:</div>
            <div class="response-value">
                @if(isset($data['learning_style']) && is_array($data['learning_style']))
                    @foreach($data['learning_style'] as $style)
                        <span class="badge">{{ $style }}</span>
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
        <div class="response-item">
            <div class="response-label">Academic Activities:</div>
            <div class="response-value">
                {{ $data['has_academic_activities'] ?? 'N/A' }}
                @if(isset($data['academic_activities_specify']) && $data['academic_activities_specify'])
                    - {{ $data['academic_activities_specify'] }}
                @endif
            </div>
        </div>
    </div>

    <!-- Section V: Interests and Hobbies -->
    <div class="section">
        <div class="section-title">V. INTERESTS, HOBBIES & SOCIAL-EMOTIONAL PROFILE</div>
        <div class="response-item">
            <div class="response-label">Hobbies/Interests:</div>
            <div class="response-value">{{ $data['hobbies'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Talents/Skills:</div>
            <div class="response-value">{{ $data['talents'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Extra-curricular Activities:</div>
            <div class="response-value">{{ $data['extracurricular'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Awards/Recognitions:</div>
            <div class="response-value">{{ $data['awards'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Self-Description:</div>
            <div class="response-value">
                @if(isset($data['describe_yourself']) && is_array($data['describe_yourself']))
                    @foreach($data['describe_yourself'] as $trait)
                        <span class="badge">{{ $trait }}</span>
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
        <div class="response-item">
            <div class="response-label">Gets Along With:</div>
            <div class="response-value">
                @if(isset($data['get_along_with']) && is_array($data['get_along_with']))
                    @foreach($data['get_along_with'] as $person)
                        <span class="badge">{{ $person }}</span>
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
        <div class="response-item">
            <div class="response-label">Talks to When Having Problems:</div>
            <div class="response-value">{{ $data['talk_to_when_problem'] ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- Section VI: Guidance Needs Assessment -->
    <div class="section">
        <div class="section-title">VI. GUIDANCE NEEDS ASSESSMENT</div>
        <div class="response-item">
            <div class="response-label">Areas Needing Help/Support:</div>
            <div class="response-value">
                @if(isset($data['guidance_needs']) && is_array($data['guidance_needs']))
                    @foreach($data['guidance_needs'] as $need)
                        <span class="badge">{{ $need }}</span>
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
    </div>

    <!-- Section VII: Student Reflection -->
    <div class="section">
        <div class="section-title">VII. STUDENT REFLECTION</div>
        <div class="response-item">
            <div class="response-label">Goals This School Year:</div>
            <div class="response-value">{{ $data['goals_this_year'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Expected Challenges:</div>
            <div class="response-value">{{ $data['expected_challenges'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Plan to Overcome Them:</div>
            <div class="response-value">{{ $data['plan_to_overcome'] ?? 'N/A' }}</div>
        </div>
    </div>

    @if($submission->counselor_notes)
    <div class="section">
        <div class="section-title">COUNSELOR NOTES</div>
        <div class="response-item">
            {{ $submission->counselor_notes }}
        </div>
    </div>
    @endif

    <div class="footer">
        <strong>BULAN NATIONAL HIGH SCHOOL - Guidance & Counseling Office</strong> | 
        Student: {{ $submission->student->name }} | 
        Submitted: {{ $submission->created_at->format('M d, Y') }} | 
        Generated: {{ now()->format('M d, Y h:i A') }} | CONFIDENTIAL
    </div>
</body>
</html>
