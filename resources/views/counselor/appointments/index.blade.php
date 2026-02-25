@extends('layouts.dashboard')

@section('title', 'My Appointments')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">My Appointments</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Date & Time</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr id="appt-row-{{ $appointment->id }}">
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($appointment->student->name, 0, 2)) }}
                                        </div>
                                        <span>{{ $appointment->student->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-calendar3 text-primary"></i>
                                        <span>{{ $appointment->appointment_date->format('M d, Y h:i A') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span id="appt-status-{{ $appointment->id }}">
                                        @if($appointment->status == 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($appointment->status == 'cancelled')
                                            <span class="badge badge-danger">Cancelled</span>
                                        @elseif($appointment->status == 'confirmed')
                                            <span class="badge badge-info">Confirmed</span>
                                        @else
                                            <span class="badge badge-warning">Scheduled</span>
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if($appointment->concern_id)
                                        <span class="badge bg-purple" style="background-color:#6f42c1">
                                            <i class="bi bi-chat-left-heart me-1"></i>From Concern
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-calendar-plus me-1"></i>Direct Booking
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" id="appt-actions-{{ $appointment->id }}">
                                        <button class="btn btn-primary btn-sm" onclick="viewAppointment({{ $appointment->id }})">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                        @if(in_array($appointment->status, ['scheduled', 'confirmed']))
                                            @if($appointment->status == 'scheduled')
                                                <button class="btn btn-success btn-sm" onclick="openConfirm({{ $appointment->id }})">
                                                    <i class="bi bi-check-circle"></i> Confirm
                                                </button>
                                            @endif
                                            <button class="btn btn-warning btn-sm" onclick="openComplete({{ $appointment->id }})">
                                                <i class="bi bi-check2-all"></i> Complete
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="openCancel({{ $appointment->id }})">
                                                <i class="bi bi-x-circle"></i> Cancel
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h4 class="mt-3 text-muted">No Appointments</h4>
                <p class="text-muted">No appointments have been scheduled yet.</p>
            </div>
        @endif
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-calendar-check me-2"></i>Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewModalBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-check-circle me-2 text-success"></i>Confirm Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success">
                    <i class="bi bi-info-circle me-2"></i>
                    Are you sure you want to confirm this appointment? The student will be notified.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmBtn" onclick="submitStatus('confirmed')">
                    <i class="bi bi-check-circle me-1"></i> Yes, Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Complete Modal -->
<div class="modal fade" id="completeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-check2-all me-2 text-warning"></i>Mark as Completed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Mark this appointment as completed and optionally add session notes.</p>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Session Notes <span class="text-muted">(Optional)</span></label>
                    <textarea class="form-control" id="sessionNotes" rows="4"
                        placeholder="Summarize what was discussed in the session..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="completeBtn" onclick="submitStatus('completed')">
                    <i class="bi bi-check2-all me-1"></i> Mark Completed
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-x-circle me-2 text-danger"></i>Cancel Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Are you sure you want to cancel this appointment?
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Cancellation Reason <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="cancelReason" rows="3"
                        placeholder="Please provide a reason for cancellation..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Appointment</button>
                <button type="button" class="btn btn-danger" id="cancelBtn" onclick="submitStatus('cancelled')">
                    <i class="bi bi-x-circle me-1"></i> Yes, Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentAppointmentId = null;

// ─── VIEW ─────────────────────────────────────────────────────────────────────
function viewAppointment(id) {
    currentAppointmentId = id;
    document.getElementById('viewModalBody').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">Loading...</p>
        </div>`;
    new bootstrap.Modal(document.getElementById('viewModal')).show();

    fetch(`/counselor/appointments/${id}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => {
        if (!r.ok) throw new Error(`Server error: ${r.status}`);
        return r.json();
    })
    .then(data => {
        if (!data.success) throw new Error(data.message || 'Failed to load');
        const a = data.appointment;

        let statusBadge = '';
        if (a.status === 'completed')  statusBadge = '<span class="badge bg-success">Completed</span>';
        else if (a.status === 'cancelled') statusBadge = '<span class="badge bg-danger">Cancelled</span>';
        else if (a.status === 'confirmed') statusBadge = '<span class="badge bg-info">Confirmed</span>';
        else statusBadge = '<span class="badge bg-warning text-dark">Scheduled</span>';

        const apptDate = new Date(a.appointment_date).toLocaleDateString('en-US', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });

        const sourceBadge = a.concern_id
            ? `<span class="badge" style="background-color:#6f42c1"><i class="bi bi-chat-left-heart me-1"></i>From Concern</span>`
            : `<span class="badge bg-secondary"><i class="bi bi-calendar-plus me-1"></i>Direct Booking</span>`;

        let html = `
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Student</small>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar">${a.student.name.substring(0,2).toUpperCase()}</div>
                            <strong>${a.student.name}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Status</small>
                        ${statusBadge}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Source</small>
                        ${sourceBadge}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1"><i class="bi bi-calendar3 me-1"></i>Date & Time</small>
                        <strong>${apptDate}</strong>
                    </div>
                </div>
                ${a.concern ? `
                <div class="col-12">
                    <div class="p-3 border border-2 rounded" style="border-color:#6f42c1!important;background:#f8f5ff;">
                        <small class="fw-bold d-block mb-2" style="color:#6f42c1"><i class="bi bi-chat-left-heart me-1"></i>Linked Concern</small>
                        <div class="mb-1"><strong>${a.concern.title}</strong></div>
                        ${a.concern.category ? `<span class="badge bg-info mb-2">${a.concern.category.name}</span>` : ''}
                        <p class="mb-0 text-muted small">${a.concern.description.length > 200 ? a.concern.description.substring(0,200) + '...' : a.concern.description}</p>
                    </div>
                </div>` : ''}
                ${a.notes ? `
                <div class="col-12">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1"><i class="bi bi-chat-left-text me-1"></i>Notes</small>
                        <p class="mb-0">${a.notes.replace(/\n/g, '<br>')}</p>
                    </div>
                </div>` : ''}
                ${a.cancellation_reason ? `
                <div class="col-12">
                    <div class="alert alert-danger mb-0">
                        <small class="fw-bold"><i class="bi bi-x-circle me-1"></i>Cancellation Reason:</small><br>
                        ${a.cancellation_reason}
                    </div>
                </div>` : ''}
            </div>`;

        document.getElementById('viewModalBody').innerHTML = html;
    })
    .catch(err => {
        document.getElementById('viewModalBody').innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>${err.message || 'Failed to load details. Please try again.'}
            </div>`;
    });
}

// ─── CONFIRM ──────────────────────────────────────────────────────────────────
function openConfirm(id) {
    currentAppointmentId = id;
    new bootstrap.Modal(document.getElementById('confirmModal')).show();
}

// ─── COMPLETE ─────────────────────────────────────────────────────────────────
function openComplete(id) {
    currentAppointmentId = id;
    document.getElementById('sessionNotes').value = '';
    new bootstrap.Modal(document.getElementById('completeModal')).show();
}

// ─── CANCEL ───────────────────────────────────────────────────────────────────
function openCancel(id) {
    currentAppointmentId = id;
    document.getElementById('cancelReason').value = '';
    new bootstrap.Modal(document.getElementById('cancelModal')).show();
}

// ─── SUBMIT ───────────────────────────────────────────────────────────────────
function submitStatus(status) {
    const btnMap = { confirmed: 'confirmBtn', completed: 'completeBtn', cancelled: 'cancelBtn' };
    const modalMap = { confirmed: 'confirmModal', completed: 'completeModal', cancelled: 'cancelModal' };
    const btn = document.getElementById(btnMap[status]);

    // Validate cancel reason
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
    .then(r => {
        const contentType = r.headers.get('content-type') || '';
        if (!contentType.includes('application/json')) {
            throw new Error(`Unexpected server response (${r.status}). Please refresh and try again.`);
        }
        return r.json().then(data => ({ ok: r.ok, data }));
    })
    .then(({ ok, data }) => {
        if (ok) {
            bootstrap.Modal.getInstance(document.getElementById(modalMap[status])).hide();

            // Update status badge
            const badgeMap = {
                confirmed: '<span class="badge badge-info">Confirmed</span>',
                completed: '<span class="badge badge-success">Completed</span>',
                cancelled: '<span class="badge badge-danger">Cancelled</span>'
            };
            document.getElementById(`appt-status-${currentAppointmentId}`).innerHTML = badgeMap[status];

            // Remove action buttons for terminal states
            if (status === 'completed' || status === 'cancelled') {
                const actions = document.getElementById(`appt-actions-${currentAppointmentId}`);
                actions.innerHTML = `<button class="btn btn-primary btn-sm" onclick="viewAppointment(${currentAppointmentId})">
                    <i class="bi bi-eye"></i> View
                </button>`;
            } else if (status === 'confirmed') {
                // Remove confirm button, keep complete and cancel
                const actions = document.getElementById(`appt-actions-${currentAppointmentId}`);
                actions.innerHTML = `
                    <button class="btn btn-primary btn-sm" onclick="viewAppointment(${currentAppointmentId})">
                        <i class="bi bi-eye"></i> View
                    </button>
                    <button class="btn btn-warning btn-sm" onclick="openComplete(${currentAppointmentId})">
                        <i class="bi bi-check2-all"></i> Complete
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="openCancel(${currentAppointmentId})">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>`;
            }

            showToast(data.message || 'Appointment updated successfully!', status === 'cancelled' ? 'danger' : 'success');
        } else {
            let msg = data.message || 'Failed to update appointment.';
            if (data.errors) msg = Object.values(data.errors).flat().join(' ');
            alert('Error: ' + msg);
        }
    })
    .catch(err => alert('An error occurred: ' + err.message))
    .finally(() => {
        btn.disabled = false;
        const labels = { confirmed: '<i class="bi bi-check-circle me-1"></i> Yes, Confirm', completed: '<i class="bi bi-check2-all me-1"></i> Mark Completed', cancelled: '<i class="bi bi-x-circle me-1"></i> Yes, Cancel' };
        btn.innerHTML = labels[status];
    });
}

// ─── TOAST ────────────────────────────────────────────────────────────────────
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed bottom-0 end-0 m-3 shadow`;
    toast.style.cssText = 'z-index:9999;min-width:280px;';
    toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'x-circle'} me-2"></i>${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
}
</script>
@endsection
