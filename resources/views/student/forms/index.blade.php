@extends('layouts.dashboard')
@section('title', 'Request Forms')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Request Forms</h5>
    <small class="text-muted">Fill in the details and submit your request. Student information is auto-filled from your profile.</small>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;min-width:45px;background:rgba(32,178,170,0.1);">
                        <i class="bi bi-award fs-5" style="color:#20B2AA;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Good Moral Certificate Request</h6>
                        <p class="text-muted small mb-0">Request for good moral character certification for various purposes.</p>
                    </div>
                </div>
                <div class="mt-auto pt-3 border-top">
                    <button class="btn btn-sm text-white w-100 fw-semibold" style="background:linear-gradient(135deg,#20B2AA,#008B8B);"
                            onclick="openGoodMoralForm()">
                        <i class="bi bi-file-earmark-plus me-1"></i> Request Form
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Good Moral Request Modal -->
<div class="modal fade" id="goodMoralModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Good Moral Certificate Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>Your personal information has been pre-filled. Please verify and complete any missing information.
                </div>
                <form id="goodMoralForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fm_name" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Grade & Section <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fm_grade_section" value="{{ Auth::user()->grade_level && Auth::user()->section ? Auth::user()->grade_level . ' - ' . Auth::user()->section : '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">LRN</label>
                            <input type="text" class="form-control" id="fm_lrn" value="{{ Auth::user()->lrn ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Age</label>
                            <input type="text" class="form-control" id="fm_age" value="{{ Auth::user()->date_of_birth ? \Carbon\Carbon::parse(Auth::user()->date_of_birth)->age : '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">School Year <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fm_school_year" value="{{ date('Y') . '-' . (date('Y') + 1) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" class="form-control" id="fm_address" value="{{ Auth::user()->address ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Contact No.</label>
                            <input type="text" class="form-control" id="fm_contact" value="{{ Auth::user()->contact_number ?? Auth::user()->phone ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control" id="fm_email" value="{{ Auth::user()->email }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Requestor <span class="text-danger">*</span></label>
                            <select class="form-select" id="fm_requestor" required>
                                <option value="Learner" selected>Learner (Myself)</option>
                                <option value="Parent / Guardian">Parent / Guardian</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Purpose of Request <span class="text-danger">*</span></label>
                            <select class="form-select" id="fm_purpose" required>
                                <option value="">Select purpose...</option>
                                <option value="Scholarship / Financial Assistance">Scholarship / Financial Assistance</option>
                                <option value="Transfer to Another School">Transfer to Another School</option>
                                <option value="Employment">Employment</option>
                                <option value="College / University Admission">College / University Admission</option>
                                <option value="Immigration / Travel">Immigration / Travel</option>
                                <option value="Barangay / Legal Requirement">Barangay / Legal Requirement</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-12" id="otherPurposeField" style="display:none;">
                            <label class="form-label fw-semibold">Please specify purpose</label>
                            <input type="text" class="form-control" id="fm_purpose_other">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn text-white" style="background:#20B2AA;" onclick="generateGoodMoral()">
                    <i class="bi bi-printer me-1"></i> Generate & Print
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openGoodMoralForm() {
    new bootstrap.Modal(document.getElementById('goodMoralModal')).show();
}

document.getElementById('fm_purpose')?.addEventListener('change', function() {
    document.getElementById('otherPurposeField').style.display = this.value === 'Other' ? 'block' : 'none';
});

function val(id) { const el = document.getElementById(id); return el ? el.value : ''; }

function generateGoodMoral() {
    const form = document.getElementById('goodMoralForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const purpose = val('fm_purpose') === 'Other' ? val('fm_purpose_other') : val('fm_purpose');
    const requestor = val('fm_requestor');
    const today = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    
    const css = `<style>
        body{font-family:'Arial',sans-serif;font-size:11pt;margin:30px;line-height:1.4;}
        .form-title{text-align:center;font-size:16pt;font-weight:bold;margin-bottom:3px;letter-spacing:2px;}
        .form-subtitle{text-align:center;font-size:9pt;margin-bottom:15px;font-style:italic;}
        .section-header{background:#000;color:#fff;font-weight:bold;padding:6px 10px;margin:15px 0 10px;font-size:10pt;}
        table{width:100%;border-collapse:collapse;margin:10px 0;}
        table td{border:1px solid #000;padding:8px;font-size:10pt;}
        .no-border{border:none!important;}
        .checkbox{display:inline-block;width:14px;height:14px;border:1px solid #000;margin-right:5px;vertical-align:middle;}
        .checked{background:#000;}
        .signature-section{margin-top:40px;}
        .signature-line{border-bottom:2px solid #000;min-width:200px;display:inline-block;margin-bottom:5px;}
        .dashed{border-top:2px dashed #000;margin:25px 0;padding-top:20px;}
        .text-right{text-align:right;}
        .bold{font-weight:bold;}
        .small{font-size:9pt;}
        @media print{body{margin:15px;}}
    </style>`;

    const html = `<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Good Moral Request Form</title>${css}</head><body>
        <div class="form-title">GOOD MORAL REQUEST FORM</div>
        <div class="form-subtitle">(To be accomplished by Learner, Parent/Guardian or Adviser)</div>
        <div class="text-right bold">DATE: ${today}</div>
        
        <div class="section-header">I. REQUESTOR INFORMATION</div>
        <p class="small"><em>I am requesting a Good Moral Certificate for:</em></p>
        <table>
            <tr><td style="width:70%">Name of Learner: <span class="bold">${val('fm_name')}</span></td><td>LRN: <span class="bold">${val('fm_lrn')}</span></td></tr>
            <tr><td>Grade & Section: <span class="bold">${val('fm_grade_section')}</span></td><td>Age: <span class="bold">${val('fm_age')}</span> &nbsp;&nbsp; School Year: <span class="bold">${val('fm_school_year')}</span></td></tr>
            <tr><td colspan="2">Address: <span class="bold">${val('fm_address')}</span></td></tr>
            <tr><td>Contact No.: <span class="bold">${val('fm_contact')}</span></td><td>Email Address (optional): <span class="bold">${val('fm_email')}</span></td></tr>
        </table>

        <div class="section-header">II. REQUESTOR (Please check one)</div>
        <table>
            <tr>
                <td class="no-border" style="border-right:1px solid #000!important;width:50%;">
                    <span class="checkbox ${requestor==='Learner'?'checked':''}"></span> Learner &nbsp;&nbsp;
                    <span class="checkbox ${requestor==='Parent / Guardian'?'checked':''}"></span> Parent / Guardian &nbsp;&nbsp;
                    <span class="checkbox ${requestor==='Adviser'?'checked':''}"></span> Adviser
                    <br><br>If others, please specify: _______________________
                </td>
                <td class="no-border">
                    <strong>Name of Requestor:</strong><br>
                    <div style="border-bottom:1px solid #000;min-height:20px;margin:5px 0;"></div>
                    <strong>Relationship to Learner:</strong><br>
                    <div style="border-bottom:1px solid #000;min-height:20px;margin:5px 0;"></div>
                    <strong>Contact No.:</strong><br>
                    <div style="border-bottom:1px solid #000;min-height:20px;margin:5px 0;"></div>
                </td>
            </tr>
        </table>

        <div class="section-header">III. PURPOSE OF REQUEST (Please check one)</div>
        <table>
            <tr>
                <td style="width:50%;">
                    <span class="checkbox ${purpose==='Scholarship / Financial Assistance'?'checked':''}"></span> Scholarship / Financial Assistance<br>
                    <span class="checkbox ${purpose==='Transfer to Another School'?'checked':''}"></span> Transfer to Another School<br>
                    <span class="checkbox ${purpose==='Employment'?'checked':''}"></span> Employment
                </td>
                <td>
                    <span class="checkbox ${purpose==='College / University Admission'?'checked':''}"></span> College / University Admission<br>
                    <span class="checkbox ${purpose==='Immigration / Travel'?'checked':''}"></span> Immigration / Travel<br>
                    <span class="checkbox ${purpose==='Barangay / Legal Requirement'?'checked':''}"></span> Barangay / Legal Requirement
                </td>
            </tr>
            <tr><td colspan="2"><span class="checkbox ${!['Scholarship / Financial Assistance','Transfer to Another School','Employment','College / University Admission','Immigration / Travel','Barangay / Legal Requirement'].includes(purpose)?'checked':''}"></span> Others (Please specify): ${!['Scholarship / Financial Assistance','Transfer to Another School','Employment','College / University Admission','Immigration / Travel','Barangay / Legal Requirement'].includes(purpose)?purpose:'_______________________'}</td></tr>
        </table>

        <div class="section-header">IV. DECLARATION</div>
        <p class="small">I hereby request the issuance of a Good Moral Certificate for the above-stated purpose.</p>
        <p class="small">I understand that this request is subject to verification of records and compliance with the school's policies.</p>
        <p class="small">I certify that the information provided in this form is true and correct to the best of my knowledge.</p>

        <div class="signature-section">
            <table>
                <tr>
                    <td style="text-align:center;vertical-align:bottom;width:50%;">
                        <div class="signature-line" style="min-width:220px;"></div><br>
                        <span class="bold small">Signature over Printed Name<br>of Requestor</span>
                    </td>
                    <td style="text-align:center;vertical-align:bottom;">
                        <div class="signature-line" style="min-width:220px;"></div><br>
                        <span class="bold small">Signature over Printed Name<br>of Learner (if applicable)</span>
                    </td>
                    <td style="text-align:center;vertical-align:bottom;">
                        <div class="signature-line" style="min-width:150px;"></div><br>
                        <span class="bold small">Date Signed</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="dashed">
            <div class="section-header">FOR OFFICIAL USE ONLY</div>
            <table>
                <tr><td style="width:30%;">Action Taken:</td><td><span class="checkbox"></span> Approved &nbsp;&nbsp;&nbsp; <span class="checkbox"></span> Disapproved</td><td style="width:30%;">Date Processed: _______________</td></tr>
                <tr><td>Remarks:</td><td colspan="2" style="min-height:60px;"></td></tr>
            </table>
            <br>
            <table style="border:none;">
                <tr>
                    <td style="text-align:center;border:none;width:45%;">
                        <div class="signature-line" style="min-width:250px;"></div><br>
                        <span class="bold small">Processed by:<br>(Signature over Printed Name)</span>
                    </td>
                    <td style="border:none;width:10%;"></td>
                    <td style="text-align:center;border:none;width:45%;">
                        <div class="signature-line" style="min-width:250px;"></div><br>
                        <span class="bold small">Noted by:<br>(Signature over Printed Name)<br>SCHOOL HEAD</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;border:none;">
                        <strong>Position:</strong> _______________________
                    </td>
                    <td style="border:none;"></td>
                    <td style="text-align:center;border:none;">
                        <strong>Date:</strong> _______________________<br><br>
                        <div style="border:2px solid #000;width:100px;height:100px;float:right;margin-right:20px;"><br><br>(Official School Seal)</div>
                    </td>
                </tr>
            </table>
        </div>
    </body></html>`;

    const printWindow = window.open('', '_blank', 'width=900,height=700');
    printWindow.document.write(html);
    printWindow.document.close();
    setTimeout(() => printWindow.print(), 500);
    bootstrap.Modal.getInstance(document.getElementById('goodMoralModal')).hide();
}
</script>
@endsection
