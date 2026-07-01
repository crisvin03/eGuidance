{{-- Confirm Modal --}}
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content border-0" style="border-radius:16px;box-shadow:0 20px 50px rgba(0,0,0,.15);">
            <div style="height:4px;border-radius:16px 16px 0 0;background:linear-gradient(90deg,#10b981,#059669);"></div>
            <div class="modal-body p-4 text-center">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                     style="width:56px;height:56px;background:rgba(16,185,129,.1);">
                    <i class="bi bi-check-circle-fill" style="font-size:1.5rem;color:#10b981;"></i>
                </div>
                <h5 class="fw-bold mb-1">Confirm Appointment?</h5>
                <p class="text-muted small mb-0">The requester will be notified that their appointment has been confirmed.</p>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                <button type="button" class="btn btn-secondary flex-fill" style="border-radius:10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success flex-fill fw-semibold" style="border-radius:10px;" id="confirmBtn" onclick="submitStatus('confirmed')">
                    <i class="bi bi-check-circle me-1"></i> Yes, Confirm
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Complete Modal --}}
<div class="modal fade" id="completeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content border-0" style="border-radius:16px;box-shadow:0 20px 50px rgba(0,0,0,.15);">
            <div style="height:4px;border-radius:16px 16px 0 0;background:linear-gradient(90deg,#f59e0b,#d97706);"></div>
            <div class="modal-header border-0 px-4 pt-4 pb-2">
                <h5 class="fw-bold mb-0"><i class="bi bi-check2-all me-2" style="color:#d97706;"></i>Mark as Completed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-0">
                <p class="text-muted small mb-3">Optionally add session notes before marking complete.</p>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Session Notes <span class="text-muted">(Optional)</span></label>
                    <textarea class="form-control" id="sessionNotes" rows="4"
                              placeholder="Summarize what was discussed..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 gap-2">
                <button type="button" class="btn btn-secondary flex-fill" style="border-radius:10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning flex-fill fw-semibold" style="border-radius:10px;" id="completeBtn" onclick="submitStatus('completed')">
                    <i class="bi bi-check2-all me-1"></i> Mark Completed
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Cancel Modal --}}
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content border-0" style="border-radius:16px;box-shadow:0 20px 50px rgba(0,0,0,.15);">
            <div style="height:4px;border-radius:16px 16px 0 0;background:linear-gradient(90deg,#ef4444,#dc2626);"></div>
            <div class="modal-header border-0 px-4 pt-4 pb-2">
                <h5 class="fw-bold mb-0"><i class="bi bi-x-circle me-2 text-danger"></i>Cancel Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-0">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Cancellation Reason <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="cancelReason" rows="3"
                              placeholder="Please provide a reason..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 gap-2">
                <button type="button" class="btn btn-secondary flex-fill" style="border-radius:10px;" data-bs-dismiss="modal">Keep Appointment</button>
                <button type="button" class="btn btn-danger flex-fill fw-semibold" style="border-radius:10px;" id="cancelBtn" onclick="submitStatus('cancelled')">
                    <i class="bi bi-x-circle me-1"></i> Yes, Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentAppointmentId = null;

function openConfirm(id)  { currentAppointmentId = id; new bootstrap.Modal(document.getElementById('confirmModal')).show(); }
function openComplete(id) { currentAppointmentId = id; document.getElementById('sessionNotes').value = ''; new bootstrap.Modal(document.getElementById('completeModal')).show(); }
function openCancel(id)   { currentAppointmentId = id; document.getElementById('cancelReason').value = ''; new bootstrap.Modal(document.getElementById('cancelModal')).show(); }

function submitStatus(status) {
    const btnMap   = { confirmed:'confirmBtn', completed:'completeBtn', cancelled:'cancelBtn' };
    const modalMap = { confirmed:'confirmModal', completed:'completeModal', cancelled:'cancelModal' };
    const btn = document.getElementById(btnMap[status]);

    if (status === 'cancelled') {
        const reason = document.getElementById('cancelReason').value.trim();
        if (!reason) { alert('Please provide a cancellation reason.'); return; }
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Processing...';

    const payload = { status };
    if (status === 'cancelled') payload.cancellation_reason = document.getElementById('cancelReason').value.trim();
    if (status === 'completed') payload.notes = document.getElementById('sessionNotes').value.trim();

    fetch(`/counselor/appointments/${currentAppointmentId}/respond`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    })
    .then(r => r.json().then(data => ({ ok: r.ok, data })))
    .then(({ ok, data }) => {
        if (ok) {
            bootstrap.Modal.getInstance(document.getElementById(modalMap[status])).hide();

            // Update status badge
            const colors = {
                confirmed: { bg:'#eff6ff', color:'#1e40af', border:'#93c5fd', label:'Confirmed' },
                completed: { bg:'#ecfdf5', color:'#065f46', border:'#6ee7b7', label:'Completed' },
                cancelled: { bg:'#fef2f2', color:'#991b1b', border:'#fca5a5', label:'Cancelled' },
            };
            const c = colors[status];
            document.getElementById(`appt-status-${currentAppointmentId}`).innerHTML =
                `<span class="badge fw-semibold" style="background:${c.bg};color:${c.color};border:1px solid ${c.border};">${c.label}</span>`;

            // Update action buttons
            const actions = document.getElementById(`appt-actions-${currentAppointmentId}`);
            if (status === 'completed' || status === 'cancelled') {
                actions.innerHTML = `<a href="/counselor/appointments/${currentAppointmentId}" class="btn btn-primary btn-sm"><i class="bi bi-eye me-1"></i> View</a>`;
            } else if (status === 'confirmed') {
                actions.innerHTML = `
                    <a href="/counselor/appointments/${currentAppointmentId}" class="btn btn-primary btn-sm"><i class="bi bi-eye me-1"></i> View</a>
                    <button class="btn btn-sm btn-warning fw-semibold" onclick="openComplete(${currentAppointmentId})"><i class="bi bi-check2-all me-1"></i>Complete</button>`;
            }

            // Toast via global system
            showToast(status === 'cancelled' ? 'error' : 'success', data.message || 'Appointment updated.');
        } else {
            showToast('error', data.message || 'Failed to update appointment.');
        }
    })
    .catch(err => showToast('error', 'An error occurred: ' + err.message))
    .finally(() => {
        btn.disabled = false;
        const labels = {
            confirmed: '<i class="bi bi-check-circle me-1"></i> Yes, Confirm',
            completed: '<i class="bi bi-check2-all me-1"></i> Mark Completed',
            cancelled: '<i class="bi bi-x-circle me-1"></i> Yes, Cancel'
        };
        btn.innerHTML = labels[status];
    });
}
</script>
