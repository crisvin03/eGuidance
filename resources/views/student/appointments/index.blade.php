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
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
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
                                        <span>{{ $appointment->appointment_date->format('M d, Y h:i A') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($appointment->status == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @elseif($appointment->status == 'cancelled')
                                        <span class="badge badge-danger">Cancelled</span>
                                    @else
                                        <span class="badge badge-info">Scheduled</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $appointment->notes ? Str::limit($appointment->notes, 80) : '-' }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-primary btn-sm" onclick="showDetails({{ $appointment->id }})">
                                            <i class="bi bi-eye"></i>
                                            View
                                        </button>
                                        @if($appointment->status == 'scheduled')
                                            <button class="btn btn-warning btn-sm" onclick="rescheduleAppointment({{ $appointment->id }})">
                                                <i class="bi bi-calendar2"></i>
                                                Reschedule
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="cancelAppointment({{ $appointment->id }})">
                                                <i class="bi bi-x-circle"></i>
                                                Cancel
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

<!-- Modal for appointment details -->
<div class="modal fade" id="appointmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function showDetails(appointmentId) {
    // In a real application, you would fetch this data via AJAX
    const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
    document.querySelector('#appointmentModal .modal-body').innerHTML = `
        <p><strong>Loading appointment details...</strong></p>
        <p>This would show the full appointment details including session notes.</p>
    `;
    modal.show();
}

function rescheduleAppointment(appointmentId) {
    // In a real application, this would open a reschedule form
    alert('Reschedule functionality would be implemented here');
}

function cancelAppointment(appointmentId) {
    if (confirm('Are you sure you want to cancel this appointment?')) {
        // In a real application, you would submit a cancel request
        alert('Cancel functionality would be implemented here');
    }
}
</script>
@endsection
