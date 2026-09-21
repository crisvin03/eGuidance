<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Learner Reintegration Clearance - {{ $submission->student->name }}</title>
    <style>
        @page { margin: 15mm; }
        body {
            font-family: 'Arial', 'DejaVu Sans', sans-serif;
            font-size: 8.5pt;
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
            font-size: 10pt;
            margin: 0;
            color: #333;
            font-weight: normal;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px 10px;
            margin-bottom: 10px;
        }
        .info-item {
            font-size: 8pt;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 45%;
        }
        .section-title {
            font-size: 9pt;
            font-weight: bold;
            color: #fff;
            background: #1e7a4a;
            padding: 3px 6px;
            margin: 8px 0 5px 0;
        }
        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .checklist-table td {
            border: 1px solid #555;
            padding: 3px 5px;
            font-size: 7.5pt;
        }
        .checklist-table td:nth-child(2) {
            width: 30px;
            text-align: center;
        }
        .checklist-table td:nth-child(3) {
            width: 35%;
        }
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1.5px solid #000;
            position: relative;
            vertical-align: middle;
        }
        .checkbox.checked::after {
            content: '✓';
            position: absolute;
            left: 1px;
            top: -3px;
            font-size: 11pt;
            font-weight: bold;
        }
        .status-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px;
            margin: 8px 0;
        }
        .status-box {
            border: 1px solid #333;
            padding: 5px;
            font-size: 7.5pt;
        }
        .support-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 3px 8px;
            margin: 5px 0;
            font-size: 7.5pt;
        }
        .remarks-box {
            border: 1px solid #333;
            padding: 5px;
            min-height: 40px;
            margin: 5px 0;
            font-size: 7.5pt;
        }
        .signature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 10px;
        }
        .signature-box {
            font-size: 7.5pt;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin: 20px 0 3px 0;
        }
        .note-box {
            margin-top: 8px;
            padding: 5px;
            border: 1px solid #999;
            background: #f5f5f5;
            font-size: 7pt;
        }
        .footer {
            margin-top: 8px;
            text-align: center;
            font-size: 6.5pt;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LEARNER REINTEGRATION CLEARANCE</h1>
        <h2>For Return to Regular Classroom Participation</h2>
    </div>

    @php
        $data = $submission->form_data;
    @endphp

    <!-- Basic Information -->
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Name of Learner:</span> {{ $data['learner_name'] ?? '' }}
        </div>
        <div class="info-item">
            <span class="info-label">Grade & Section:</span> {{ $data['grade_section'] ?? '' }}
        </div>
        <div class="info-item">
            <span class="info-label">Reason:</span> {{ $data['reason'] ?? '' }}
        </div>
        <div class="info-item">
            <span class="info-label">Date of Return:</span> {{ isset($data['return_date']) ? \Carbon\Carbon::parse($data['return_date'])->format('M d, Y') : '' }}
        </div>
    </div>

    <!-- Reintegration Checklist -->
    <div class="section-title">REINTEGRATION CHECKLIST</div>
    <table class="checklist-table">
        <tr>
            <td><strong>1. Case Review</strong> – Learner's situation reviewed</td>
            <td><span class="checkbox {{ isset($data['checklist']['case_review']) && $data['checklist']['case_review'] ? 'checked' : '' }}"></span></td>
            <td>{{ $data['remarks']['case_review'] ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>2. Intervention</strong> – Support provided</td>
            <td><span class="checkbox {{ isset($data['checklist']['intervention']) && $data['checklist']['intervention'] ? 'checked' : '' }}"></span></td>
            <td>{{ $data['remarks']['intervention'] ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>3. Learner Conference</strong> – Oriented on expectations</td>
            <td><span class="checkbox {{ isset($data['checklist']['conference']) && $data['checklist']['conference'] ? 'checked' : '' }}"></span></td>
            <td>{{ $data['remarks']['conference'] ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>4. Parent Coordination</strong> – Parent informed</td>
            <td><span class="checkbox {{ isset($data['checklist']['parent_coord']) && $data['checklist']['parent_coord'] ? 'checked' : '' }}"></span></td>
            <td>{{ $data['remarks']['parent_coord'] ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>5. Readiness Assessment</strong> – Ready to return</td>
            <td><span class="checkbox {{ isset($data['checklist']['readiness']) && $data['checklist']['readiness'] ? 'checked' : '' }}"></span></td>
            <td>{{ $data['remarks']['readiness'] ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>6. Follow-Up Plan</strong> – Support identified</td>
            <td><span class="checkbox {{ isset($data['checklist']['followup']) && $data['checklist']['followup'] ? 'checked' : '' }}"></span></td>
            <td>{{ $data['remarks']['followup'] ?? '' }}</td>
        </tr>
    </table>

    <!-- Clearance Status & Support in 2 columns -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
        <!-- Clearance Status -->
        <div>
            <div class="section-title">CLEARANCE STATUS</div>
            <div style="font-size: 7.5pt; line-height: 1.4;">
                <div style="margin: 3px 0;"><span class="checkbox"></span> <strong>CLEARED FOR REINTEGRATION</strong></div>
                <div style="margin: 3px 0;"><span class="checkbox"></span> <strong>CLEARED WITH SUPPORT</strong></div>
                <div style="margin: 3px 0;"><span class="checkbox"></span> <strong>NOT YET CLEARED</strong></div>
            </div>
        </div>

        <!-- Follow-up Support -->
        <div>
            <div class="section-title">FOLLOW-UP SUPPORT</div>
            @php
                $supportItems = [
                    'counseling' => 'Counseling',
                    'teacher_monitoring' => 'Teacher Monitoring',
                    'parent_coordination' => 'Parent Coordination',
                    'behavior_monitoring' => 'Behavior Monitoring',
                    'academic_support' => 'Academic Support',
                ];
                $selectedSupport = $data['support'] ?? [];
            @endphp
            <div style="font-size: 7.5pt; line-height: 1.4;">
                @foreach($supportItems as $key => $label)
                    <div style="margin: 2px 0;"><span class="checkbox {{ in_array($key, $selectedSupport) ? 'checked' : '' }}"></span> {{ $label }}</div>
                @endforeach
                <div style="margin: 2px 0;"><span class="checkbox {{ in_array('other', $selectedSupport) ? 'checked' : '' }}"></span> Other: {{ in_array('other', $selectedSupport) ? ($data['other_support'] ?? '') : '_________' }}</div>
            </div>
        </div>
    </div>

    <!-- Recommendations -->
    <div class="section-title">RECOMMENDATIONS/REMARKS</div>
    <div class="remarks-box">
        @if(isset($data['additional_comments']) && $data['additional_comments'])
            {{ $data['additional_comments'] }}
        @endif
        @if($submission->counselor_notes)
            <br><strong>Counselor:</strong> {{ $submission->counselor_notes }}
        @endif
    </div>

    <!-- Signatures -->
    <div class="signature-grid">
        <div class="signature-box">
            <strong>CERTIFIED BY</strong>
            <div class="signature-line"></div>
            Guidance Counselor/CARE Personnel<br>
            Date: {{ $submission->reviewed_at ? $submission->reviewed_at->format('M d, Y') : '_______________' }}
        </div>
        <div class="signature-box">
            <strong>NOTED BY</strong>
            <div class="signature-line"></div>
            School Head/Authorized Personnel<br>
            Date: _______________
        </div>
    </div>

    <!-- Note -->
    <div class="note-box">
        <strong>NOTE:</strong> This clearance is based on current assessment. Learner may be subject to continued monitoring.
    </div>

    <div class="footer">
        <strong>BULAN NATIONAL HIGH SCHOOL - Guidance & Counseling Office</strong> | 
        Generated: {{ now()->format('M d, Y h:i A') }} | CONFIDENTIAL
    </div>
</body>
</html>
