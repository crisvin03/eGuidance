@extends('layouts.dashboard')

@section('title', 'Appointment Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Appointment Details</h5>
                <div>
                    @if($appointment->status == 'scheduled')
                        <button class="btn btn-success btn-sm" onclick="updateStatus('confirmed')">Confirm</button>
                        <button class="btn btn-danger btn-sm" onclick="updateStatus('cancelled')">Cancel</button>
                    @elseif($appointment->status == 'confirmed')
                        <button class="btn btn-warning btn-sm" onclick="updateStatus('completed')">Complete</button>
                        <button class="btn btn-danger btn-sm" onclick="updateStatus('cancelled')">Cancel</button>
                    @endif
                    <a href="{{ route('counselor.appointments.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>
            </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Student Information</h5>
                            <p><strong>Name:</strong> {{ $appointment->student->name }}</p>
                            <p><strong>Email:</strong> {{ $appointment->student->email }}</p>
                            @if($appointment->student->student_id)
                                <p><strong>Student ID:</strong> {{ $appointment->student->student_id }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Appointment Information</h5>
                            <p><strong>Date & Time:</strong> {{ $appointment->appointment_date->format('M d, Y h:i A') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $appointment->status == 'completed' ? 'success' : ($appointment->status == 'cancelled' ? 'danger' : 'primary') }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </p>
                            @if($appointment->notes)
                                <p><strong>Notes:</strong> {{ $appointment->notes }}</p>
                            @endif
                        </div>
                    </div>
                    
                    @if($appointment->concern)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Related Concern</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <h6>{{ $appointment->concern->title }}</h6>
                                        <p><strong>Category:</strong> {{ $appointment->concern->category->name }}</p>
                                        <p>{{ $appointment->concern->description }}</p>
                                        @if($appointment->concern->counselor_response)
                                            <div class="alert alert-info">
                                                <strong>Counselor Response:</strong><br>
                                                {{ $appointment->concern->counselor_response }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($appointment->sessionNotes->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Session Notes</h5>
                                @foreach($appointment->sessionNotes as $note)
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6>{{ ucfirst($note->session_type) }} Session</h6>
                                                <small class="text-muted">{{ $note->created_at->format('M d, Y h:i A') }}</small>
                                            </div>
                                            <p>{{ $note->notes }}</p>
                                            @if($note->recommendations)
                                                <div class="alert alert-light">
                                                    <strong>Recommendations:</strong><br>
                                                    {{ $note->recommendations }}
                                                </div>
                                            @endif
                                            @if($note->is_confidential)
                                                <small class="text-muted"><i class="fas fa-lock"></i> Confidential</small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @if($appointment->status !== 'completed')
                        <div class="row mt-4">
                            <div class="col-12">
                                <button class="btn btn-primary" onclick="createSessionNote()">Add Session Note</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    </div>
</div>

<!-- Modal for updating status -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Appointment Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('counselor.appointments.respond', $appointment) }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="status" id="status_value">
                    
                    <div id="cancellation_reason_div" class="mb-3" style="display: none;">
                        <label for="cancellation_reason" class="form-label">Cancellation Reason</label>
                        <textarea class="form-control" name="cancellation_reason" id="cancellation_reason" rows="3"></textarea>
                    </div>
                    
                    <div id="notes_div" class="mb-3" style="display: none;">
                        <label for="notes" class="form-label">Session Notes</label>
                        <textarea class="form-control" name="notes" id="notes" rows="3" placeholder="Enter session notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStatus(status) {
    document.getElementById('status_value').value = status;
    
    // Show/hide relevant fields based on status
    document.getElementById('cancellation_reason_div').style.display = status === 'cancelled' ? 'block' : 'none';
    document.getElementById('notes_div').style.display = status === 'completed' ? 'block' : 'none';
    
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
}

function createSessionNote() {
    window.location.href = `/counselor/appointments/{{ $appointment->id }}/session-notes/create`;
}
</script>
@endsection
