@extends('layouts.dashboard')

@section('title', 'My Appointments')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-calendar-event"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">My Appointments</h1>
            <p class="modern-page-subtitle">View and manage your counseling sessions</p>
        </div>
        <a href="{{ route('student.appointments.create') }}" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
            <i class="bi bi-plus-circle"></i>
            <span>Schedule Appointment</span>
        </a>
    </div>
</div>

<!-- Filters Card -->
<div class="modern-card modern-card-compact mb-4" style="padding: 1.5rem;">
    <form method="GET" style="display: grid; grid-template-columns: 2fr 1fr 140px; gap: 1rem; align-items: end;">
        <div>
            <input type="text" name="search" class="form-control modern-form-control" 
                   placeholder="Search by counselor name or notes..." value="{{ request('search') }}">
        </div>
        <div>
            <select name="status" class="form-select modern-form-control">
                <option value="">All Statuses</option>
                <option value="scheduled" {{ request('status')=='scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <button type="submit" class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem;">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>
        </div>
    </form>
</div>

<!-- Appointments List -->
<div class="modern-card" style="padding: 1.5rem;">
    @if($appointments->count() > 0)
        <div class="modern-list">
            @foreach($appointments as $appointment)
                <div class="modern-list-item" style="padding: 1.25rem 0;" id="appointment-row-{{ $appointment->id }}">
                    <div style="display: flex; align-items: center; gap: 1rem; flex: 1;">
                        <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 1rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                                {{ $appointment->counselor->name }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; font-size: 0.85rem; color: var(--text-muted);">
                                <span>
                                    <i class="bi bi-calendar3"></i>
                                    <span class="appt-date-{{ $appointment->id }}">{{ $appointment->appointment_date->format('M d, Y') }}</span>
                                </span>
                                <span>
                                    <i class="bi bi-clock"></i>
                                    {{ $appointment->appointment_date->format('h:i A') }}
                                </span>
                                @if($appointment->notes)
                                    <span style="color: var(--text-muted); font-size: 0.85rem;">
                                        <i class="bi bi-journal-text"></i>
                                        {{ Str::limit($appointment->notes, 40) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                        <span class="appt-status-{{ $appointment->id }}">
                            @if($appointment->status == 'completed')
                                <span class="modern-badge modern-badge-success" style="font-size: 0.8rem;">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Completed
                                </span>
                            @elseif($appointment->status == 'cancelled')
                                <span class="modern-badge modern-badge-danger" style="font-size: 0.8rem;">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Cancelled
                                </span>
                            @elseif($appointment->status == 'confirmed')
                                <span class="modern-badge modern-badge-info" style="font-size: 0.8rem;">
                                    <i class="bi bi-check-circle"></i>
                                    Confirmed
                                </span>
                            @else
                                <span class="modern-badge modern-badge-warning" style="font-size: 0.8rem;">
                                    <i class="bi bi-clock-fill"></i>
                                    Scheduled
                                </span>
                            @endif
                        </span>
                        
                        <a href="{{ route('student.appointments.show', $appointment->id) }}" 
                           class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="bi bi-eye"></i>
                            <span>View</span>
                        </a>
                        
                        @if(in_array($appointment->status, ['scheduled', 'confirmed']) && !$appointment->concern_id)
                            <button class="modern-btn" onclick="openReschedule({{ $appointment->id }}, '{{ $appointment->appointment_date->format('Y-m-d\TH:i') }}')" 
                                    style="padding: 0.5rem 1rem; font-size: 0.875rem; background: rgba(251, 146, 60, 0.12); color: #fb923c; border: 1px solid rgba(251, 146, 60, 0.2);">
                                <i class="bi bi-calendar2"></i>
                                <span>Reschedule</span>
                            </button>
                            <button class="modern-btn" onclick="openCancel({{ $appointment->id }})" 
                                    style="padding: 0.5rem 1rem; font-size: 0.875rem; background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);">
                                <i class="bi bi-x-circle"></i>
                                <span>Cancel</span>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($appointments->hasPages())
            <div class="mt-4">
                {{ $appointments->links() }}
            </div>
        @endif
    @else
        <div class="modern-empty-state" style="padding: 3rem 2rem;">
            <div class="modern-empty-icon" style="width: 80px; height: 80px; font-size: 2.5rem;">
                <i class="bi bi-calendar-x"></i>
            </div>
            <h3 class="modern-empty-title" style="font-size: 1.15rem;">No Appointments Found</h3>
            <p class="modern-empty-text" style="font-size: 0.95rem;">
                @if(request()->has('search') || request()->has('status'))
                    No appointments match your filters. Try adjusting your search criteria.
                @else
                    You don't have any appointments scheduled yet. Book your first session with a counselor.
                @endif
            </p>
            <a href="{{ route('student.appointments.create') }}" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                <i class="bi bi-plus-circle"></i>
                <span>Schedule Your First Appointment</span>
            </a>
        </div>
    @endif
</div>

<!-- Reschedule Modal -->
<div class="modal fade" id="rescheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(30, 122, 74, 0.12);">
                <h5 class="modal-title" style="font-weight: 700; color: var(--navy);">
                    <i class="bi bi-calendar2-check me-2" style="color: #fb923c;"></i>Reschedule Appointment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <p style="color: var(--text-muted); margin-bottom: 1.25rem; font-size: 0.95rem;">Select a new date and time for your appointment.</p>
                <div class="mb-3">
                    <label class="modern-form-label">New Date & Time <span style="color: #ef4444;">*</span></label>
                    <input type="datetime-local" class="form-control modern-form-control" id="rescheduleDate"
                        min="{{ now()->addHour()->format('Y-m-d\TH:i') }}">
                    <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Must be at least 1 hour from now.</small>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(30, 122, 74, 0.12); padding: 1rem 1.5rem;">
                <button type="button" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.9rem;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="modern-btn" id="confirmRescheduleBtn" onclick="submitReschedule()" 
                        style="padding: 0.625rem 1.25rem; font-size: 0.9rem; background: linear-gradient(135deg, #fb923c, #f97316); color: white;">
                    <i class="bi bi-calendar2-check"></i> Confirm Reschedule
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid rgba(30, 122, 74, 0.12);">
                <h5 class="modal-title" style="font-weight: 700; color: var(--navy);">
                    <i class="bi bi-x-circle me-2" style="color: #ef4444;"></i>Cancel Appointment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <div class="modern-alert modern-alert-warning" style="margin-bottom: 1.25rem;">
                    <div class="modern-alert-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <p style="margin: 0;">Are you sure you want to cancel this appointment? This action cannot be undone.</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="modern-form-label">Reason for Cancellation (Optional)</label>
                    <textarea class="form-control modern-form-control" id="cancelReason" rows="3" placeholder="Enter reason..."></textarea>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(30, 122, 74, 0.12); padding: 1rem 1.5rem;">
                <button type="button" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.9rem;" data-bs-dismiss="modal">Keep Appointment</button>
                <button type="button" class="modern-btn" id="confirmCancelBtn" onclick="submitCancel()" 
                        style="padding: 0.625rem 1.25rem; font-size: 0.9rem; background: linear-gradient(135deg, #ef4444, #dc2626); color: white;">
                    <i class="bi bi-x-circle"></i> Yes, Cancel Appointment
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Filter form responsive */
.modern-card-compact form {
    display: grid;
    grid-template-columns: 2fr 1fr 140px;
    gap: 1rem;
    align-items: end;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modern-page-header-compact {
        flex-wrap: wrap;
    }
    
    .modern-page-header-compact > a {
        width: 100%;
        margin-top: 1rem;
    }
    
    /* Filters grid - single column on mobile */
    .modern-card-compact form {
        grid-template-columns: 1fr !important;
    }
    
    .modern-card-compact form button {
        width: 100% !important;
    }
    
    /* List item adjustments */
    .modern-list-item {
        flex-direction: column;
        align-items: stretch;
    }
    
    .modern-list-item > div:last-child {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
        margin-top: 0.75rem;
        gap: 0.5rem;
    }
    
    .modern-list-item > div:last-child .modern-btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 1200px) and (min-width: 769px) {
    .modern-card-compact form {
        grid-template-columns: 1fr 1fr;
    }
    
    .modern-card-compact form > div:first-child {
        grid-column: span 2;
    }
    
    .modern-card-compact form > div:last-child {
        grid-column: span 2;
    }
}
</style>

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
                '<span class="modern-badge modern-badge-warning" style="font-size: 0.8rem;"><i class="bi bi-clock-fill"></i> Scheduled</span>';
            showToast('Appointment rescheduled successfully!', 'success');
        } else {
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
        btn.innerHTML = '<i class="bi bi-calendar2-check"></i> Confirm Reschedule';
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
        btn.innerHTML = '<i class="bi bi-x-circle"></i> Yes, Cancel Appointment';
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