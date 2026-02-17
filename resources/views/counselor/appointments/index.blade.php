@extends('layouts.dashboard')

@section('title', 'My Appointments')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">My Appointments</h5>
    </div>
    <div class="card-body">
        @if($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student</th>
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
                                    @if($appointment->status == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @elseif($appointment->status == 'cancelled')
                                        <span class="badge badge-danger">Cancelled</span>
                                    @else
                                        <span class="badge badge-info">Scheduled</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $appointment->notes ? Str::limit($appointment->notes, 50) : '-' }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('counselor.appointments.show', $appointment) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i>
                                            View
                                        </a>
                                        @if($appointment->status == 'scheduled')
                                            <button class="btn btn-success btn-sm" onclick="updateStatus({{ $appointment->id }}, 'confirmed')">
                                                <i class="bi bi-check-circle"></i>
                                                Confirm
                                            </button>
                                            <button class="btn btn-warning btn-sm" onclick="updateStatus({{ $appointment->id }}, 'completed')">
                                                <i class="bi bi-check2"></i>
                                                Complete
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="updateStatus({{ $appointment->id }}, 'cancelled')">
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
                <h4 class="mt-3 text-muted">No Appointments</h4>
                <p class="text-muted">No appointments have been scheduled yet.</p>
            </div>
        @endif
    </div>
</div>

<script>
function updateStatus(appointmentId, status) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/counselor/appointments/${appointmentId}/respond`;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    
    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'status';
    statusInput.value = status;
    
    if (status === 'cancelled') {
        const reason = prompt('Please provide cancellation reason:');
        if (!reason) return;
        
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'cancellation_reason';
        reasonInput.value = reason;
        form.appendChild(reasonInput);
    } else if (status === 'completed') {
        const notes = prompt('Session notes (optional):');
        if (notes) {
            const notesInput = document.createElement('input');
            notesInput.type = 'hidden';
            notesInput.name = 'notes';
            notesInput.value = notes;
            form.appendChild(notesInput);
        }
    }
    
    form.appendChild(csrfToken);
    form.appendChild(statusInput);
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection
