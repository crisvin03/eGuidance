@extends('layouts.dashboard')
@section('title', 'Form Details')

@section('content')

@php
    $isReviewed = in_array($submission->status, ['reviewed', 'acknowledged']);
    $statusColor = match($submission->status) {
        'submitted'    => ['bg' => '#fef3c7', 'text' => '#92400e', 'border' => '#fbbf24'],
        'reviewed'     => ['bg' => '#eff6ff', 'text' => '#1e40af', 'border' => '#93c5fd'],
        'acknowledged' => ['bg' => '#ecfdf5', 'text' => '#065f46', 'border' => '#6ee7b7'],
        default        => ['bg' => '#f1f5f9', 'text' => '#475569', 'border' => '#cbd5e1'],
    };

    $fields = $submission->form_data ?? [];
    if (is_string($fields)) {
        try { $fields = json_decode($fields, true) ?? []; } catch(\Exception $e) { $fields = []; }
    }

    $labelMap = [
        'ff_student_name'  => 'Student Name',
        'ff_grade_section' => 'Grade & Section',
        'ff_school'        => 'School',
        'ff_adviser'       => 'Adviser / Class Teacher',
        'ff_offense'       => 'Offense Level',
        'ff_brand'         => 'Brand / Model',
        'ff_serial'        => 'Serial Number',
        'ff_color'         => 'Description / Color',
        'ff_day'           => 'Day of Appointment',
        'ff_date'          => 'Date',
        'ff_time'          => 'Time',
        'ff_lrn'           => 'LRN',
        'ff_age'           => 'Age',
        'ff_school_year'   => 'School Year',
        'ff_address'       => 'Address',
        'ff_contact'       => 'Contact Number',
        'ff_email'         => 'Email Address',
        'ff_requestor'     => 'Requestor',
        'ff_purpose'       => 'Purpose',
        'ff_parent'        => 'Parent / Guardian Name',
        'ff_teacher'       => 'Teacher-in-Charge',
        'ff_docno'         => 'Document No.',
        'ff_specify'       => 'Item Specified',
        'ff_context'       => 'Context / Background',
        'ff_observations'  => 'Observations / Notes',
        'ff_reason_other'  => 'Other Reason',
        'ff_reason1'       => 'Reason: Unauthorized use of device',
        'ff_reason2'       => 'Reason: Uploading/sharing recordings',
        'ff_reason3'       => 'Reason: Unauthorized social media access',
        'ff_action1'       => 'Action: Device temporarily confiscated',
        'ff_action2'       => 'Action: Device deposited at School Head',
        'ff_action3'       => 'Action: Return at end of class/day',
        'ff_action4'       => 'Action: Return only to parent/guardian',
        'ff_action5'       => 'Action: Parental notice issued',
        'ff_action6'       => 'Action: Disciplinary action recommended',
        'ff_item1'         => 'Confiscated: Pornographic Materials',
        'ff_item2'         => 'Confiscated: Unnecessary harmful items',
        'ff_item3'         => 'Confiscated: Flammable/hazardous chemicals',
        'ff_item4'         => 'Confiscated: Deadly Weapon/s',
        'ff_item5'         => 'Confiscated: Cigarettes / Vape',
        'ff_item6'         => 'Confiscated: Gambling Paraphernalia',
        'ff_item7'         => 'Confiscated: Others',
        'ff_purpose1'      => 'Purpose: Absences / Frequent Tardiness',
        'ff_purpose2'      => 'Purpose: Declining Academic Performance',
        'ff_purpose3'      => 'Purpose: Behavioral / Discipline Concern',
        'ff_purpose4'      => 'Purpose: Well-being / Psychosocial Support',
        'ff_purpose5'      => "Purpose: Verification of Learner's Living Condition",
        'ff_purpose6'      => 'Purpose: Implementation of Individual Plan',
        'ff_purpose7'      => 'Purpose: Delivery of Learning Materials',
        'ff_purpose8'      => 'Purpose: Monitoring of Intervention',
    ];

    $riskRows = [];
    $bagRows  = [];
    foreach ($fields as $k => $v) {
        if (preg_match('/^ff_risk_(\d+)_(\d+)$/', $k, $m)) $riskRows[$m[1]][$m[2]] = $v;
        if (preg_match('/^ff_bag_(\d+)_(\d+)$/', $k, $m))  $bagRows[$m[1]][$m[2]]  = $v;
    }
    ksort($riskRows);
    ksort($bagRows);

    $skipKeys = ['ff_student_name','ff_grade_section'];
    $displayFields = array_filter($fields, function($v, $k) use ($skipKeys) {
        return !in_array($k, $skipKeys)
            && !preg_match('/^ff_(risk|bag)_\d+_\d+$/', $k)
            && $v !== null && $v !== '' && $v !== false;
    }, ARRAY_FILTER_USE_BOTH);

    $checkboxKeys = ['ff_reason1','ff_reason2','ff_reason3','ff_action1','ff_action2','ff_action3',
                     'ff_action4','ff_action5','ff_action6','ff_item1','ff_item2','ff_item3',
                     'ff_item4','ff_item5','ff_item6','ff_item7','ff_purpose1','ff_purpose2',
                     'ff_purpose3','ff_purpose4','ff_purpose5','ff_purpose6','ff_purpose7','ff_purpose8'];
@endphp

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="mb-3">
    <a href="{{ route('counselor.forms.submitted') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Submitted Forms
    </a>
</div>

<div class="row g-4">
    {{-- Left: Form content --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2 py-3 px-4"
                 style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <div>
                    <h5 class="fw-bold mb-0">{{ $submission->form_title }}</h5>
                    <small class="text-muted">Submitted by <strong>{{ $submission->teacher->name ?? 'Unknown' }}</strong>
                        on {{ $submission->created_at->format('F d, Y \a\t h:i A') }}</small>
                </div>
                <span class="badge fs-6 px-3 py-2 fw-semibold text-capitalize"
                      style="background:{{ $statusColor['bg'] }};color:{{ $statusColor['text'] }};border:1px solid {{ $statusColor['border'] }};">
                    @if($submission->status === 'submitted') <i class="bi bi-clock me-1"></i>
                    @elseif($submission->status === 'reviewed') <i class="bi bi-eye me-1"></i>
                    @else <i class="bi bi-check-circle me-1"></i>
                    @endif
                    {{ ucfirst($submission->status) }}
                </span>
            </div>
            <div class="card-body p-4">

                {{-- Student info --}}
                @if($submission->student_name)
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f0fdfa;border:1px solid #99f6e4;">
                            <small class="d-block fw-semibold" style="color:#0f766e;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.4px;">Student Name</small>
                            <div class="fw-bold mt-1">{{ $submission->student_name }}</div>
                        </div>
                    </div>
                    @if($submission->grade_section)
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f0fdfa;border:1px solid #99f6e4;">
                            <small class="d-block fw-semibold" style="color:#0f766e;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.4px;">Grade & Section</small>
                            <div class="fw-bold mt-1">{{ $submission->grade_section }}</div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Form fields --}}
                @if(count($displayFields))
                <h6 class="fw-bold mb-3" style="color:#1e293b;">
                    <i class="bi bi-list-ul me-1" style="color:#20B2AA;"></i>Filled-out Details
                </h6>
                <div class="row g-3">
                    @foreach($displayFields as $key => $value)
                        @php
                            $label = $labelMap[$key] ?? ucwords(str_replace(['ff_', '_'], ['', ' '], $key));
                            $isCb = in_array($key, $checkboxKeys) || is_bool($value);
                        @endphp
                        @if($isCb)
                            @if($value && $value !== '0' && $value !== 'false' && $value !== false)
                            <div class="col-md-12">
                                <div class="p-3 rounded-3 d-flex align-items-center gap-2"
                                     style="background:#f0fdfa;border:1px solid #99f6e4;">
                                    <i class="bi bi-check-circle-fill" style="color:#20B2AA;"></i>
                                    <span class="small fw-semibold">{{ $label }}</span>
                                    @if(!is_bool($value) && !in_array((string)$value, ['true','1']))
                                        <span class="text-muted small ms-1">— {{ $value }}</span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @else
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                    <small class="d-block text-muted fw-semibold"
                                           style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.4px;">{{ $label }}</small>
                                    <div class="mt-1 small fw-semibold">{{ $value }}</div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                @endif

                {{-- Risk rows --}}
                @if(count($riskRows))
                <div class="mt-4">
                    <h6 class="fw-bold mb-2" style="color:#1e293b;"><i class="bi bi-table me-1" style="color:#20B2AA;"></i>Risk Assessment Entries</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0" style="font-size:0.82rem;">
                            <thead style="background:#f8fafc;">
                                <tr><th>Identified Risk</th><th>Risk Factors</th><th>Probability</th><th>Impact</th><th>Action to be Taken</th></tr>
                            </thead>
                            <tbody>
                                @foreach($riskRows as $row)
                                <tr>@for($c=0;$c<5;$c++)<td>{{ $row[$c] ?? '' }}</td>@endfor</tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                {{-- Bag rows --}}
                @if(count($bagRows))
                <div class="mt-4">
                    <h6 class="fw-bold mb-2" style="color:#1e293b;"><i class="bi bi-table me-1" style="color:#20B2AA;"></i>Bag Search Plan Entries</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0" style="font-size:0.82rem;">
                            <thead style="background:#f8fafc;">
                                <tr><th>Grade Level</th><th>Frequency</th><th>Persons Responsible</th><th>Resources</th></tr>
                            </thead>
                            <tbody>
                                @foreach($bagRows as $row)
                                <tr>@for($c=0;$c<4;$c++)<td>{{ $row[$c] ?? '' }}</td>@endfor</tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                {{-- Existing counselor notes --}}
                @if($submission->counselor_notes)
                <hr class="my-4">
                <div class="alert mb-0" style="background:#eff6ff;border:1px solid #93c5fd;border-radius:12px;">
                    <h6 class="fw-bold mb-1" style="color:#1e40af;"><i class="bi bi-chat-left-text me-1"></i>Your Notes</h6>
                    <p class="mb-1 small" style="color:#1e40af;">{{ $submission->counselor_notes }}</p>
                    @if($submission->reviewed_at)
                        <small class="text-muted">Reviewed on {{ $submission->reviewed_at->format('F d, Y \a\t h:i A') }}</small>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- Review form (only if not yet reviewed) --}}
        @if(!$isReviewed)
        <div class="card border-0 shadow-sm mt-4" style="border-radius:16px;border:2px solid #20B2AA !important;">
            <div class="card-header py-3 px-4" style="background:#f0fdfa;border-radius:16px 16px 0 0;">
                <h6 class="fw-bold mb-0" style="color:#0f766e;">
                    <i class="bi bi-pencil-square me-1"></i>Mark as Reviewed
                </h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('counselor.forms.submitted.review', $submission->id) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="reviewed">Reviewed</option>
                                <option value="acknowledged">Acknowledged</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Notes (optional)</label>
                            <textarea class="form-control" name="counselor_notes" rows="2"
                                      placeholder="Add your notes or feedback for the teacher..."></textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn fw-semibold text-white" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                            <i class="bi bi-check-circle me-1"></i> Save Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>

    {{-- Right sidebar --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3" style="border-radius:16px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Form Information</h6>
                <div class="d-flex flex-column gap-3">
                    <div>
                        <small class="text-muted d-block" style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.4px;">Submitted By</small>
                        <span class="fw-semibold small">{{ $submission->teacher->name ?? '—' }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.4px;">Form Type</small>
                        <span class="fw-semibold small">{{ $submission->form_title }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.4px;">Date Submitted</small>
                        <span class="fw-semibold small">{{ $submission->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.4px;">Status</small>
                        <span class="badge fw-semibold text-capitalize"
                              style="background:{{ $statusColor['bg'] }};color:{{ $statusColor['text'] }};border:1px solid {{ $statusColor['border'] }};">
                            {{ ucfirst($submission->status) }}
                        </span>
                    </div>
                    @if($submission->reviewed_at)
                    <div>
                        <small class="text-muted d-block" style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.4px;">Reviewed On</small>
                        <span class="fw-semibold small">{{ $submission->reviewed_at->format('M d, Y h:i A') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm"
             style="border-radius:16px;{{ $isReviewed ? 'border:2px solid #99f6e4 !important;' : '' }}">
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle"
                         style="width:52px;height:52px;background:{{ $isReviewed ? 'rgba(32,178,170,0.12)' : '#fef3c7' }};">
                        <i class="bi bi-printer fs-4" style="color:{{ $isReviewed ? '#20B2AA' : '#d97706' }};"></i>
                    </div>
                </div>
                @if($isReviewed)
                <h6 class="fw-bold mb-1">Print This Form</h6>
                <p class="text-muted small mb-3">Prints in the exact same official format as the original.</p>
                <button class="btn w-100 fw-semibold text-white"
                        style="background:linear-gradient(135deg,#20B2AA,#008B8B);"
                        onclick="printStoredForm()">
                    <i class="bi bi-printer me-1"></i> Print Form
                </button>
                @else
                <h6 class="fw-bold mb-1">Print Not Yet Available</h6>
                <p class="text-muted small mb-0">Review the form first to enable printing.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@if($isReviewed)
@include('partials.form-print-builder')

<script>
const storedFormData    = @json($fields);
const storedFormId      = @json($submission->form_type);
const storedTeacherName = @json($submission->teacher->name ?? 'Teacher');
const storedSubmittedAt = @json($submission->created_at->format('F d, Y'));

function printStoredForm() {
    const html = buildStoredPrintContent(storedFormId, storedFormData, storedTeacherName, storedSubmittedAt);
    const w = window.open('', '_blank', 'width=900,height=700');
    w.document.write(html);
    w.document.close();
    setTimeout(() => w.print(), 600);
}
</script>
@endif

@endsection
