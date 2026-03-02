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
                                        <a href="{{ route('student.appointments.show', $appointment->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> View
                                        </a>
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
            location.reload();
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

