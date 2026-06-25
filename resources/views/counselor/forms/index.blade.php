@extends('layouts.dashboard')
@section('title', 'Forms & Downloads')

@section('content')

@php
    $pendingCount = \App\Models\TeacherFormSubmission::where('status', 'submitted')->count();
@endphp

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h5 class="fw-bold mb-0">Forms & Downloads</h5>
        <small class="text-muted">Generate forms and review forms submitted by teachers</small>
    </div>
    <a href="{{ route('counselor.forms.submitted') }}" class="btn text-white fw-semibold position-relative" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
        <i class="bi bi-inbox me-1"></i> Submitted Forms by Teachers
        @if($pendingCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.7rem;">
                {{ $pendingCount }}
            </span>
        @endif
    </a>
</div>

<div class="row g-4">
    @php
        $forms = [
            ['icon' => 'bi-phone',            'title' => 'Confiscation Slip (Electronic Device)', 'desc' => 'For confiscation of portable electronic devices per school policy.',    'id' => 'confiscation-electronic'],
            ['icon' => 'bi-envelope-paper',   'title' => 'Call Slip',                             'desc' => 'For summoning parents/guardians to the Guidance Office.',              'id' => 'call-slip'],
            ['icon' => 'bi-shield-exclamation','title' => 'Initial Risk Assessment Form',         'desc' => 'For initial risk assessment of students with safety concerns.',         'id' => 'risk-assessment'],
            ['icon' => 'bi-slash-circle',      'title' => 'Confiscation Slip (Prohibited Items)', 'desc' => 'For confiscation of prohibited or dangerous items from students.',     'id' => 'confiscation-prohibited'],
            ['icon' => 'bi-backpack',          'title' => 'Random Routine Bag Search Plan',       'desc' => 'For documenting routine bag search activities per school year.',       'id' => 'bag-search'],
            ['icon' => 'bi-award',             'title' => 'Good Moral Request Form',              'desc' => 'For requesting good moral character certification for students.',      'id' => 'good-moral'],
            ['icon' => 'bi-house-heart',       'title' => 'Home Visitation Form',                 'desc' => 'For documenting home visitation activities and observations.',        'id' => 'home-visitation'],
            ['icon' => 'bi-journal-text',      'title' => 'Session Notes Template',               'desc' => 'Template for documenting counseling session notes.',                  'id' => 'session-notes'],
            ['icon' => 'bi-clipboard-data',    'title' => 'Case Summary Report',                  'desc' => 'Template for comprehensive case summary and documentation.',          'id' => 'case-summary'],
        ];
    @endphp

    @foreach($forms as $form)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;min-width:45px;background:rgba(32,178,170,0.1);">
                        <i class="bi {{ $form['icon'] }} fs-5" style="color:#20B2AA;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">{{ $form['title'] }}</h6>
                        <p class="text-muted small mb-0">{{ $form['desc'] }}</p>
                    </div>
                </div>
                <div class="mt-auto pt-3 border-top">
                    <button class="btn btn-sm text-white w-100 fw-semibold" style="background:linear-gradient(135deg,#20B2AA,#008B8B);"
                            onclick="openFormGenerator('{{ $form['id'] }}', '{{ $form['title'] }}')">
                        <i class="bi bi-file-earmark-plus me-1"></i> Generate Form
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Form Generator Modal -->
<div class="modal fade" id="formModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalTitle">Generate Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="formModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn text-white" style="background:#20B2AA;" onclick="generateAndPrint()">
                    <i class="bi bi-printer me-1"></i> Generate & Print
                </button>
            </div>
        </div>
    </div>
</div>

<div id="printContainer" style="display:none;"></div>

{{-- Reuse the same JS from teacher forms --}}
<script>
const teacherName = @json(Auth::user()->name);
const today = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
const todayShort = new Date().toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
let currentFormId = '';

function openFormGenerator(formId, formTitle) {
    currentFormId = formId;
    document.getElementById('formModalTitle').textContent = 'Generate: ' + formTitle;
    document.getElementById('formModalBody').innerHTML = getFormFields(formId);
    new bootstrap.Modal(document.getElementById('formModal')).show();
}

function val(id) { const el = document.getElementById(id); return el ? el.value : ''; }
function checked(id) { const el = document.getElementById(id); return el ? el.checked : false; }
function checkbox(isChecked) { return isChecked ? '&#9746;' : '&#9744;'; }

function generateAndPrint() {
    const printContent = buildPrintContent(currentFormId);
    const printWindow = window.open('', '_blank', 'width=900,height=700');
    printWindow.document.write(printContent);
    printWindow.document.close();
    setTimeout(() => printWindow.print(), 500);
    bootstrap.Modal.getInstance(document.getElementById('formModal')).hide();
}

function addRiskRow() {
    const row = `<div class="row g-2 mb-2 risk-row">
        <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Identified Risk"></div>
        <div class="col-md-2"><input type="text" class="form-control form-control-sm" placeholder="Risk Factors"></div>
        <div class="col-md-2"><select class="form-select form-select-sm"><option>High</option><option>Medium</option><option>Low</option></select></div>
        <div class="col-md-2"><input type="text" class="form-control form-control-sm" placeholder="Impact"></div>
        <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Action to be Taken"></div>
    </div>`;
    document.getElementById('riskRows').insertAdjacentHTML('beforeend', row);
}

function addBagRow() {
    const row = `<div class="row g-2 mb-2 bag-row">
        <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Grade Level"></div>
        <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Frequency"></div>
        <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Persons Responsible"></div>
        <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Resources"></div>
    </div>`;
    document.getElementById('bagRows').insertAdjacentHTML('beforeend', row);
}
</script>

{{-- Include getFormFields and buildPrintContent from teacher forms --}}
<script src="{{ asset('js/form-generator.js') }}"></script>

@endsection
