<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Referral - {{ $referral->referral_number }}</title>
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
        .header .ref-num {
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
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-ongoing { background: #dbeafe; color: #1e40af; }
        .badge-closed { background: #d1fae5; color: #065f46; }
        .footer {
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            font-size: 7pt;
            color: #666;
            text-align: center;
        }
        .label-inline {
            font-weight: bold;
            margin-top: 6px;
            display: block;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BULAN NATIONAL HIGH SCHOOL</h1>
        <h2>Guidance & Counseling Office</h2>
        <div class="ref-num">STUDENT REFERRAL FORM — {{ $referral->referral_number }}</div>
    </div>

    <div class="meta-bar">
        <div class="meta-item">
            <span class="meta-label">Date:</span> {{ $referral->created_at->format('M d, Y') }}
        </div>
        <div class="meta-item">
            <span class="meta-label">Status:</span>
            <span class="badge badge-{{ $referral->status }}">{{ $referral->status }}</span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Category:</span> {{ ucfirst(str_replace('_', ' ', $referral->referral_category ?? 'General')) }}
        </div>
    </div>

    <div class="two-col">
        <div class="section">
            <div class="section-title">Student Information</div>
            <table class="info-table">
                <tr><td>Name:</td><td>{{ $referral->student_name }}</td></tr>
                <tr><td>Age:</td><td>{{ $referral->student_age ?? 'N/A' }}</td></tr>
                <tr><td>Grade & Section:</td><td>{{ $referral->grade_section }}</td></tr>
                <tr><td>Address:</td><td>{{ $referral->student_address ?: 'N/A' }}</td></tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Referral Information</div>
            <table class="info-table">
                <tr><td>Referred By:</td><td>{{ $referral->teacher->name ?? 'N/A' }}</td></tr>
                @if($referral->preferred_followup)
                <tr><td>Follow-Up:</td><td>{{ $referral->preferred_followup }}</td></tr>
                @endif
                @if($referral->counselor)
                <tr><td>Assigned To:</td><td>{{ $referral->counselor->name }}</td></tr>
                @endif
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Reason for Referral</div>
        <div class="desc-box">{{ $referral->reason_for_referral }}</div>
    </div>

    @if($referral->observed_behavior)
    <div class="section">
        <div class="section-title">Observed Behavior</div>
        <div class="desc-box">{{ $referral->observed_behavior }}</div>
    </div>
    @endif

    @if($referral->actions_taken)
    <div class="section">
        <div class="section-title">Actions Already Taken</div>
        <div class="desc-box">{{ $referral->actions_taken }}</div>
    </div>
    @endif

    @if($referral->additional_notes)
    <div class="section">
        <div class="section-title">Additional Notes</div>
        <div class="desc-box">{{ $referral->additional_notes }}</div>
    </div>
    @endif

    @if($referral->counselor_notes)
    <div class="section">
        <div class="section-title">Counselor Notes</div>
        <div class="desc-box">{{ $referral->counselor_notes }}</div>
    </div>
    @endif

    <div class="footer">
        <p><strong>BULAN NATIONAL HIGH SCHOOL - Guidance & Counseling Office</strong></p>
        <p>Generated on {{ now()->format('F d, Y h:i A') }} | <em>CONFIDENTIAL DOCUMENT - For authorized personnel only</em></p>
    </div>
</body>
</html>
