@extends('layouts.dashboard')
@section('title', 'Appointment Details')

@section('content')
@include('student.partials.modern-styles')

<style>
/* Mobile Responsive Styles for Counselor Pages */
@media (max-width: 768px) {
    /* Two-column grid becomes single column */
    div[style*="grid-template-columns: 1fr 380px"] {
        display: block !important;
    }
    
    /* Remove fixed widths on mobile */
    .modern-card {
        margin-bottom: 1rem !important;
    }
    
    /* Stack action buttons vertically */
    div[style*="display: flex"][style*="gap"] {
        flex-direction: column !important;
    }
    
    /* Full width buttons on mobile */
    .modern-btn {
        width: 100% !important;
        justify-content: center !important;
    }
    
    /* Reduce padding on cards */
    .modern-card[style*="padding: 1.5rem"] {
        padding: 1rem !important;
    }
    
    /* Make badges smaller */
    .modern-badge, .badge {
        font-size: 0.75rem !important;
    }
    
    /* Responsive grid for info boxes */
    .row.g-3 {
        gap: 0.5rem !important;
    }
    
    /* Full width columns on mobile */
    .col-md-6, .col-md-4, .col-md-3, .col-12 {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Smaller text on mobile */
    h1[style*="font-size: 1.5rem"] {
        font-size: 1.25rem !important;
    }
    
    h6.fw-bold {
        font-size: 0.95rem !important;
    }
    
    /* User avatar smaller */
    .user-avatar {
        width: 32px !important;
        height: 32px !important;
        font-size: 0.75rem !important;
    }
    
    /* Textareas more compact */
    textarea.form-control {
        font-size: 0.875rem !important;
    }
    
    /* Card borders and alerts */
    .card, .alert {
        margin-bottom: 1rem !important;
    }
}
</style>

@php
    // Determine if this is a teacher request based on student role
    $isTeacher = $appointment->student && $appointment->student->role && $appointment->student->role->name === 'teacher';
@endphp

<!-- Back Button & Actions -->
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
    <a href="{{ route('counselor.appointments.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
        <i class="bi bi-arrow-left"></i> Back to Appointments
    </a>
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        @if($appointment->status === 'scheduled')
            <button class="modern-btn modern-btn-primary" style="padding: 0.625rem 1rem; font-size: 0.875rem;" onclick="updateStatus('confirmed')">
                <i class="bi bi-check-circle"></i> Confirm
            </button>
            <button class="modern-btn" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.625rem 1rem; font-size: 0.875rem;" onclick="updateStatus('cancelled')">
                <i class="bi bi-x-circle"></i> Cancel
            </button>
        @elseif($appointment->status === 'confirmed')
            <button class="modern-btn modern-btn-primary" style="padding: 0.625rem 1rem; font-size: 0.875rem;" onclick="updateStatus('completed')">
                <i class="bi bi-check2-all"></i> Mark Completed
            </button>
        @endif
        @if(in_array($appointment->status, ['confirmed','completed']))
            <a href="{{ route('counselor.appointments.session-notes.create', $appointment) }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
                <i class="bi bi-journal-plus"></i> Add Session Note
            </a>
        @endif
    </div>
</div>

<!-- Page Header -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--green); margin: 0 0 0.5rem 0;">Appointment #{{ $appointment->id }}</h1>
            <p style="color: var(--text-muted); margin: 0;">{{ $isTeacher ? 'Teacher request' : 'Student booking' }} - {{ $appointment->created_at->format('M d, Y') }}</p>
        </div>
        @if($appointment->status == 'confirmed')
            <span class="modern-badge modern-badge-success" style="font-size: 0.9rem;"><i class="bi bi-check-circle-fill"></i> Confirmed</span>
        @elseif($appointment->status == 'completed')
            <span class="modern-badge modern-badge-success" style="font-size: 0.9rem;"><i class="bi bi-check-all"></i> Completed</span>
        @elseif($appointment->status == 'cancelled')
            <span class="modern-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 0.9rem;"><i class="bi bi-x-circle-fill"></i> Cancelled</span>
        @else
            <span class="modern-badge modern-badge-warning" style="font-size: 0.9rem;"><i class="bi bi-clock-fill"></i> Scheduled</span>
        @endif
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 1.5rem;">
    <!-- Main Content -->
    <div>
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-calendar-check me-2" style="color:#1e7a4a;"></i>Appointment Details
            </h6>
            <div>

                {{-- Person + date info --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-2">
                                <i class="bi bi-{{ $isTeacher ? 'person-badge' : 'person' }} me-1"></i>
                                {{ $isTeacher ? 'Teacher' : 'Student' }}
                            </small>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar" style="width:36px;height:36px;font-size:.8rem;">
                                    {{ strtoupper(substr($appointment->student->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $appointment->student->name }}</div>
                                    <div class="text-muted" style="font-size:.72rem;">{{ $appointment->student->email }}</div>
                                </div>
                            </div>
                            @if(!$isTeacher && $appointment->student->student_id)
                                <div class="mt-2"><small class="text-muted">ID: {{ $appointment->student->student_id }}</small></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-calendar3 me-1"></i>Date & Time
                            </small>
                            <strong>{{ $appointment->appointment_date->format('l, F d, Y') }}</strong>
                            <div class="text-muted small">{{ $appointment->appointment_date->format('h:i A') }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">Source</small>
                            @if($appointment->concern_id)
                                <span class="badge" style="background: "rgba(30,122,74,$($args[0].Groups[1].Value))" ;color:#0f766e;border:1px solid #99f6e4;">
                                    <i class="bi bi-chat-left-heart me-1"></i>From Concern
                                </span>
                            @elseif($isTeacher)
                                <span class="badge" style="background: "rgba(30,122,74,$($args[0].Groups[1].Value))" ;color:#0f766e;border:1px solid #99f6e4;">
                                    <i class="bi bi-person-badge me-1"></i>Teacher Request
                                </span>
                            @else
                                <span class="badge" style="background:#f1f5f9;color:#475569;">
                                    <i class="bi bi-calendar-plus me-1"></i>Direct Booking
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($appointment->notes)
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-chat-left-text me-1"></i>Purpose / Notes
                            </small>
                            <span class="small">{{ $appointment->notes }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Status notice --}}
                @if($appointment->status === 'confirmed')
                <div class="alert alert-info">
                    <h6 class="alert-heading fw-semibold"><i class="bi bi-check-circle-fill me-1"></i>Appointment Confirmed</h6>
                    <p class="mb-0">This appointment has been confirmed. Mark it as completed after the session.</p>
                </div>
                @elseif($appointment->status === 'completed')
                <div class="alert alert-success">
                    <h6 class="alert-heading fw-semibold"><i class="bi bi-check2-circle me-1"></i>Appointment Completed</h6>
                    <p class="mb-0">This appointment has been marked as completed.</p>
                </div>
                @elseif($appointment->status === 'cancelled')
                <div class="alert alert-danger">
                    <h6 class="alert-heading fw-semibold"><i class="bi bi-x-circle-fill me-1"></i>Appointment Cancelled</h6>
                    @if($appointment->cancellation_reason)
                        <p class="mb-0"><strong>Reason:</strong> {{ $appointment->cancellation_reason }}</p>
                    @else
                        <p class="mb-0">This appointment has been cancelled.</p>
                    @endif
                </div>
                @endif

                {{-- Related concern --}}
                @if($appointment->concern)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-chat-left-heart me-1"></i>Related Concern</h6>
                    <div class="card border-0" style="background:#f0fdfa;border:1px solid #99f6e4 !important;border-radius:12px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0">{{ $appointment->concern->title }}</h6>
                                <span class="badge bg-info">{{ $appointment->concern->category->name }}</span>
                            </div>
                            <p class="text-muted small mb-0">{{ \Str::limit($appointment->concern->description, 200) }}</p>
                            @if($appointment->concern->counselor_response)
                            <div class="alert alert-info mt-2 mb-0 py-2 small">
                                <strong>Your response:</strong> {{ $appointment->concern->counselor_response }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- Session notes --}}
                @if($appointment->sessionNotes && $appointment->sessionNotes->count() > 0)
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0"><i class="bi bi-journal-text me-1"></i>Session Notes</h6>
                        @if(in_array($appointment->status, ['confirmed','completed']))
                        <a href="{{ route('counselor.appointments.session-notes.create', $appointment) }}"
                           class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-plus-circle me-1"></i>Add Note
                        </a>
                        @endif
                    </div>
                    @foreach($appointment->sessionNotes as $note)
                    <div class="card border-0 mb-3"
                         style="border-left:4px solid #1e7a4a !important;border-radius:0 12px 12px 0;background:#f0fdfa;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge fw-semibold"
                                          style="background: "rgba(30,122,74,$($args[0].Groups[1].Value))" ;color:#0f766e;">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ ucfirst(str_replace('_',' ',$note->session_type)) }} Session
                                    </span>
                                    <div class="text-muted small mt-1">
                                        By {{ $note->counselor->name }} &bull; {{ $note->created_at->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                                @if($note->is_confidential)
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-lock-fill me-1"></i>Confidential
                                    </span>
                                @endif
                            </div>
                            <p class="mb-0 small" style="white-space:pre-wrap;">{{ $note->notes }}</p>
                            @if($note->recommendations)
                            <div class="mt-2 p-2 rounded" style="background: "rgba(30,122,74,$($args[0].Groups[1].Value))" ;">
                                <strong class="small"><i class="bi bi-lightbulb me-1"></i>Recommendations:</strong>
                                <p class="mb-0 small mt-1" style="white-space:pre-wrap;">{{ $note->recommendations }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @elseif(in_array($appointment->status, ['confirmed','completed']))
                <div class="alert border-0 mb-0"
                     style="background:#f0fdfa;border-left:4px solid #1e7a4a !important;border-radius:0 12px 12px 0;">
                    <i class="bi bi-info-circle me-2" style="color:#1e7a4a;"></i>
                    No session notes yet.
                    <a href="{{ route('counselor.appointments.session-notes.create', $appointment) }}"
                       class="fw-semibold" style="color:#1e7a4a;">Add a session note.</a>
                </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Right sidebar --}}
    <div>
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                Appointment Status
            </h6>
            <div>
                <div class="d-flex flex-column gap-3">

                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width:28px;height:28px;min-width:28px;background:{{ in_array($appointment->status, ['scheduled','confirmed','completed']) ? 'linear-gradient(135deg,#1e7a4a,#145e38)' : '#e2e8f0' }};">
                            <i class="bi bi-send-fill" style="font-size:.65rem;color:{{ in_array($appointment->status, ['scheduled','confirmed','completed']) ? '#fff' : '#94a3b8' }};"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color:{{ in_array($appointment->status, ['scheduled','confirmed','completed']) ? '#1e293b' : '#94a3b8' }};">Scheduled</div>
                            <div class="text-muted" style="font-size:.72rem;">{{ $appointment->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>

                    <div style="width:2px;height:20px;background:{{ in_array($appointment->status, ['confirmed','completed']) ? '#1e7a4a' : '#e2e8f0' }};margin-left:13px;"></div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width:28px;height:28px;min-width:28px;background:{{ in_array($appointment->status, ['confirmed','completed']) ? 'linear-gradient(135deg,#1e7a4a,#145e38)' : '#e2e8f0' }};">
                            <i class="bi bi-check-circle-fill" style="font-size:.65rem;color:{{ in_array($appointment->status, ['confirmed','completed']) ? '#fff' : '#94a3b8' }};"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color:{{ in_array($appointment->status, ['confirmed','completed']) ? '#1e293b' : '#94a3b8' }};">Confirmed</div>
                            <div class="text-muted" style="font-size:.72rem;">
                                @if($appointment->status === 'cancelled') Not applicable
                                @elseif(in_array($appointment->status, ['confirmed','completed'])) Session confirmed
                                @else Awaiting confirmation
                                @endif
                            </div>
                        </div>
                    </div>

                    <div style="width:2px;height:20px;background:{{ $appointment->status === 'completed' ? '#1e7a4a' : '#e2e8f0' }};margin-left:13px;"></div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width:28px;height:28px;min-width:28px;background:{{ $appointment->status === 'completed' ? 'linear-gradient(135deg,#059669,#047857)' : ($appointment->status === 'cancelled' ? '#fef2f2' : '#e2e8f0') }};">
                            @if($appointment->status === 'cancelled')
                                <i class="bi bi-x-lg" style="font-size:.65rem;color:#ef4444;"></i>
                            @else
                                <i class="bi bi-check2-all" style="font-size:.65rem;color:{{ $appointment->status === 'completed' ? '#fff' : '#94a3b8' }};"></i>
                            @endif
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color:{{ $appointment->status === 'completed' ? '#059669' : ($appointment->status === 'cancelled' ? '#ef4444' : '#94a3b8') }};">
                                @if($appointment->status === 'cancelled') Cancelled
                                @elseif($appointment->status === 'completed') Completed
                                @else Session Done
                                @endif
                            </div>
                            @if($appointment->status === 'completed')
                                <div class="text-muted" style="font-size:.72rem;">Session finished</div>
                            @elseif($appointment->status === 'cancelled' && $appointment->cancellation_reason)
                                <div class="text-muted" style="font-size:.72rem;">{{ \Str::limit($appointment->cancellation_reason, 35) }}</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-3" style="border-radius:16px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Quick Info</h6>
                <div class="d-flex flex-column gap-3">
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">{{ $isTeacher ? 'Teacher' : 'Student' }}</small>
                        <span class="fw-semibold small">{{ $appointment->student->name }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Scheduled On</small>
                        <span class="fw-semibold small">{{ $appointment->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Appointment Date</small>
                        <span class="fw-semibold small">{{ $appointment->appointment_date->format('M d, Y h:i A') }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Status</small>
                        @if($appointment->status == 'confirmed')
                            <span class="modern-badge modern-badge-success" style="font-size: 0.85rem;"><i class="bi bi-check-circle-fill"></i> Confirmed</span>
                        @elseif($appointment->status == 'completed')
                            <span class="modern-badge modern-badge-success" style="font-size: 0.85rem;"><i class="bi bi-check-all"></i> Completed</span>
                        @elseif($appointment->status == 'cancelled')
                            <span class="modern-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 0.85rem;"><i class="bi bi-x-circle-fill"></i> Cancelled</span>
                        @else
                            <span class="modern-badge modern-badge-warning" style="font-size: 0.85rem;"><i class="bi bi-clock-fill"></i> Scheduled</span>
                        @endif
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Session Notes</small>
                        <span class="fw-semibold small">{{ $appointment->sessionNotes ? $appointment->sessionNotes->count() : 0 }} note(s)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Status update modal --}}
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content border-0" style="border-radius:16px;box-shadow:0 20px 50px rgba(0,0,0,.15);">
            <div id="statusStripe" style="height:4px;border-radius:16px 16px 0 0;"></div>
            <div class="modal-header border-0 px-4 pt-4 pb-2">
                <h5 class="fw-bold mb-0" id="statusModalTitle">Update Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('counselor.appointments.respond', $appointment) }}">
                @csrf
                <div class="modal-body px-4 pb-0">
                    <input type="hidden" name="status" id="status_value">
                    <div id="cancellation_reason_div" class="mb-3" style="display:none;">
                        <label class="form-label fw-semibold small">Cancellation Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="cancellation_reason" rows="3" placeholder="Please provide a reason..."></textarea>
                    </div>
                    <div id="notes_div" class="mb-3" style="display:none;">
                        <label class="form-label fw-semibold small">Session Notes <span class="text-muted">(Optional)</span></label>
                        <textarea class="form-control" name="notes" rows="4" placeholder="Summarize what was discussed..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 gap-2">
                    <button type="button" class="btn btn-secondary flex-fill" style="border-radius:10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn flex-fill fw-semibold text-white" id="statusSubmitBtn" style="border-radius:10px;">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStatus(status) {
    document.getElementById('status_value').value = status;
    document.getElementById('cancellation_reason_div').style.display = status === 'cancelled' ? 'block' : 'none';
    document.getElementById('notes_div').style.display = status === 'completed' ? 'block' : 'none';
    const titles  = { confirmed:'Confirm Appointment', completed:'Mark as Completed', cancelled:'Cancel Appointment' };
    const stripes = { confirmed:'linear-gradient(90deg,#10b981,#059669)', completed:'linear-gradient(90deg,#f59e0b,#d97706)', cancelled:'linear-gradient(90deg,#ef4444,#dc2626)' };
    const btnBgs  = { confirmed:'linear-gradient(135deg,#1e7a4a,#145e38)', completed:'linear-gradient(135deg,#f59e0b,#d97706)', cancelled:'linear-gradient(135deg,#ef4444,#dc2626)' };
    const labels  = { confirmed:'<i class="bi bi-check-circle me-1"></i>Yes, Confirm', completed:'<i class="bi bi-check2-all me-1"></i>Mark Completed', cancelled:'<i class="bi bi-x-circle me-1"></i>Yes, Cancel' };
    document.getElementById('statusModalTitle').textContent = titles[status];
    document.getElementById('statusStripe').style.background = stripes[status];
    const btn = document.getElementById('statusSubmitBtn');
    btn.style.background = btnBgs[status];
    btn.innerHTML = labels[status];
    new bootstrap.Modal(document.getElementById('statusModal')).show();
}
</script>

@endsection
