@extends('layouts.dashboard')

@section('title', 'My Appointments')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">My Appointments</h5>
        <a href="{{ route('student.appointments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Schedule Appointment
        </a>
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
                            <th>Counselor</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentsTable">
                        @foreach($appointments as $appointment)
                            <tr id="appointment-row-{{ $appointment->id }}">
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($appointment->counselor->name, 0, 2)) }}
                                        </div>
                                        <span>{{ $appointment->counselor->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-calendar3 text-primary"></i>
                                        <span class="appt-date-{{ $appointment->id }}">{{ $appointment->appointment_date->format('M d, Y h:i A') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="appt-status-{{ $appointment->id }}">
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
                                    <small class="text-muted">{{ $appointment->notes ? Str::limit($appointment->notes, 60) : '-' }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-primary btn-sm" onclick="showDetails({{ $appointment->id }})">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                        @if(in_array($appointment->status, ['scheduled', 'confirmed']) && !$appointment->concern_id)
                                            <button class="btn btn-warning btn-sm" onclick="openReschedule({{ $appointment->id }}, '{{ $appointment->appointment_date->format('Y-m-d\TH:i') }}')">
                                                <i class="bi bi-calendar2"></i> Reschedule
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
                <h4 class="mt-3 text-muted">No Appointments Scheduled</h4>
                <p class="text-muted">You don't have any appointments scheduled yet.</p>
                <a href="{{ route('student.appointments.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Schedule Your First Appointment
                </a>
            </div>
        @endif
    </div>
</div>

<!-- View Appointment Modal -->
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
                    <p class="mt-2 text-muted">Loading...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Reschedule Modal -->
<div class="modal fade" id="rescheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-calendar2-check me-2"></i>Reschedule Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Select a new date and time for your appointment.</p>
                <div class="mb-3">
                    <label class="form-label fw-semibold">New Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" id="rescheduleDate"
                        min="{{ now()->addHour()->format('Y-m-d\TH:i') }}">
                    <div class="form-text">Must be at least 1 hour from now.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="confirmRescheduleBtn" onclick="submitReschedule()">
                    <i class="bi bi-calendar2-check me-1"></i> Confirm Reschedule
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
                    Are you sure you want to cancel this appointment? This action cannot be undone.
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Reason for Cancellation (Optional)</label>
                    <textarea class="form-control" id="cancelReason" rows="3" placeholder="Enter reason..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Appointment</button>
                <button type="button" class="btn btn-danger" id="confirmCancelBtn" onclick="submitCancel()">
                    <i class="bi bi-x-circle me-1"></i> Yes, Cancel Appointment
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentAppointmentId = null;

// ─── VIEW ────────────────────────────────────────────────────────────────────
function showDetails(appointmentId) {
    currentAppointmentId = appointmentId;
    const modal = new bootstrap.Modal(document.getElementById('viewModal'));
    document.getElementById('viewModalBody').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">Loading appointment details...</p>
        </div>`;
    modal.show();

    fetch(`/student/appointments/${appointmentId}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) throw new Error('Failed to load');
        const a = data.appointment;

        let statusBadge = '';
        if (a.status === 'completed')  statusBadge = '<span class="badge bg-success">Completed</span>';
        else if (a.status === 'cancelled') statusBadge = '<span class="badge bg-danger">Cancelled</span>';
        else if (a.status === 'confirmed') statusBadge = '<span class="badge bg-info">Confirmed</span>';
        else statusBadge = '<span class="badge bg-warning text-dark">Scheduled</span>';

        const apptDate = new Date(a.appointment_date);
        const formatted = apptDate.toLocaleDateString('en-US', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });

        document.getElementById('viewModalBody').innerHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Counselor</small>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar">${a.counselor.name.substring(0,2).toUpperCase()}</div>
                            <strong>${a.counselor.name}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Status</small>
                        ${statusBadge}
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1"><i class="bi bi-calendar3 me-1"></i>Date & Time</small>
                        <strong>${formatted}</strong>
                    </div>
                </div>
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
    })
    .catch(() => {
        document.getElementById('viewModalBody').innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>Failed to load appointment details. Please try again.
            </div>`;
    });
}

// ─── RESCHEDULE ──────────────────────────────────────────────────────────────
function openReschedule(appointmentId, currentDate) {
    currentAppointmentId = appointmentId;
    document.getElementById('rescheduleDate').value = currentDate;
    document.getElementById('cancelReason').value = '';
    new bootstrap.Modal(document.getElementById('rescheduleModal')).show();
}

function submitReschedule() {
    const newDate = document.getElementById('rescheduleDate').value;
    if (!newDate) {
        alert('Please select a new date and time.');
        return;
    }

    const btn = document.getElementById('confirmRescheduleBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Rescheduling...';

    fetch(`/student/appointments/${currentAppointmentId}/reschedule`, {
        method: 'PUT',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ appointment_date: newDate })
    })
    .then(r => r.json().then(data => ({ ok: r.ok, status: r.status, data })))
    .then(({ ok, data }) => {
        if (ok && data.success) {
            bootstrap.Modal.getInstance(document.getElementById('rescheduleModal')).hide();
            const appt = data.appointment;
            const formatted = new Date(appt.appointment_date).toLocaleDateString('en-US', {
                month: 'short', day: 'numeric', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
            document.querySelector(`.appt-date-${currentAppointmentId}`).textContent = formatted;
            document.querySelector(`.appt-status-${currentAppointmentId}`).innerHTML =
                '<span class="badge badge-warning">Scheduled</span>';
            showToast('Appointment rescheduled successfully!', 'success');
        } else {
            // Extract validation error message if present
            let msg = data.message || 'Failed to reschedule.';
            if (data.errors) {
                msg = Object.values(data.errors).flat().join(' ');
            }
            alert('Error: ' + msg);
        }
    })
    .catch(err => alert('An error occurred: ' + err.message))
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-calendar2-check me-1"></i> Confirm Reschedule';
    });
}

// ─── CANCEL ──────────────────────────────────────────────────────────────────
function openCancel(appointmentId) {
    currentAppointmentId = appointmentId;
    document.getElementById('cancelReason').value = '';
    new bootstrap.Modal(document.getElementById('cancelModal')).show();
}

function submitCancel() {
    const reason = document.getElementById('cancelReason').value;
    const btn = document.getElementById('confirmCancelBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Cancelling...';

    fetch(`/student/appointments/${currentAppointmentId}/cancel`, {
        method: 'PUT',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ reason: reason || 'Cancelled by student.' })
    })
    .then(r => r.json().then(data => ({ ok: r.ok, data })))
    .then(({ ok, data }) => {
        if (ok && data.success) {
            bootstrap.Modal.getInstance(document.getElementById('cancelModal')).hide();
            document.querySelector(`.appt-status-${currentAppointmentId}`).innerHTML =
                '<span class="badge badge-danger">Cancelled</span>';
            const row = document.getElementById(`appointment-row-${currentAppointmentId}`);
            const btnGroup = row.querySelector('.btn-group');
            btnGroup.innerHTML = `<button class="btn btn-primary btn-sm" onclick="showDetails(${currentAppointmentId})">
                <i class="bi bi-eye"></i> View
            </button>`;
            showToast('Appointment cancelled successfully.', 'danger');
        } else {
            let msg = data.message || 'Failed to cancel.';
            if (data.errors) msg = Object.values(data.errors).flat().join(' ');
            alert('Error: ' + msg);
        }
    })
    .catch(err => alert('An error occurred: ' + err.message))
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-x-circle me-1"></i> Yes, Cancel Appointment';
    });
}

// ─── TOAST ───────────────────────────────────────────────────────────────────
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed bottom-0 end-0 m-3 shadow`;
    toast.style.cssText = 'z-index:9999;min-width:280px;animation:fadeIn .3s ease';
    toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'x-circle'} me-2"></i>${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
}
</script>
@endsection

