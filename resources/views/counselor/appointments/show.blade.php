@extends('layouts.dashboard')
@section('title', 'Appointment Details')

@section('content')

@php
    $badgeMap = [
        'confirmed' => ['bg'=>'#eff6ff','color'=>'#1e40af','border'=>'#93c5fd','label'=>'Confirmed'],
        'completed' => ['bg'=>'#ecfdf5','color'=>'#065f46','border'=>'#6ee7b7','label'=>'Completed'],
        'cancelled' => ['bg'=>'#fef2f2','color'=>'#991b1b','border'=>'#fca5a5','label'=>'Cancelled'],
        'scheduled' => ['bg'=>'#fef3c7','color'=>'#92400e','border'=>'#fbbf24','label'=>'Scheduled'],
    ];
    $badge     = $badgeMap[$appointment->status] ?? $badgeMap['scheduled'];
    $isTeacher = $appointment->requester_type === 'teacher';
@endphp

<div class="row">
    {{-- Back + action buttons row --}}
    <div class="col-12 mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <a href="{{ route('counselor.appointments.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Appointments
        </a>
        <div class="d-flex gap-2 flex-wrap">
            @if($appointment->status === 'scheduled')
                <button class="btn btn-sm text-white fw-semibold"
                        style="background:linear-gradient(135deg,#20B2AA,#008B8B);"
                        onclick="updateStatus('confirmed')">
                    <i class="bi bi-check-circle me-1"></i> Confirm
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="updateStatus('cancelled')">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </button>
            @elseif($appointment->status === 'confirmed')
                <button class="btn btn-sm btn-warning fw-semibold" onclick="updateStatus('completed')">
                    <i class="bi bi-check2-all me-1"></i> Mark Completed
                </button>
            @endif
            @if(in_array($appointment->status, ['confirmed','completed']))
                <a href="{{ route('counselor.appointments.session-notes.create', $appointment) }}"
                   class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-journal-plus me-1"></i> Add Session Note
                </a>
            @endif
        </div>
    </div>

    {{-- Left: main card --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header d-flex justify-content-between align-items-center py-3 px-4"
                 style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <div>
                    <h5 class="card-title mb-0 fw-bold">Appointment Details</h5>
                    <small class="text-muted">
                        {{ $isTeacher ? 'Teacher request' : 'Student booking' }}
                        &mdash; {{ $appointment->created_at->format('M d, Y') }}
                    </small>
                </div>
                <span class="badge fw-semibold px-3 py-2"
                      style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};border:1px solid {{ $badge['border'] }};font-size:.8rem;">
                    {{ $badge['label'] }}
                </span>
            </div>

            <div class="card-body p-4">

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
                                <span class="badge" style="background:rgba(32,178,170,.12);color:#0f766e;border:1px solid #99f6e4;">
                                    <i class="bi bi-chat-left-heart me-1"></i>From Concern
                                </span>
                            @elseif($isTeacher)
                                <span class="badge" style="background:rgba(32,178,170,.12);color:#0f766e;border:1px solid #99f6e4;">
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
                         style="border-left:4px solid #20B2AA !important;border-radius:0 12px 12px 0;background:#f0fdfa;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge fw-semibold"
                                          style="background:rgba(32,178,170,.15);color:#0f766e;">
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
                            <div class="mt-2 p-2 rounded" style="background:rgba(32,178,170,.08);">
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
                     style="background:#f0fdfa;border-left:4px solid #20B2AA !important;border-radius:0 12px 12px 0;">
                    <i class="bi bi-info-circle me-2" style="color:#20B2AA;"></i>
                    No session notes yet.
                    <a href="{{ route('counselor.appointments.session-notes.create', $appointment) }}"
                       class="fw-semibold" style="color:#20B2AA;">Add a session note.</a>
                </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Right sidebar — identical structure to teacher show --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="card-title mb-0 fw-bold">Appointment Status</h6>
            </div>
            <div class="card-body px-4 py-3">
                <div class="d-flex flex-column gap-3">

                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width:28px;height:28px;min-width:28px;background:{{ in_array($appointment->status, ['scheduled','confirmed','completed']) ? 'linear-gradient(135deg,#20B2AA,#008B8B)' : '#e2e8f0' }};">
                            <i class="bi bi-send-fill" style="font-size:.65rem;color:{{ in_array($appointment->status, ['scheduled','confirmed','completed']) ? '#fff' : '#94a3b8' }};"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color:{{ in_array($appointment->status, ['scheduled','confirmed','completed']) ? '#1e293b' : '#94a3b8' }};">Scheduled</div>
                            <div class="text-muted" style="font-size:.72rem;">{{ $appointment->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>

                    <div style="width:2px;height:20px;background:{{ in_array($appointment->status, ['confirmed','completed']) ? '#20B2AA' : '#e2e8f0' }};margin-left:13px;"></div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width:28px;height:28px;min-width:28px;background:{{ in_array($appointment->status, ['confirmed','completed']) ? 'linear-gradient(135deg,#20B2AA,#008B8B)' : '#e2e8f0' }};">
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

                    <div style="width:2px;height:20px;background:{{ $appointment->status === 'completed' ? '#20B2AA' : '#e2e8f0' }};margin-left:13px;"></div>

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
                        <span class="badge fw-semibold"
                              style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};border:1px solid {{ $badge['border'] }};">
                            {{ $badge['label'] }}
                        </span>
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
    const btnBgs  = { confirmed:'linear-gradient(135deg,#20B2AA,#008B8B)', completed:'linear-gradient(135deg,#f59e0b,#d97706)', cancelled:'linear-gradient(135deg,#ef4444,#dc2626)' };
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
