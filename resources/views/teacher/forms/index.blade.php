@extends('layouts.dashboard')
@section('title', 'Generate Forms')

@section('content')
<style>
    .btn-send-counselor {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1.1rem;
        border-radius: 8px;
        border: 2px solid #20B2AA;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 600;
        color: #20B2AA;
        background: #ffffff;
        transition: all 0.2s;
    }
    .btn-send-counselor:hover {
        background: #20B2AA;
        color: #ffffff;
    }
    .btn-send-counselor:hover { opacity: 0.88; }
    .btn-send-counselor:disabled { opacity: 0.6; cursor: not-allowed; }
</style>
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h5 class="fw-bold mb-0">Generate Forms</h5>
        <small class="text-muted">Select a form, fill in the details, then send to the counselor for review.</small>
    </div>
    <a href="{{ route('teacher.forms.submissions') }}" class="btn text-white fw-semibold btn-sm" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
        <i class="bi bi-clock-history me-1"></i> My Submitted Forms
        @php $pendingCount = \App\Models\TeacherFormSubmission::where('teacher_id', Auth::id())->count(); @endphp
        @if($pendingCount > 0)
            <span class="badge rounded-pill bg-white ms-1" style="color:#20B2AA;font-size:0.7rem;">{{ $pendingCount }}</span>
        @endif
    </a>
</div>

<div class="row g-4">
    @php
        $forms = [
            ['icon' => 'bi-phone', 'title' => 'Confiscation Slip (Electronic Device)', 'desc' => 'For confiscation of portable electronic devices per school policy.', 'id' => 'confiscation-electronic'],
            ['icon' => 'bi-envelope-paper', 'title' => 'Call Slip', 'desc' => 'For summoning parents/guardians to the Guidance Office.', 'id' => 'call-slip'],
            ['icon' => 'bi-shield-exclamation', 'title' => 'Initial Risk Assessment Form', 'desc' => 'For initial risk assessment of students with safety concerns.', 'id' => 'risk-assessment'],
            ['icon' => 'bi-slash-circle', 'title' => 'Confiscation Slip (Prohibited Items)', 'desc' => 'For confiscation of prohibited or dangerous items from students.', 'id' => 'confiscation-prohibited'],
            ['icon' => 'bi-backpack', 'title' => 'Random Routine Bag Search Plan', 'desc' => 'For documenting routine bag search activities per school year.', 'id' => 'bag-search'],
            ['icon' => 'bi-award', 'title' => 'Good Moral Request Form', 'desc' => 'For requesting good moral character certification for students.', 'id' => 'good-moral'],
            ['icon' => 'bi-house-heart', 'title' => 'Home Visitation Form', 'desc' => 'For documenting home visitation activities and observations.', 'id' => 'home-visitation'],
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
            <div class="modal-body" id="formModalBody">
                <!-- Dynamic form fields will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-send-counselor" onclick="sendToCounselor()" id="sendBtn">
                    <i class="bi bi-send me-1"></i> Send to Counselor
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Print Container (hidden) -->
<div id="printContainer" style="display:none;"></div>

<script>
const teacherName = @json(Auth::user()->name);
const today = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
const todayShort = new Date().toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
const submitFormUrl = @json(route('teacher.forms.submit'));
const csrfToken = @json(csrf_token());
let currentFormId = '';
let currentFormTitle = '';

function openFormGenerator(formId, formTitle) {
    currentFormId = formId;
    currentFormTitle = formTitle;
    document.getElementById('formModalTitle').textContent = 'Generate: ' + formTitle;
    document.getElementById('formModalBody').innerHTML = getFormFields(formId);
    new bootstrap.Modal(document.getElementById('formModal')).show();
}

function getFormFields(formId) {
    const common = `
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Student Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ff_student_name" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Grade & Section <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ff_grade_section" required>
            </div>
        </div>`;

    switch(formId) {
        case 'confiscation-electronic':
            return common + `
            <div class="row g-3 mt-0">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">School</label>
                    <input type="text" class="form-control" id="ff_school" value="Bulan National High School">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Adviser/Class Teacher</label>
                    <input type="text" class="form-control" id="ff_adviser" value="${teacherName}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Reason for Confiscation</label>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_reason1" value="Unauthorized use of portable electronic device during class hours"><label class="form-check-label" for="ff_reason1">Unauthorized use of portable electronic device during class hours</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_reason2" value="Uploading/sharing photos, videos, or audio recordings of others during class hours"><label class="form-check-label" for="ff_reason2">Uploading/sharing photos, videos, or audio recordings of others during class hours</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_reason3" value="Unauthorized social media access during class hours"><label class="form-check-label" for="ff_reason3">Unauthorized social media access during class hours</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_reason4" value=""><label class="form-check-label" for="ff_reason4">Others: </label><input type="text" class="form-control form-control-sm d-inline-block ms-2" style="width:200px" id="ff_reason_other"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Offense Level</label>
                    <select class="form-select" id="ff_offense"><option value="First Offense">First Offense</option><option value="Second Offense">Second Offense</option><option value="Third Offense">Third Offense</option></select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Brand/Model</label>
                    <input type="text" class="form-control" id="ff_brand">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Serial Number (if available)</label>
                    <input type="text" class="form-control" id="ff_serial">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Description/Color</label>
                    <input type="text" class="form-control" id="ff_color">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Action Taken</label>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_action1"><label class="form-check-label" for="ff_action1">Device temporarily confiscated (First/Second Offense)</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_action2"><label class="form-check-label" for="ff_action2">Device deposited in the Office of the School Head (Third Offense)</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_action3"><label class="form-check-label" for="ff_action3">Return of device at the end class/day (First/Second Offense)</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_action4"><label class="form-check-label" for="ff_action4">Return of device only to parent/guardian (Third Offense)</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_action5"><label class="form-check-label" for="ff_action5">Parental notice issued</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_action6"><label class="form-check-label" for="ff_action6">Disciplinary action recommended (for Third Offense)</label></div>
                </div>
            </div>`;

        case 'call-slip':
            return `
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Day of Appointment</label>
                    <input type="text" class="form-control" id="ff_day" placeholder="e.g. Lunes">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Date (araw at petsa)</label>
                    <input type="date" class="form-control" id="ff_date">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Time (oras)</label>
                    <input type="time" class="form-control" id="ff_time">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Class Adviser</label>
                    <input type="text" class="form-control" id="ff_adviser" value="${teacherName}">
                </div>
            </div>`;

        case 'risk-assessment':
            return common + `
            <div class="row g-3 mt-0">
                <div class="col-12">
                    <label class="form-label fw-semibold">Context</label>
                    <textarea class="form-control" id="ff_context" rows="2" placeholder="Describe the context..."></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Risk Assessment Entries (add rows)</label>
                    <div id="riskRows">
                        <div class="row g-2 mb-2 risk-row">
                            <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Identified Risk"></div>
                            <div class="col-md-2"><input type="text" class="form-control form-control-sm" placeholder="Risk Factors"></div>
                            <div class="col-md-2"><select class="form-select form-select-sm"><option>High</option><option>Medium</option><option>Low</option></select></div>
                            <div class="col-md-2"><input type="text" class="form-control form-control-sm" placeholder="Impact"></div>
                            <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Action to be Taken"></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addRiskRow()"><i class="bi bi-plus"></i> Add Row</button>
                </div>
            </div>`;

        case 'confiscation-prohibited':
            return common + `
            <div class="row g-3 mt-0">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Teacher-in-Charge</label>
                    <input type="text" class="form-control" id="ff_teacher" value="${teacherName}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Document No.</label>
                    <input type="text" class="form-control" id="ff_docno">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Item/s Confiscated</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_item1"><label class="form-check-label" for="ff_item1">Pornographic Materials</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_item2"><label class="form-check-label" for="ff_item2">Unnecessary items that may cause harm</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_item3"><label class="form-check-label" for="ff_item3">Flammable & hazardous chemicals</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_item4"><label class="form-check-label" for="ff_item4">Deadly Weapon/s</label></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_item5"><label class="form-check-label" for="ff_item5">Cigarettes, Vape</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_item6"><label class="form-check-label" for="ff_item6">Gambling Paraphernalia</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_item7"><label class="form-check-label" for="ff_item7">Others</label></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Please specify item</label>
                    <input type="text" class="form-control" id="ff_specify">
                </div>
            </div>`;

        case 'bag-search':
            return `
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">School Year</label>
                    <input type="text" class="form-control" id="ff_school_year" placeholder="e.g. 2025-2026">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Bag Search Plan Entries</label>
                    <div id="bagRows">
                        <div class="row g-2 mb-2 bag-row">
                            <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Grade Level"></div>
                            <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Frequency"></div>
                            <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Persons Responsible"></div>
                            <div class="col-md-3"><input type="text" class="form-control form-control-sm" placeholder="Resources"></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addBagRow()"><i class="bi bi-plus"></i> Add Row</button>
                </div>
            </div>`;

        case 'good-moral':
            return common + `
            <div class="row g-3 mt-0">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">LRN</label>
                    <input type="text" class="form-control" id="ff_lrn">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Age</label>
                    <input type="text" class="form-control" id="ff_age">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">School Year</label>
                    <input type="text" class="form-control" id="ff_school_year">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Address</label>
                    <input type="text" class="form-control" id="ff_address">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact No.</label>
                    <input type="text" class="form-control" id="ff_contact">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Address (optional)</label>
                    <input type="text" class="form-control" id="ff_email">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Requestor</label>
                    <select class="form-select" id="ff_requestor"><option value="Learner">Learner</option><option value="Parent / Guardian">Parent / Guardian</option><option value="Adviser">Adviser</option></select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Purpose of Request</label>
                    <select class="form-select" id="ff_purpose"><option value="Scholarship / Financial Assistance">Scholarship / Financial Assistance</option><option value="Transfer to Another School">Transfer to Another School</option><option value="Employment">Employment</option><option value="College / University Admission">College / University Admission</option><option value="Immigration / Travel">Immigration / Travel</option><option value="Barangay / Legal Requirement">Barangay / Legal Requirement</option></select>
                </div>
            </div>`;

        case 'home-visitation':
            return common + `
            <div class="row g-3 mt-0">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">LRN</label>
                    <input type="text" class="form-control" id="ff_lrn">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Age</label>
                    <input type="text" class="form-control" id="ff_age">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">School Year</label>
                    <input type="text" class="form-control" id="ff_school_year">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Address</label>
                    <input type="text" class="form-control" id="ff_address">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Name of Parent/Guardian</label>
                    <input type="text" class="form-control" id="ff_parent">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact No.</label>
                    <input type="text" class="form-control" id="ff_contact">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Purpose/Reason for Home Visit</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_purpose1"><label class="form-check-label" for="ff_purpose1">Absences / Frequent Tardiness</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_purpose2"><label class="form-check-label" for="ff_purpose2">Declining Academic Performance</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_purpose3"><label class="form-check-label" for="ff_purpose3">Behavioral / Discipline Concern</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_purpose4"><label class="form-check-label" for="ff_purpose4">Well-being / Psychosocial Support</label></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_purpose5"><label class="form-check-label" for="ff_purpose5">Verification of Learner's Living Condition</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_purpose6"><label class="form-check-label" for="ff_purpose6">Implementation of Individual Plan</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_purpose7"><label class="form-check-label" for="ff_purpose7">Delivery of Learning Materials / Support</label></div>
                            <div class="form-check"><input class="form-check-input" type="checkbox" id="ff_purpose8"><label class="form-check-label" for="ff_purpose8">Monitoring of Intervention</label></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Observations / Notes</label>
                    <textarea class="form-control" id="ff_observations" rows="3"></textarea>
                </div>
            </div>`;

        default:
            return '<p>Form not available.</p>';
    }
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

function val(id) { const el = document.getElementById(id); return el ? el.value : ''; }
function checked(id) { const el = document.getElementById(id); return el ? el.checked : false; }
function checkbox(isChecked) { return isChecked ? '&#9746;' : '&#9744;'; }

function sendToCounselor() {
    // Collect all named form field values
    const formData = {};
    document.querySelectorAll('#formModalBody input, #formModalBody select, #formModalBody textarea').forEach(el => {
        if (!el.id && !el.name) return; // skip unnamed elements (row inputs handled below)
        if (el.type === 'checkbox') {
            formData[el.id || el.name] = el.checked ? (el.value || true) : false;
        } else {
            formData[el.id || el.name] = el.value;
        }
    });

    // Capture risk rows (risk-assessment form)
    document.querySelectorAll('.risk-row').forEach((row, rowIdx) => {
        const inputs = row.querySelectorAll('input, select');
        inputs.forEach((inp, colIdx) => {
            formData[`ff_risk_${rowIdx}_${colIdx}`] = inp.value;
        });
    });

    // Capture bag rows (bag-search form)
    document.querySelectorAll('.bag-row').forEach((row, rowIdx) => {
        const inputs = row.querySelectorAll('input');
        inputs.forEach((inp, colIdx) => {
            formData[`ff_bag_${rowIdx}_${colIdx}`] = inp.value;
        });
    });

    const studentName = document.getElementById('ff_student_name')?.value || '';
    const gradeSection = document.getElementById('ff_grade_section')?.value || '';

    const btn = document.getElementById('sendBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Sending...';

    fetch(submitFormUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            form_type:     currentFormId,
            form_title:    currentFormTitle,
            student_name:  studentName,
            grade_section: gradeSection,
            form_data:     formData,
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('formModal')).hide();
            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = 9999;
            toast.innerHTML = `<div class="toast show align-items-center text-white border-0" style="background:#20B2AA;border-radius:12px;" role="alert">
                <div class="d-flex"><div class="toast-body"><i class="bi bi-check-circle me-2"></i>${data.message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 4000);
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-send me-1"></i> Send to Counselor';
        alert('Failed to send. Please try again.');
    });
}

function buildPrintContent(formId) {
    const css = `<style>
        body{font-family:'Times New Roman',serif;font-size:12pt;margin:40px;line-height:1.6;}
        .form-title{text-align:center;font-size:18pt;font-weight:bold;margin-bottom:5px;}
        .form-subtitle{text-align:center;font-style:italic;margin-bottom:20px;font-size:11pt;}
        .field{border-bottom:1px solid #000;min-width:150px;display:inline-block;padding:0 5px;}
        .field-long{border-bottom:1px solid #000;min-width:300px;display:inline-block;padding:0 5px;}
        table{width:100%;border-collapse:collapse;margin:15px 0;}
        table th,table td{border:1px solid #000;padding:6px 8px;text-align:left;font-size:10pt;}
        table th{background:#000;color:#fff;font-weight:bold;}
        .section-header{background:#000;color:#fff;font-weight:bold;padding:4px 8px;margin:15px 0 10px;display:inline-block;font-size:10pt;}
        .signature-line{border-bottom:1px solid #000;width:250px;display:block;margin:30px auto 0;}
        .signature-label{font-weight:bold;text-align:center;font-size:10pt;width:250px;display:block;margin:4px auto 0;}
        .grid-row{display:flex;margin-bottom:8px;}
        .grid-col{flex:1;padding:0 8px;}.sig-col{text-align:center;}
        .header-bar{background:#ccc;padding:10px;text-align:center;margin-bottom:20px;border:2px solid #000;}
        .dashed-line{border-top:2px dashed #000;margin:20px 0;}
        .box{border:2px solid #000;padding:15px;margin:10px 0;}
        @media print{body{margin:20px;}}
    </style>`;

    let html = `<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Print Form</title>${css}</head><body>`;

    switch(formId) {
        case 'confiscation-electronic':
            const reasons = [];
            if(checked('ff_reason1')) reasons.push('Unauthorized use of portable electronic device during class hours');
            if(checked('ff_reason2')) reasons.push('Uploading/sharing photos, videos, or audio recordings of others during class hours');
            if(checked('ff_reason3')) reasons.push('Unauthorized social media access during class hours');
            if(val('ff_reason_other')) reasons.push('Others: ' + val('ff_reason_other'));

            const actions = [];
            if(checked('ff_action1')) actions.push('Device temporarily confiscated (First/Second Offense)');
            if(checked('ff_action2')) actions.push('Device deposited in the Office of the School Head (Third Offense)');
            if(checked('ff_action3')) actions.push('Return of device at the end class/day (First/Second Offense)');
            if(checked('ff_action4')) actions.push('Return of device only to parent/guardian (Third Offense)');
            if(checked('ff_action5')) actions.push('Parental notice issued');
            if(checked('ff_action6')) actions.push('Disciplinary action recommended (for Third Offense)');

            html += `<div class="form-title">CONFISCATION SLIP</div>
                <div class="form-subtitle">(For Violation of Responsible Use of Portable Electronic Device Policy)</div>
                <div class="grid-row"><div class="grid-col">School: <span class="field-long">${val('ff_school')}</span></div><div class="grid-col">Date: <span class="field">${today}</span></div></div>
                <div class="grid-row"><div class="grid-col">Student Name: <span class="field-long">${val('ff_student_name')}</span></div><div class="grid-col">Time: <span class="field">${new Date().toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit'})}</span></div></div>
                <div class="grid-row"><div class="grid-col">Grade/Section: <span class="field-long">${val('ff_grade_section')}</span></div></div>
                <div class="grid-row"><div class="grid-col">Adviser/Class Teacher: <span class="field-long">${val('ff_adviser')}</span></div></div>
                <br><div class="grid-row"><div class="grid-col"><strong>*Reason for Confiscation</strong><br>${reasons.map(r=>`${checkbox(true)} ${r}`).join('<br>')}</div>
                <div class="grid-col"><strong>*Offense Level</strong><br>${checkbox(true)} ${val('ff_offense')}</div></div>
                <div class="box"><div class="grid-row">
                    <div class="grid-col"><strong>*Action Taken</strong><br>${actions.map(a=>`${checkbox(true)} ${a}`).join('<br>')}</div>
                    <div class="grid-col"><strong>*Device Details</strong><br>* Brand/Model: <span class="field">${val('ff_brand')}</span><br>* Serial Number: <span class="field">${val('ff_serial')}</span><br>* Description/Color: <span class="field">${val('ff_color')}</span></div>
                </div></div>
                <br><div class="grid-row"><div class="grid-col sig-col"><div class="signature-line"></div><div class="signature-label">Teacher/Personnel Confiscating<br>Signature over Printed Name</div></div>
                <div class="grid-col"><em>I acknowledge that my portable electronic device was confiscated in accordance with school policy.</em><br><br>Student Signature: <span class="field"></span><br>Date: <span class="field">${todayShort}</span></div></div>
                <div class="dashed-line"></div>
                <div style="text-align:center"><strong>*Parent/Guardian Acknowledgment (for 3rd Offense of Retrieval)</strong><br><em>I acknowledge receipt of my child's device and understand the policy.</em></div>
                <br>Parent/Guardian Name: <span class="field-long"></span><br>Signature: <span class="field-long"></span> &nbsp;&nbsp; Date: <span class="field"></span><br><br><em>Notes/Remarks:</em><br><span class="field-long" style="width:100%;"></span>`;
            break;

        case 'call-slip':
            html += `<div class="header-bar"><div class="form-title" style="margin:0;">CALL SLIP</div></div>
                <div style="text-align:right"><strong>Petsa: <span class="field">${val('ff_date') || today}</span></strong></div>
                <p>Magandang Araw!</p>
                <p>Inaanyayahan po namin kayo sa Guidance Office ng paaralan sa darating na <span class="field">${val('ff_day')}</span> <em>araw at petsa</em> <span class="field">${val('ff_date')}</span>, sa oras na <span class="field">${val('ff_time')}</span> upang dumalo para sa isang pag-uusap na may kinalaman sa inyong anak.</p>
                <p>Inaasahan namin ang inyong kooperasyon at positibong pagtugon.</p>
                <p>Gumagalang,</p>
                <br><div style="display:inline-block;text-align:center;min-width:260px;"><div class="signature-line"></div><br><div class="signature-label">Guidance Designate</div></div>
                <br><div style="display:inline-block;text-align:center;min-width:260px;"><div class="signature-line"></div><br><div class="signature-label">Class Adviser</div></div>
                <div style="float:right;text-align:center;margin-top:-80px;"><strong>Natanggap ni:</strong><br><br><div class="signature-line"></div><br><em>Pangalan at Lagda ng Magulang</em><br><br><div class="signature-line" style="width:150px"></div><br><div class="signature-label">Petsa</div></div>`;
            break;

        case 'risk-assessment':
            let riskRowsHtml = '';
            document.querySelectorAll('.risk-row').forEach(row => {
                const inputs = row.querySelectorAll('input, select');
                if(inputs[0] && inputs[0].value) {
                    riskRowsHtml += `<tr><td>${inputs[0].value}</td><td>${inputs[1].value}</td><td>${inputs[2].value}</td><td>${inputs[3].value}</td><td>${inputs[4].value}</td><td></td><td></td></tr>`;
                }
            });

            html += `<div class="box"><div class="form-title">INITIAL RISK ASSESSMENT FORM</div>
                <p><strong>Note:</strong> This tool shall be used by the Registered Guidance Counselor/Guidance Designate of the school.</p>
                <p>Use the following questions to complete the matrix below:</p>
                <ul><li><strong>IDENTIFY</strong> - What are the activities in school and at home which present a risk to children?</li>
                <li><strong>RISK</strong> - What could go wrong?</li>
                <li><strong>PROBABILITY</strong> - What is the likelihood of something going wrong?</li>
                <li><strong>IMPACT</strong> - What would be the consequences to the child?</li>
                <li><strong>ACTION</strong> - Identify ways to reduce these risks, and resources required.</li></ul>
                <p>Name of Learner-Victim: <span class="field-long">${val('ff_student_name')}</span></p>
                <p>Context: <span class="field-long">${val('ff_context')}</span></p>
                <table><tr><th>Identified Risk to Child</th><th>Analysis of Risk Factors</th><th>Probability</th><th>Impact</th><th>Action(s) to be Taken</th><th>By Whom</th><th>By When</th></tr>${riskRowsHtml || '<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>'}</table>
                <br>Prepared by: <span class="field-long">${teacherName}</span><br><br><strong>SIGNATURE OVER PRINTED NAME OF THE<br>REGISTERED GUIDANCE COUNSELOR/GUIDANCE DESIGNATE</strong><br><div class="signature-line"></div></div>`;
            break;

        case 'confiscation-prohibited':
            const items = [];
            if(checked('ff_item1')) items.push('Pornographic Materials');
            if(checked('ff_item2')) items.push('Unnecessary items that may cause harm');
            if(checked('ff_item3')) items.push('Flammable & hazardous chemicals');
            if(checked('ff_item4')) items.push('Deadly Weapon/s');
            if(checked('ff_item5')) items.push('Cigarettes, Vape');
            if(checked('ff_item6')) items.push('Gambling Paraphernalia');
            if(checked('ff_item7')) items.push('Others');

            html += `<div style="text-align:right">DOCUMENT NO. <span class="field">${val('ff_docno')}</span></div>
                <div class="form-title">CONFISCATION SLIP</div>
                <table><tr><td style="width:50%"><strong>NAME OF LEARNER:</strong> ${val('ff_student_name')}</td><td><strong>DATE:</strong> ${today}</td></tr>
                <tr><td><strong>GRADE & SECTION:</strong> ${val('ff_grade_section')}</td><td><strong>TEACHER-IN-CHARGE:</strong> ${val('ff_teacher')}</td></tr></table>
                <p><strong>ITEM/S CONFISCATED:</strong></p>
                <div class="grid-row"><div class="grid-col">${['Pornographic Materials','Unnecessary items that may cause harm','Flammable & hazardous chemicals','Deadly Weapon/s'].map(i=>`${checkbox(items.includes(i))} <strong>${i}</strong><br>&nbsp;&nbsp;&nbsp;Pls. specify: <span class="field">${items.includes(i)&&val('ff_specify')?val('ff_specify'):''}</span>`).join('<br>')}</div>
                <div class="grid-col">${['Cigarettes, Vape','Gambling Paraphernalia','Others'].map(i=>`${checkbox(items.includes(i))} <strong>${i}</strong><br>&nbsp;&nbsp;&nbsp;Pls. specify: <span class="field"></span>`).join('<br>')}</div></div>
                <br><div class="grid-row"><div class="grid-col"><div class="signature-label" style="margin-bottom:0;font-weight:normal;">Confiscated by:</div><div class="signature-line"></div><br><div class="signature-label">TEACHER-IN-CHARGE</div></div>
                <div class="grid-col"><div class="signature-label" style="margin-bottom:0;font-weight:normal;">Noted by:</div><div class="signature-line"></div><br><div class="signature-label">GUIDANCE TEACHER/DESIGNATE</div></div></div>
                <div class="dashed-line"></div>
                <em>To be accomplished upon claiming the confiscated item.</em><div style="float:right">DOCUMENT NO. <span class="field">${val('ff_docno')}</span></div>
                <div class="form-title">CLAIM SLIP</div>
                <p>I, <span class="field"></span> parent/guardian of <span class="field">${val('ff_student_name')}</span>, acknowledge receipt of the item that was confiscated from my child within the school premises.</p>
                <p>I fully understand the reason for its confiscation and commit to providing proper guidance to my child to prevent the recurrence of bringing items that do not contribute to the learning process.</p>
                <br><div class="grid-row"><div class="grid-col sig-col"><div class="signature-line"></div><br><div class="signature-label">PARENT'S SIGNATURE OVER PRINTED NAME</div></div>
                <div class="grid-col sig-col"><div class="signature-line"></div><br><div class="signature-label">DATE OF CLAIM</div></div></div>`;
            break;

        case 'bag-search':
            let bagRowsHtml = '';
            document.querySelectorAll('.bag-row').forEach(row => {
                const inputs = row.querySelectorAll('input');
                bagRowsHtml += `<tr><td>${inputs[0]?.value||'&nbsp;'}</td><td>${inputs[1]?.value||''}</td><td>${inputs[2]?.value||''}</td><td>${inputs[3]?.value||''}</td></tr>`;
            });

            html += `<div class="box" style="text-align:center"><div class="form-title">RANDOM ROUTINE BAG SEARCH SCHOOL PLAN</div>
                <div style="font-size:14pt;font-weight:bold;">SCHOOL YEAR <span class="field">${val('ff_school_year')}</span></div></div>
                <table><tr><th>GRADE LEVEL</th><th>FREQUENCY</th><th>PERSONS RESPONSIBLE</th><th>RESOURCES</th></tr>${bagRowsHtml}</table>
                <br><div style="text-align:center">Prepared by:<br><br><strong><u>CHILD PROTECTION COMMITTEE</u></strong><br><br><br>Approved by:<br><div class="signature-line"></div><br><strong>SCHOOL HEAD</strong></div>`;
            break;

        case 'good-moral':
            html += `<div class="form-title">GOOD MORAL REQUEST FORM</div>
                <div class="form-subtitle">(To be accomplished by Learner, Parent/Guardian or Adviser)</div>
                <div style="text-align:right"><strong>DATE: <span class="field">${today}</span></strong></div>
                <div class="section-header">I. REQUESTOR INFORMATION</div>
                <p><em>I am requesting a Good Moral Certificate for:</em></p>
                <table><tr><td style="width:70%">Name of Learner: <strong>${val('ff_student_name')}</strong></td><td>LRN: <strong>${val('ff_lrn')}</strong></td></tr>
                <tr><td>Grade & Section: <strong>${val('ff_grade_section')}</strong></td><td>Age: ${val('ff_age')} &nbsp; School Year: ${val('ff_school_year')}</td></tr>
                <tr><td colspan="2">Address: ${val('ff_address')}</td></tr>
                <tr><td>Contact No.: ${val('ff_contact')}</td><td>Email: ${val('ff_email')}</td></tr></table>
                <div class="section-header">II. REQUESTOR</div>
                <p>${checkbox(true)} ${val('ff_requestor')}</p>
                <div class="section-header">III. PURPOSE OF REQUEST</div>
                <p>${checkbox(true)} ${val('ff_purpose')}</p>
                <div class="section-header">IV. DECLARATION</div>
                <p>I hereby request the issuance of a Good Moral Certificate for the above-stated purpose.</p>
                <p>I understand that this request is subject to verification of records and compliance with the school's policies.</p>
                <p>I certify that the information provided in this form is true and correct to the best of my knowledge.</p>
                <br><div class="grid-row"><div class="grid-col sig-col"><div class="signature-line"></div><br><div class="signature-label">Signature over Printed Name<br>of Requestor</div></div><div class="grid-col sig-col"><div class="signature-line"></div><br><div class="signature-label">Date Signed</div></div></div>
                <div class="dashed-line"></div>
                <div style="text-align:center"><strong>FOR OFFICIAL USE ONLY</strong></div>
                <p>Action Taken: &nbsp; &#9744; Approved &nbsp; &#9744; Disapproved &nbsp;&nbsp;&nbsp; Date Processed: <span class="field"></span></p>
                <p>Remarks: <span class="field-long" style="width:80%"></span></p>`;
            break;

        case 'home-visitation':
            const purposes = [];
            if(checked('ff_purpose1')) purposes.push('Absences / Frequent Tardiness');
            if(checked('ff_purpose2')) purposes.push('Declining Academic Performance');
            if(checked('ff_purpose3')) purposes.push('Behavioral / Discipline Concern');
            if(checked('ff_purpose4')) purposes.push('Well-being / Psychosocial Support');
            if(checked('ff_purpose5')) purposes.push('Verification of Learner\'s Living Condition');
            if(checked('ff_purpose6')) purposes.push('Implementation of Individual Plan');
            if(checked('ff_purpose7')) purposes.push('Delivery of Learning Materials / Support');
            if(checked('ff_purpose8')) purposes.push('Monitoring of Intervention');

            html += `<div class="form-title">HOME VISITATION FORM</div>
                <div style="text-align:right"><strong>DATE OF VISIT: <span class="field">${today}</span></strong></div>
                <div class="section-header">I. LEARNER INFORMATION</div>
                <table><tr><td style="width:60%">Name of Learner: <strong>${val('ff_student_name')}</strong></td><td>LRN: ${val('ff_lrn')}</td></tr>
                <tr><td>Grade & Section: <strong>${val('ff_grade_section')}</strong></td><td>Age: ${val('ff_age')} &nbsp; School Year: ${val('ff_school_year')}</td></tr>
                <tr><td colspan="2">Address: ${val('ff_address')}</td></tr>
                <tr><td>Name of Parent/Guardian: ${val('ff_parent')}</td><td>Contact No.: ${val('ff_contact')}</td></tr></table>
                <div class="section-header">II. PURPOSE / REASON FOR HOME VISIT</div>
                <div class="grid-row"><div class="grid-col">${['Absences / Frequent Tardiness','Declining Academic Performance','Behavioral / Discipline Concern','Well-being / Psychosocial Support','Monitoring of Intervention'].map(p=>`${checkbox(purposes.includes(p))} ${p}`).join('<br>')}</div>
                <div class="grid-col">${['Verification of Learner\'s Living Condition','Implementation of Individual Plan','Delivery of Learning Materials / Support'].map(p=>`${checkbox(purposes.includes(p))} ${p}`).join('<br>')}</div></div>
                <div class="section-header">IV. OBSERVATIONS / INFORMATION GATHERED</div>
                <p>${val('ff_observations') || '<span class="field-long" style="width:100%">&nbsp;</span>'}</p>
                <br><div class="grid-row">
                    <div class="grid-col sig-col"><div class="signature-line"></div><br><div class="signature-label">School Counselor</div></div>
                    <div class="grid-col sig-col"><div class="signature-line"></div><br><div class="signature-label">Conducted by: ${teacherName}</div></div>
                    <div class="grid-col sig-col"><div class="signature-line"></div><br><div class="signature-label">Parent/Guardian</div></div>
                </div>
                <br><p style="font-size:9pt;font-style:italic;">Note: All information gathered during the home visitation shall be treated with confidentiality and used solely for the welfare and development of the learner.</p>`;
            break;
    }

    html += '</body></html>';
    return html;
}
</script>
@endsection
