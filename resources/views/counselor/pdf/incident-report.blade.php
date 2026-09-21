<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Incident Report - {{ $report->case_number }}</title>
    <style>
        @page { margin: 15mm; }
        body {
            font-family: 'Arial', 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 3px solid #1e7a4a;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0 0 3px 0;
            color: #1e7a4a;
            font-weight: bold;
        }
        .header h2 {
            font-size: 11pt;
            margin: 0 0 3px 0;
            color: #333;
            font-weight: normal;
        }
        .header .case-num {
            font-size: 10pt;
            margin: 3px 0 0 0;
            font-weight: bold;
        }
        .meta-bar {
            background: #f5f5f5;
            padding: 6px 10px;
            margin-bottom: 10px;
            border-radius: 3px;
            display: flex;
            justify-content: space-between;
            font-size: 8.5pt;
        }
        .meta-item {
            display: inline-block;
        }
        .meta-label {
            font-weight: bold;
            margin-right: 4px;
        }
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #fff;
            background: #1e7a4a;
            padding: 4px 8px;
            margin-bottom: 6px;
            border-radius: 2px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
        }
        .info-table td {
            padding: 3px 6px;
            border-bottom: 1px solid #e5e5e5;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 30%;
            color: #555;
        }
        .desc-box {
            background: #f9f9f9;
            padding: 6px 8px;
            border-left: 3px solid #1e7a4a;
            margin-top: 4px;
            white-space: pre-wrap;
            font-size: 8.5pt;
            line-height: 1.4;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-high { background: #fee2e2; color: #991b1b; }
        .badge-moderate { background: #fef3c7; color: #92400e; }
        .badge-low { background: #dbeafe; color: #1e40af; }
        .footer {
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            font-size: 7pt;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BULAN NATIONAL HIGH SCHOOL</h1>
        <h2>Guidance & Counseling Office</h2>
        <div class="case-num">INCIDENT REPORT — {{ $report->case_number }}</div>
    </div>

    <div class="meta-bar">
        <div class="meta-item">
            <span class="meta-label">Date Reported:</span> {{ $report->date_of_referral->format('M d, Y') }}
        </div>
        <div class="meta-item">
            <span class="meta-label">Time:</span> {{ $report->time_of_incident }}
        </div>
        <div class="meta-item">
            <span class="meta-label">Urgency:</span>
            <span class="badge badge-{{ strtolower($report->urgency_level) }}">{{ $report->urgency_level }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Status:</span> {{ ucfirst($report->status) }}
        </div>
    </div>

    <div class="two-col">
        <div class="section">
            <div class="section-title">Student Information</div>
            <table class="info-table">
                <tr><td>Name:</td><td>{{ $report->student_name }}</td></tr>
                <tr><td>Age:</td><td>{{ $report->student_age ?? 'N/A' }}</td></tr>
                <tr><td>Grade & Section:</td><td>{{ $report->grade_section }}</td></tr>
                <tr><td>Address:</td><td>{{ $report->student_address ?: 'N/A' }}</td></tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Quick Information</div>
            <table class="info-table">
                <tr><td>Category:</td><td>{{ $report->incident_category_label ?? 'N/A' }}</td></tr>
                <tr><td>Concern Type:</td><td>{{ $report->concern_type_label ?? 'N/A' }}</td></tr>
                <tr><td>Referred By:</td><td>{{ $report->teacher->name ?? $report->referred_by_name ?? 'N/A' }}</td></tr>
                @if($report->counselor)
                <tr><td>Assigned To:</td><td>{{ $report->counselor->name }}</td></tr>
                @endif
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Incident Description</div>
        <div class="desc-box">{{ $report->incident_description }}</div>
    </div>

    @if($report->initial_intervention)
    <div class="section">
        <div class="section-title">Initial Intervention Taken</div>
        <div class="desc-box">{{ $report->initial_intervention }}</div>
    </div>
    @endif

    <div class="two-col">
        @if($report->parent_guardian_name || $report->parent_guardian_contact)
        <div class="section">
            <div class="section-title">Parent/Guardian</div>
            <table class="info-table">
                <tr><td>Name:</td><td>{{ $report->parent_guardian_name ?: 'N/A' }}</td></tr>
                <tr><td>Contact:</td><td>{{ $report->parent_guardian_contact ?: 'N/A' }}</td></tr>
            </table>
        </div>
        @endif

        @if($report->referred_by_designation)
        <div class="section">
            <div class="section-title">Referral Details</div>
            <table class="info-table">
                <tr><td>Designation:</td><td>{{ $report->referred_by_designation }}</td></tr>
            </table>
        </div>
        @endif
    </div>

    @if($report->counselor_notes)
    <div class="section">
        <div class="section-title">Counselor Notes</div>
        <div class="desc-box">{{ $report->counselor_notes }}</div>
    </div>
    @endif

    <div class="footer">
        <p><strong>BULAN NATIONAL HIGH SCHOOL - Guidance & Counseling Office</strong></p>
        <p>Generated on {{ now()->format('F d, Y h:i A') }} | <em>CONFIDENTIAL DOCUMENT - For authorized personnel only</em></p>
    </div>
</body>
</html>
