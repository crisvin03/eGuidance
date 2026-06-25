{{--
    Partial: form-print-builder.blade.php
    Outputs a <script> block with buildStoredPrintContent(formId, data, teacherName, submittedAt)
    that reconstructs the exact same HTML as the live Generate & Print, but from stored form_data.
    Include once in any page that needs Print from stored submissions.
--}}
<script>
function buildStoredPrintContent(formId, data, teacherName, submittedAt) {
    // helpers
    function v(key) { return (data[key] || '').toString().trim(); }
    function cb(isChecked) { return isChecked ? '&#9746;' : '&#9744;'; }
    function checked(key) { return !!data[key]; }

    const today       = submittedAt || new Date().toLocaleDateString('en-US',{month:'long',day:'numeric',year:'numeric'});
    const todayShort  = submittedAt || new Date().toLocaleDateString('en-US',{month:'2-digit',day:'2-digit',year:'numeric'});

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
        .signature-line{border-bottom:1px solid #000;width:250px;display:inline-block;margin-top:30px;}
        .signature-label{font-weight:bold;text-align:center;font-size:10pt;}
        .grid-row{display:flex;margin-bottom:8px;}
        .grid-col{flex:1;padding-right:15px;}
        .header-bar{background:#ccc;padding:10px;text-align:center;margin-bottom:20px;border:2px solid #000;}
        .dashed-line{border-top:2px dashed #000;margin:20px 0;}
        .box{border:2px solid #000;padding:15px;margin:10px 0;}
        @media print{body{margin:20px;}}
    </style>`;

    let html = `<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Print Form</title>${css}</head><body>`;

    switch(formId) {
        case 'confiscation-electronic': {
            const reasons = [];
            if(checked('ff_reason1')) reasons.push('Unauthorized use of portable electronic device during class hours');
            if(checked('ff_reason2')) reasons.push('Uploading/sharing photos, videos, or audio recordings of others during class hours');
            if(checked('ff_reason3')) reasons.push('Unauthorized social media access during class hours');
            if(v('ff_reason_other')) reasons.push('Others: ' + v('ff_reason_other'));

            const actions = [];
            if(checked('ff_action1')) actions.push('Device temporarily confiscated (First/Second Offense)');
            if(checked('ff_action2')) actions.push('Device deposited in the Office of the School Head (Third Offense)');
            if(checked('ff_action3')) actions.push('Return of device at the end class/day (First/Second Offense)');
            if(checked('ff_action4')) actions.push('Return of device only to parent/guardian (Third Offense)');
            if(checked('ff_action5')) actions.push('Parental notice issued');
            if(checked('ff_action6')) actions.push('Disciplinary action recommended (for Third Offense)');

            html += `<div class="form-title">CONFISCATION SLIP</div>
                <div class="form-subtitle">(For Violation of Responsible Use of Portable Electronic Device Policy)</div>
                <div class="grid-row"><div class="grid-col">School: <span class="field-long">${v('ff_school')}</span></div><div class="grid-col">Date: <span class="field">${today}</span></div></div>
                <div class="grid-row"><div class="grid-col">Student Name: <span class="field-long">${v('ff_student_name')}</span></div><div class="grid-col">Time: <span class="field"></span></div></div>
                <div class="grid-row"><div class="grid-col">Grade/Section: <span class="field-long">${v('ff_grade_section')}</span></div></div>
                <div class="grid-row"><div class="grid-col">Adviser/Class Teacher: <span class="field-long">${v('ff_adviser') || teacherName}</span></div></div>
                <br><div class="grid-row"><div class="grid-col"><strong>*Reason for Confiscation</strong><br>${reasons.length ? reasons.map(r=>`${cb(true)} ${r}`).join('<br>') : cb(false)+' —'}</div>
                <div class="grid-col"><strong>*Offense Level</strong><br>${cb(true)} ${v('ff_offense')}</div></div>
                <div class="box"><div class="grid-row">
                    <div class="grid-col"><strong>*Action Taken</strong><br>${actions.length ? actions.map(a=>`${cb(true)} ${a}`).join('<br>') : cb(false)+' —'}</div>
                    <div class="grid-col"><strong>*Device Details</strong><br>* Brand/Model: <span class="field">${v('ff_brand')}</span><br>* Serial Number: <span class="field">${v('ff_serial')}</span><br>* Description/Color: <span class="field">${v('ff_color')}</span></div>
                </div></div>
                <br><div class="grid-row"><div class="grid-col"><div class="signature-line"></div><br><div class="signature-label">Teacher/Personnel Confiscating<br>Signature over Printed Name</div></div>
                <div class="grid-col"><em>I acknowledge that my portable electronic device was confiscated in accordance with school policy.</em><br><br>Student Signature: <span class="field"></span><br>Date: <span class="field">${todayShort}</span></div></div>
                <div class="dashed-line"></div>
                <div style="text-align:center"><strong>*Parent/Guardian Acknowledgment (for 3rd Offense of Retrieval)</strong><br><em>I acknowledge receipt of my child's device and understand the policy.</em></div>
                <br>Parent/Guardian Name: <span class="field-long"></span><br>Signature: <span class="field-long"></span> &nbsp;&nbsp; Date: <span class="field"></span><br><br><em>Notes/Remarks:</em><br><span class="field-long" style="width:100%;"></span>`;
            break;
        }

        case 'call-slip': {
            html += `<div class="header-bar"><div class="form-title" style="margin:0;">CALL SLIP</div></div>
                <div style="text-align:right"><strong>Petsa: <span class="field">${v('ff_date') || today}</span></strong></div>
                <p>Magandang Araw!</p>
                <p>Inaanyayahan po namin kayo sa Guidance Office ng paaralan sa darating na <span class="field">${v('ff_day')}</span> <em>araw at petsa</em> <span class="field">${v('ff_date')}</span>, sa oras na <span class="field">${v('ff_time')}</span> upang dumalo para sa isang pag-uusap na may kinalaman sa inyong anak.</p>
                <p>Inaasahan namin ang inyong kooperasyon at positibong pagtugon.</p>
                <p>Gumagalang,</p>
                <br><div class="signature-line"></div><br><div class="signature-label">Guidance Designate</div>
                <br><div class="signature-line"></div><br><div class="signature-label">Class Adviser</div>
                <div style="float:right;text-align:center;margin-top:-80px;"><strong>Natanggap ni:</strong><br><br><div class="signature-line"></div><br><em>Pangalan at Lagda ng Magulang</em><br><br><div class="signature-line" style="width:150px"></div><br><div class="signature-label">Petsa</div></div>`;
            break;
        }

        case 'risk-assessment': {
            // Reconstruct risk rows from stored data
            // Keys: ff_risk_0_0, ff_risk_0_1 ... or stored as riskRows array
            let riskRowsHtml = '';
            // Try to find risk row entries — stored as individual inputs with positional keys
            const riskEntries = {};
            Object.entries(data).forEach(([k, val]) => {
                const m = k.match(/^ff_risk_(\d+)_(\d+)$/);
                if (m) {
                    const [, row, col] = m;
                    if (!riskEntries[row]) riskEntries[row] = [];
                    riskEntries[row][col] = val;
                }
            });
            if (Object.keys(riskEntries).length) {
                Object.values(riskEntries).forEach(cols => {
                    if (cols[0]) riskRowsHtml += `<tr><td>${cols[0]||'&nbsp;'}</td><td>${cols[1]||''}</td><td>${cols[2]||''}</td><td>${cols[3]||''}</td><td>${cols[4]||''}</td><td></td><td></td></tr>`;
                });
            }
            if (!riskRowsHtml) {
                riskRowsHtml = '<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>'.repeat(3);
            }

            html += `<div class="box"><div class="form-title">INITIAL RISK ASSESSMENT FORM</div>
                <p><strong>Note:</strong> This tool shall be used by the Registered Guidance Counselor/Guidance Designate of the school.</p>
                <p>Use the following questions to complete the matrix below:</p>
                <ul><li><strong>IDENTIFY</strong> - What are the activities in school and at home which present a risk to children?</li>
                <li><strong>RISK</strong> - What could go wrong?</li>
                <li><strong>PROBABILITY</strong> - What is the likelihood of something going wrong?</li>
                <li><strong>IMPACT</strong> - What would be the consequences to the child?</li>
                <li><strong>ACTION</strong> - Identify ways to reduce these risks, and resources required.</li></ul>
                <p>Name of Learner-Victim: <span class="field-long">${v('ff_student_name')}</span></p>
                <p>Context: <span class="field-long">${v('ff_context')}</span></p>
                <table><tr><th>Identified Risk to Child</th><th>Analysis of Risk Factors</th><th>Probability</th><th>Impact</th><th>Action(s) to be Taken</th><th>By Whom</th><th>By When</th></tr>${riskRowsHtml}</table>
                <br>Prepared by: <span class="field-long">${teacherName}</span><br><br><strong>SIGNATURE OVER PRINTED NAME OF THE<br>REGISTERED GUIDANCE COUNSELOR/GUIDANCE DESIGNATE</strong><br><div class="signature-line"></div></div>`;
            break;
        }

        case 'confiscation-prohibited': {
            const itemList = ['Pornographic Materials','Unnecessary items that may cause harm','Flammable & hazardous chemicals','Deadly Weapon/s','Cigarettes, Vape','Gambling Paraphernalia','Others'];
            const checkedItems = [];
            if(checked('ff_item1')) checkedItems.push('Pornographic Materials');
            if(checked('ff_item2')) checkedItems.push('Unnecessary items that may cause harm');
            if(checked('ff_item3')) checkedItems.push('Flammable & hazardous chemicals');
            if(checked('ff_item4')) checkedItems.push('Deadly Weapon/s');
            if(checked('ff_item5')) checkedItems.push('Cigarettes, Vape');
            if(checked('ff_item6')) checkedItems.push('Gambling Paraphernalia');
            if(checked('ff_item7')) checkedItems.push('Others');

            html += `<div style="text-align:right">DOCUMENT NO. <span class="field">${v('ff_docno')}</span></div>
                <div class="form-title">CONFISCATION SLIP</div>
                <table><tr><td style="width:50%"><strong>NAME OF LEARNER:</strong> ${v('ff_student_name')}</td><td><strong>DATE:</strong> ${today}</td></tr>
                <tr><td><strong>GRADE & SECTION:</strong> ${v('ff_grade_section')}</td><td><strong>TEACHER-IN-CHARGE:</strong> ${v('ff_teacher') || teacherName}</td></tr></table>
                <p><strong>ITEM/S CONFISCATED:</strong></p>
                <div class="grid-row"><div class="grid-col">${['Pornographic Materials','Unnecessary items that may cause harm','Flammable & hazardous chemicals','Deadly Weapon/s'].map(i=>`${cb(checkedItems.includes(i))} <strong>${i}</strong><br>&nbsp;&nbsp;&nbsp;Pls. specify: <span class="field">${checkedItems.includes(i)&&v('ff_specify')?v('ff_specify'):''}</span>`).join('<br>')}</div>
                <div class="grid-col">${['Cigarettes, Vape','Gambling Paraphernalia','Others'].map(i=>`${cb(checkedItems.includes(i))} <strong>${i}</strong><br>&nbsp;&nbsp;&nbsp;Pls. specify: <span class="field"></span>`).join('<br>')}</div></div>
                <br><div class="grid-row"><div class="grid-col">Confiscated by:<br><div class="signature-line"></div><br><div class="signature-label">TEACHER-IN-CHARGE</div></div>
                <div class="grid-col">Noted by:<br><div class="signature-line"></div><br><div class="signature-label">GUIDANCE TEACHER/DESIGNATE</div></div></div>
                <div class="dashed-line"></div>
                <em>To be accomplished upon claiming the confiscated item.</em><div style="float:right">DOCUMENT NO. <span class="field">${v('ff_docno')}</span></div>
                <div class="form-title">CLAIM SLIP</div>
                <p>I, <span class="field"></span> parent/guardian of <span class="field">${v('ff_student_name')}</span>, acknowledge receipt of the item that was confiscated from my child within the school premises.</p>
                <p>I fully understand the reason for its confiscation and commit to providing proper guidance to my child to prevent the recurrence of bringing items that do not contribute to the learning process.</p>
                <br><div class="grid-row"><div class="grid-col"><div class="signature-line"></div><br><div class="signature-label">PARENT'S SIGNATURE OVER PRINTED NAME</div></div>
                <div class="grid-col"><div class="signature-line"></div><br><div class="signature-label">DATE OF CLAIM</div></div></div>`;
            break;
        }

        case 'bag-search': {
            // Reconstruct bag rows
            let bagRowsHtml = '';
            const bagEntries = {};
            Object.entries(data).forEach(([k, val]) => {
                const m = k.match(/^ff_bag_(\d+)_(\d+)$/);
                if (m) {
                    const [, row, col] = m;
                    if (!bagEntries[row]) bagEntries[row] = [];
                    bagEntries[row][col] = val;
                }
            });
            if (Object.keys(bagEntries).length) {
                Object.values(bagEntries).forEach(cols => {
                    bagRowsHtml += `<tr><td>${cols[0]||'&nbsp;'}</td><td>${cols[1]||''}</td><td>${cols[2]||''}</td><td>${cols[3]||''}</td></tr>`;
                });
            }
            if (!bagRowsHtml) bagRowsHtml = '<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>'.repeat(3);

            html += `<div class="box" style="text-align:center"><div class="form-title">RANDOM ROUTINE BAG SEARCH SCHOOL PLAN</div>
                <div style="font-size:14pt;font-weight:bold;">SCHOOL YEAR <span class="field">${v('ff_school_year')}</span></div></div>
                <table><tr><th>GRADE LEVEL</th><th>FREQUENCY</th><th>PERSONS RESPONSIBLE</th><th>RESOURCES</th></tr>${bagRowsHtml}</table>
                <br><div style="text-align:center">Prepared by:<br><br><strong><u>CHILD PROTECTION COMMITTEE</u></strong><br><br><br>Approved by:<br><div class="signature-line"></div><br><strong>SCHOOL HEAD</strong></div>`;
            break;
        }

        case 'good-moral': {
            const requestor = v('ff_requestor') || 'Learner';
            const purpose   = v('ff_purpose') || '';
            html += `<div class="form-title">GOOD MORAL REQUEST FORM</div>
                <div class="form-subtitle">(To be accomplished by Learner, Parent/Guardian or Adviser)</div>
                <div style="text-align:right"><strong>DATE: <span class="field">${today}</span></strong></div>
                <div class="section-header">I. REQUESTOR INFORMATION</div>
                <p><em>I am requesting a Good Moral Certificate for:</em></p>
                <table>
                    <tr><td style="width:70%">Name of Learner: <strong>${v('ff_student_name')}</strong></td><td>LRN: <strong>${v('ff_lrn')}</strong></td></tr>
                    <tr><td>Grade & Section: <strong>${v('ff_grade_section')}</strong></td><td>Age: ${v('ff_age')} &nbsp; School Year: ${v('ff_school_year')}</td></tr>
                    <tr><td colspan="2">Address: ${v('ff_address')}</td></tr>
                    <tr><td>Contact No.: ${v('ff_contact')}</td><td>Email: ${v('ff_email')}</td></tr>
                </table>
                <div class="section-header">II. REQUESTOR</div>
                <p>${cb(true)} ${requestor}</p>
                <div class="section-header">III. PURPOSE OF REQUEST</div>
                <p>${cb(true)} ${purpose}</p>
                <div class="section-header">IV. DECLARATION</div>
                <p>I hereby request the issuance of a Good Moral Certificate for the above-stated purpose.</p>
                <p>I understand that this request is subject to verification of records and compliance with the school's policies.</p>
                <p>I certify that the information provided in this form is true and correct to the best of my knowledge.</p>
                <br><div class="grid-row"><div class="grid-col"><div class="signature-line"></div><br><div class="signature-label">Signature over Printed Name<br>of Requestor</div></div><div class="grid-col"><div class="signature-line"></div><br><div class="signature-label">Date Signed</div></div></div>
                <div class="dashed-line"></div>
                <div style="text-align:center"><strong>FOR OFFICIAL USE ONLY</strong></div>
                <p>Action Taken: &nbsp; &#9744; Approved &nbsp; &#9744; Disapproved &nbsp;&nbsp;&nbsp; Date Processed: <span class="field"></span></p>
                <p>Remarks: <span class="field-long" style="width:80%"></span></p>`;
            break;
        }

        case 'home-visitation': {
            const pvMap = {
                ff_purpose1: "Absences / Frequent Tardiness",
                ff_purpose2: "Declining Academic Performance",
                ff_purpose3: "Behavioral / Discipline Concern",
                ff_purpose4: "Well-being / Psychosocial Support",
                ff_purpose5: "Verification of Learner's Living Condition",
                ff_purpose6: "Implementation of Individual Plan",
                ff_purpose7: "Delivery of Learning Materials / Support",
                ff_purpose8: "Monitoring of Intervention",
            };
            const leftPurposes  = ['ff_purpose1','ff_purpose2','ff_purpose3','ff_purpose4','ff_purpose8'];
            const rightPurposes = ['ff_purpose5','ff_purpose6','ff_purpose7'];

            html += `<div class="form-title">HOME VISITATION FORM</div>
                <div style="text-align:right"><strong>DATE OF VISIT: <span class="field">${today}</span></strong></div>
                <div class="section-header">I. LEARNER INFORMATION</div>
                <table>
                    <tr><td style="width:60%">Name of Learner: <strong>${v('ff_student_name')}</strong></td><td>LRN: ${v('ff_lrn')}</td></tr>
                    <tr><td>Grade & Section: <strong>${v('ff_grade_section')}</strong></td><td>Age: ${v('ff_age')} &nbsp; School Year: ${v('ff_school_year')}</td></tr>
                    <tr><td colspan="2">Address: ${v('ff_address')}</td></tr>
                    <tr><td>Name of Parent/Guardian: ${v('ff_parent')}</td><td>Contact No.: ${v('ff_contact')}</td></tr>
                </table>
                <div class="section-header">II. PURPOSE / REASON FOR HOME VISIT</div>
                <div class="grid-row">
                    <div class="grid-col">${leftPurposes.map(k=>`${cb(checked(k))} ${pvMap[k]}`).join('<br>')}</div>
                    <div class="grid-col">${rightPurposes.map(k=>`${cb(checked(k))} ${pvMap[k]}`).join('<br>')}</div>
                </div>
                <div class="section-header">IV. OBSERVATIONS / INFORMATION GATHERED</div>
                <p>${v('ff_observations') || '<span class="field-long" style="width:100%">&nbsp;</span>'}</p>
                <br><div class="grid-row">
                    <div class="grid-col" style="text-align:center"><div class="signature-line"></div><br><div class="signature-label">School Counselor</div></div>
                    <div class="grid-col" style="text-align:center"><div class="signature-line"></div><br><div class="signature-label">Conducted by: ${teacherName}</div></div>
                    <div class="grid-col" style="text-align:center"><div class="signature-line"></div><br><div class="signature-label">Parent/Guardian</div></div>
                </div>
                <br><p style="font-size:9pt;font-style:italic;">Note: All information gathered during the home visitation shall be treated with confidentiality and used solely for the welfare and development of the learner.</p>`;
            break;
        }

        default:
            html += `<p>Form type not recognized.</p>`;
    }

    html += '</body></html>';
    return html;
}
</script>
