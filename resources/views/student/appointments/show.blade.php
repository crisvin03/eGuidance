@extends('layouts.dashboard')

@section('title', 'Appointment Details')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('student.appointments.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to My Appointments
        </a>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Appointment Details</h5>
                @if($appointment->status == 'completed')
                    <span class="badge badge-success">Completed</span>
                @elseif($appointment->status == 'cancelled')
                    <span class="badge badge-danger">Cancelled</span>
                @elseif($appointment->status == 'confirmed')
                    <span class="badge badge-info">Confirmed</span>
                @else
                    <span class="badge badge-warning">Scheduled</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">Counselor</small>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar">{{ strtoupper(substr($appointment->counselor->name, 0, 2)) }}</div>
                                <strong>{{ $appointment->counselor->name }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-calendar3 me-1"></i>Date & Time</small>
                            <strong>{{ $appointment->appointment_date->format('l, F d, Y h:i A') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">Source</small>
                            @if($appointment->concern_id)
                                <span class="badge" style="background-color:#6f42c1"><i class="bi bi-chat-left-heart me-1"></i>From Concern</span>
                            @else
                                <span class="badge bg-secondary"><i class="bi bi-calendar-plus me-1"></i>Direct Booking</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">Scheduled On</small>
                            <strong>{{ $appointment->created_at->format('M d, Y') }}</strong>
                        </div>
                    </div>

                    @if($appointment->notes)
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-chat-left-text me-1"></i>Notes</small>
                            <p class="mb-0" style="white-space:pre-wrap;">{{ $appointment->notes }}</p>
                        </div>
                    </div>
                    @endif

                    @if($appointment->cancellation_reason)
                    <div class="col-12">
                        <div class="alert alert-danger mb-0">
                            <small class="fw-bold"><i class="bi bi-x-circle me-1"></i>Cancellation Reason:</small><br>
                            {{ $appointment->cancellation_reason }}
                        </div>
                    </div>
                    @endif
                </div>

                @if(in_array($appointment->status, ['scheduled','confirmed']) && !$appointment->concern_id)
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-warning btn-sm" onclick="openReschedule({{ $appointment->id }}, '{{ $appointment->appointment_date->format('Y-m-d\TH:i') }}')">
                        <i class="bi bi-calendar2 me-1"></i> Reschedule
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="openCancel({{ $appointment->id }})">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                </div>
                @endif
            </div>
        </div>

        @if($appointment->concern)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0"><i class="bi bi-chat-left-heart me-1"></i>Linked Concern</h6>
            </div>
            <div class="card-body">
                <div class="p-3 border rounded" style="border-color:#6f42c1!important;background:#f8f5ff;">
                    <div class="fw-semibold mb-1" style="color:#6f42c1;">{{ $appointment->concern->title }}</div>
                    @if($appointment->concern->category)
                        <span class="badge bg-info mb-2">{{ $appointment->concern->category->name }}</span>
                    @endif
                    <p class="mb-0 text-muted small">{{ Str::limit($appointment->concern->description, 200) }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Appointment Status</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    @foreach(['scheduled' => 'Scheduled', 'confirmed' => 'Confirmed', 'completed' => 'Completed'] as $s => $label)
                    @php
                        $order = ['scheduled'=>1,'confirmed'=>2,'completed'=>3];
                        $curOrder = $order[$appointment->status] ?? 0;
                        $thisOrder = $order[$s];
                        $active = $curOrder >= $thisOrder && $appointment->status !== 'cancelled';
                    @endphp
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-circle-fill" style="color:{{ $active ? '#20B2AA' : '#cbd5e1' }}; font-size:.5rem;"></i>
                        <small class="{{ $active ? 'fw-semibold' : 'text-muted' }}">{{ $label }}</small>
                    </div>
                    @endforeach
                    @if($appointment->status == 'cancelled')
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <i class="bi bi-circle-fill" style="color:#ef4444; font-size:.5rem;"></i>
                        <small class="fw-semibold text-danger">Cancelled</small>
                    </div>
                    @endif
                </div>
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
                <div class="mb-3">
                    <label class="form-label fw-semibold">New Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" id="rescheduleDate"
                        min="{{ now()->addHour()->format('Y-m-d\TH:i') }}">
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
                <h5 class="modal-title text-danger"><i class="bi bi-x-circle me-2"></i>Cancel Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning"><i class="bi bi-exclamation-triangle me-2"></i>Are you sure you want to cancel? This cannot be undone.</div>
                <div class="mb-3">
                    <label class="form-label">Reason (Optional)</label>
                    <textarea class="form-control" id="cancelReason" rows="3" placeholder="Enter reason..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Appointment</button>
                <button type="button" class="btn btn-danger" id="confirmCancelBtn" onclick="submitCancel()">
                    <i class="bi bi-x-circle me-1"></i> Yes, Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentAppointmentId = null;

function openReschedule(id, currentDate) {
    currentAppointmentId = id;
    document.getElementById('rescheduleDate').value = currentDate;
    new bootstrap.Modal(document.getElementById('rescheduleModal')).show();
}

function submitReschedule() {
    const newDate = document.getElementById('rescheduleDate').value;
    if (!newDate) { alert('Please select a new date.'); return; }
    const btn = document.getElementById('confirmRescheduleBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Rescheduling...';
    fetch(`/student/appointments/${currentAppointmentId}/reschedule`, {
        method: 'PUT',
        headers: {
            'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ appointment_date: newDate })
    })
    .then(r => r.json().then(data => ({ ok: r.ok, data })))
    .then(({ ok, data }) => {
        if (ok && data.success) {
            location.reload();
        } else {
            let msg = data.message || 'Failed to reschedule.';
            if (data.errors) msg = Object.values(data.errors).flat().join(' ');
            alert('Error: ' + msg);
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-calendar2-check me-1"></i> Confirm Reschedule';
        }
    })
    .catch(err => { alert('Error: ' + err.message); btn.disabled = false; btn.innerHTML = '<i class="bi bi-calendar2-check me-1"></i> Confirm Reschedule'; });
}

function openCancel(id) {
    currentAppointmentId = id;
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
            'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ reason: reason || 'Cancelled by student.' })
    })
    .then(r => r.json().then(data => ({ ok: r.ok, data })))
    .then(({ ok, data }) => {
        if (ok && data.success) { location.reload(); }
        else {
            alert('Error: ' + (data.message || 'Failed to cancel.'));
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-x-circle me-1"></i> Yes, Cancel';
        }
    })
    .catch(err => { alert('Error: ' + err.message); btn.disabled = false; btn.innerHTML = '<i class="bi bi-x-circle me-1"></i> Yes, Cancel'; });
}
</script>
@endsection
