<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Curriculum Exit Survey - {{ $submission->student->name }}</title>
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
        <h1>CURRICULUM EXIT SURVEY</h1>
        <h2>Senior High School Graduating Learners</h2>
    </div>

    @php
        $data = $submission->form_data;
    @endphp

    <!-- Section I: Learner Information -->
    <div class="section">
        <div class="section-title">I. LEARNER INFORMATION</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">LRN:</div>
                {{ $data['lrn'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Sex:</div>
                {{ $data['sex'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Age:</div>
                {{ $data['age'] ?? 'N/A' }} years old
            </div>
            <div class="info-item">
                <div class="info-label">Contact:</div>
                {{ $data['contact'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Grade Level:</div>
                {{ $data['grade_level'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Track:</div>
                {{ $data['track'] ?? 'N/A' }}
            </div>
            <div class="info-item" style="grid-column: span 2;">
                <div class="info-label">Strand/Elective:</div>
                {{ $data['strand'] ?? 'N/A' }}
            </div>
        </div>
    </div>

    <!-- Section II: Curriculum Exit Information -->
    <div class="section">
        <div class="section-title">II. CURRICULUM EXIT INFORMATION</div>
        <div class="response-item">
            <div class="response-label">Intended Curriculum Exit:</div>
            <div class="response-value">{{ $data['intended_exit'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Certainty Level:</div>
            <div class="response-value">{{ $data['certainty'] ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- Section III: Guidance and Decision-Making -->
    <div class="section">
        <div class="section-title">III. GUIDANCE AND DECISION-MAKING</div>
        <div class="response-item">
            <div class="response-label">Guided By:</div>
            <div class="response-value">
                @if(isset($data['guided_by']) && is_array($data['guided_by']))
                    @foreach($data['guided_by'] as $person)
                        <span class="badge">{{ $person }}</span>
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
        <div class="response-item">
            <div class="response-label">Helpful Services:</div>
            <div class="response-value">
                @if(isset($data['services_helped']) && is_array($data['services_helped']))
                    @foreach($data['services_helped'] as $service)
                        <span class="badge">{{ $service }}</span>
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
        <div class="response-item">
            <div class="response-label">Guidance Helpfulness:</div>
            <div class="response-value">{{ $data['guidance_helpfulness'] ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- Conditional Sections Based on Intended Exit -->
    @if(isset($data['intended_exit']) && str_contains($data['intended_exit'], 'College'))
    <div class="section">
        <div class="section-title">IV. COLLEGE EDUCATION</div>
        <div class="response-item">
            <div class="response-label">Preferred Course:</div>
            <div class="response-value">{{ $data['college_course'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">College/University:</div>
            <div class="response-value">{{ $data['college_name'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Admission Status:</div>
            <div class="response-value">{{ $data['college_status'] ?? 'N/A' }}</div>
        </div>
    </div>
    @endif

    @if(isset($data['intended_exit']) && str_contains($data['intended_exit'], 'Employment'))
    <div class="section">
        <div class="section-title">V. EMPLOYMENT</div>
        <div class="response-item">
            <div class="response-label">Preferred Work Type:</div>
            <div class="response-value">{{ $data['employment_type'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Has Employer:</div>
            <div class="response-value">{{ $data['has_employer'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Work Start:</div>
            <div class="response-value">{{ $data['work_start'] ?? 'N/A' }}</div>
        </div>
    </div>
    @endif

    <!-- Section IX: 21st Century Skills -->
    <div class="section">
        <div class="section-title">IX. 21ST-CENTURY SKILLS</div>
        <div class="response-item">
            <div class="response-value">
                @if(isset($data['skills_21st']) && is_array($data['skills_21st']))
                    @foreach($data['skills_21st'] as $skill)
                        <span class="badge">{{ $skill }}</span>
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
    </div>

    <!-- Section X: Values Developed -->
    <div class="section">
        <div class="section-title">X. VALUES DEVELOPED</div>
        <div class="response-item">
            <div class="response-value">
                @if(isset($data['values']) && is_array($data['values']))
                    @foreach($data['values'] as $value)
                        <span class="badge">{{ $value }}</span>
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
    </div>

    <!-- Section XI: Readiness -->
    <div class="section">
        <div class="section-title">XI. READINESS AND FUTURE PLANS</div>
        <div class="response-item">
            <div class="response-label">Readiness Level:</div>
            <div class="response-value">{{ $data['readiness'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Expected Support:</div>
            <div class="response-value">{{ $data['expected_support'] ?? 'N/A' }}</div>
        </div>
        <div class="response-item">
            <div class="response-label">Suggestions:</div>
            <div class="response-value">{{ $data['suggestions'] ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- Section XII: Follow-Up Tracking -->
    <div class="section">
        <div class="section-title">XII. FOLLOW-UP TRACKING</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Allow Contact:</div>
                {{ $data['allow_contact'] ?? 'N/A' }}
            </div>
            <div class="info-item">
                <div class="info-label">Contact Method:</div>
                @if(isset($data['contact_method']) && is_array($data['contact_method']))
                    {{ implode(', ', $data['contact_method']) }}
                @else
                    N/A
                @endif
            </div>
            <div class="info-item" style="grid-column: span 2;">
                <div class="info-label">Immediate Plan:</div>
                {{ $data['immediate_plan'] ?? 'N/A' }}
            </div>
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
