@extends('layouts.dashboard')

@section('title', 'Appointment Calendar')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-page-header-compact { flex-direction: column !important; align-items: flex-start !important; gap: 1rem !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    .fc { font-size: 0.875rem !important; }
    .fc-toolbar { flex-direction: column !important; gap: 0.5rem !important; }
    .fc-toolbar-chunk { justify-content: center !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-calendar3"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Appointment Calendar</h1>
            <p class="modern-page-subtitle">View and manage all your appointments in one place</p>
        </div>
        <button type="button" class="modern-btn modern-btn-primary" data-bs-toggle="modal" data-bs-target="#createAppointmentModal" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
            <i class="bi bi-plus-circle"></i> New Appointment
        </button>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 1.5rem;">
    <!-- Calendar -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div id="calendar"></div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Legend -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
                <div class="modern-section-icon modern-page-icon-green" style="width: 32px; height: 32px; font-size: 0.9rem;">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 0;">Legend</h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 16px; height: 16px; background: var(--green); border-radius: 4px;"></div>
                    <span style="font-size: 0.875rem; color: var(--navy);">Scheduled</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 16px; height: 16px; background: #22c55e; border-radius: 4px;"></div>
                    <span style="font-size: 0.875rem; color: var(--navy);">Confirmed</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 16px; height: 16px; background: #f59e0b; border-radius: 4px;"></div>
                    <span style="font-size: 0.875rem; color: var(--navy);">Pending</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 16px; height: 16px; background: #ef4444; border-radius: 4px;"></div>
                    <span style="font-size: 0.875rem; color: var(--navy);">Cancelled</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 16px; height: 16px; background: #6366f1; border-radius: 4px;"></div>
                    <span style="font-size: 0.875rem; color: var(--navy);">Completed</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="modern-card" style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
                <div class="modern-section-icon modern-page-icon-green" style="width: 32px; height: 32px; font-size: 0.9rem;">
                    <i class="bi bi-calendar-month"></i>
                </div>
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 0;">This Month</h3>
            </div>
            @php
                $thisMonth = \App\Models\Appointment::where('counselor_id', Auth::id())
                    ->whereMonth('appointment_date', now()->month)
                    ->whereYear('appointment_date', now()->year);
                $totalThisMonth = $thisMonth->count();
                $completedThisMonth = (clone $thisMonth)->where('status', 'completed')->count();
                $upcomingThisMonth = (clone $thisMonth)->whereIn('status', ['scheduled', 'confirmed'])->where('appointment_date', '>=', now())->count();
            @endphp
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $totalThisMonth }}</div>
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Total Appointments</div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $completedThisMonth }}</div>
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Completed</div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $upcomingThisMonth }}</div>
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Upcoming</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; position: relative; z-index: 1056;">
            <div class="modal-header" style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem;">
                <h5 class="modal-title" id="appointmentModalLabel" style="font-weight: 700; color: var(--navy);">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="appointmentDetails" style="padding: 1.5rem;">
                <!-- Details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Create Appointment Modal -->
<div class="modal fade" id="createAppointmentModal" tabindex="-1" aria-labelledby="createAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem;">
                <h5 class="modal-title" id="createAppointmentModalLabel" style="font-weight: 700; color: var(--navy);">
                    <i class="bi bi-calendar-plus me-2" style="color: var(--green);"></i>Schedule New Appointment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('counselor.appointments.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color: var(--navy);">
                            Select Student <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="student_id" id="studentSelect" required style="border-radius: 10px;">
                            <option value="">Choose a student...</option>
                            @foreach(\App\Models\User::whereHas('role', function($q) { $q->where('name', 'student'); })->where('is_active', true)->orderBy('name')->get() as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="color: var(--navy);">
                                Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" name="appointment_date" id="appointmentDate" required style="border-radius: 10px;" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="color: var(--navy);">
                                Time <span class="text-danger">*</span>
                            </label>
                            <input type="time" class="form-control" name="appointment_time" required style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color: var(--navy);">
                            Purpose/Reason
                        </label>
                        <input type="text" class="form-control" name="purpose" placeholder="e.g., Academic counseling, Career guidance" style="border-radius: 10px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color: var(--navy);">
                            Notes (Optional)
                        </label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Add any additional notes about this appointment..." style="border-radius: 10px;"></textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold" style="color: var(--navy);">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="status" required style="border-radius: 10px;">
                            <option value="scheduled">Scheduled</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 1.5rem;">
                    <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                        <i class="bi bi-check-circle"></i> Create Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<style>
.fc {
    font-family: inherit;
}
.fc-toolbar {
    padding: 1rem 0;
    gap: 1rem;
}
.fc-toolbar-title {
    font-size: 1.75rem !important;
    font-weight: 700 !important;
    color: var(--navy) !important;
}
.fc-toolbar-chunk {
    display: flex;
    gap: 0.5rem;
}
/* Navigation Buttons (Prev/Next/Today) */
.fc .fc-button-primary {
    background: var(--green) !important;
    border: none !important;
    text-transform: capitalize !important;
    font-weight: 600 !important;
    padding: 0.625rem 1.25rem !important;
    border-radius: 10px !important;
    font-size: 0.875rem !important;
    transition: all 0.2s ease !important;
    box-shadow: 0 2px 4px rgba(30, 122, 74, 0.15) !important;
}
.fc .fc-button-primary:hover {
    background: var(--green-dark) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(30, 122, 74, 0.2) !important;
}
.fc .fc-button-primary:disabled {
    opacity: 0.5 !important;
    cursor: not-allowed !important;
}
/* Active/Selected Button */
.fc .fc-button-active {
    background: var(--green-dark) !important;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1) !important;
}
/* View Buttons Group (Month/Week/Day) */
.fc .fc-button-group {
    display: flex;
    gap: 0.25rem;
    background: #f3f4f6;
    padding: 0.25rem;
    border-radius: 12px;
}
.fc .fc-button-group > .fc-button {
    border-radius: 10px !important;
    background: transparent !important;
    color: var(--navy) !important;
    box-shadow: none !important;
    font-weight: 600 !important;
    padding: 0.625rem 1.5rem !important;
}
.fc .fc-button-group > .fc-button:hover {
    background: rgba(30, 122, 74, 0.1) !important;
    color: var(--green) !important;
    transform: none;
}
.fc .fc-button-group > .fc-button-active {
    background: var(--green) !important;
    color: white !important;
    box-shadow: 0 2px 4px rgba(30, 122, 74, 0.2) !important;
}
/* Prev/Next Icons */
.fc .fc-prev-button,
.fc .fc-next-button {
    padding: 0.625rem !important;
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.fc .fc-icon {
    font-size: 1.25rem !important;
}
/* Today Button */
.fc .fc-today-button {
    margin-left: 0.5rem;
}
/* Calendar Grid */
.fc-daygrid-day-number {
    font-weight: 600;
    color: var(--navy);
    padding: 0.5rem;
}
.fc-col-header-cell-cushion {
    color: var(--navy);
    font-weight: 700;
    padding: 1rem 0.5rem;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}
.fc-day-today {
    background: rgba(30, 122, 74, 0.05) !important;
}
.fc-day-today .fc-daygrid-day-number {
    background: var(--green);
    color: white;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}
/* Events */
.fc-event {
    border-radius: 8px;
    border: none;
    padding: 4px 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.8rem;
    margin-bottom: 2px;
}
.fc-event:hover {
    opacity: 0.85;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.fc-event-title {
    font-weight: 600;
}
.fc-daygrid-event-dot {
    display: none;
}

@media (max-width: 1024px) {
    div[style*="grid-template-columns: 1fr 300px"] {
        grid-template-columns: 1fr !important;
    }
}
@media (max-width: 768px) {
    .fc-toolbar {
        flex-direction: column !important;
        gap: 0.75rem !important;
    }
    .fc-toolbar-chunk {
        width: 100%;
        justify-content: center !important;
    }
    .fc-toolbar-title {
        font-size: 1.25rem !important;
    }
    .fc .fc-button-primary {
        padding: 0.5rem 1rem !important;
        font-size: 0.8rem !important;
    }
    .fc .fc-button-group > .fc-button {
        padding: 0.5rem 1rem !important;
        font-size: 0.8rem !important;
    }
}

/* Modal Z-Index Fix */
.modal-backdrop {
    z-index: 1050 !important;
}
.modal {
    z-index: 1055 !important;
}
.modal-dialog {
    z-index: 1056 !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day'
        },
        height: 'auto',
        selectable: true,
        events: '/counselor/calendar/events',
        eventClick: function(info) {
            showAppointmentDetails(info.event.id);
        },
        dateClick: function(info) {
            // Open create appointment modal with pre-filled date
            const modal = new bootstrap.Modal(document.getElementById('createAppointmentModal'));
            document.getElementById('appointmentDate').value = info.dateStr;
            modal.show();
        },
        eventDidMount: function(info) {
            info.el.title = info.event.title;
        }
    });
    
    calendar.render();
});

function showAppointmentDetails(appointmentId) {
    // Close any existing modals first
    const existingModals = document.querySelectorAll('.modal.show');
    existingModals.forEach(modal => {
        const bsModal = bootstrap.Modal.getInstance(modal);
        if (bsModal) bsModal.hide();
    });
    
    fetch(`/counselor/appointments/${appointmentId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const appointment = data.appointment;
        const student = appointment.student;
        const concern = appointment.concern;
        
        let statusBadge = '';
        switch(appointment.status) {
            case 'scheduled': statusBadge = 'modern-badge-info'; break;
            case 'confirmed': statusBadge = 'modern-badge-success'; break;
            case 'pending': statusBadge = 'modern-badge-warning'; break;
            case 'cancelled': statusBadge = 'bg-danger'; break;
            case 'completed': statusBadge = 'modern-badge-success'; break;
        }
        
        const html = `
            <div style="margin-bottom: 1.5rem;">
                <span class="modern-badge ${statusBadge}" style="margin-bottom: 0.75rem; display: inline-block;">${appointment.status.toUpperCase()}</span>
                <h6 style="font-weight: 700; color: var(--navy); margin: 0;">${concern ? concern.title : 'General Appointment'}</h6>
            </div>
            <div style="margin-bottom: 1rem;">
                <small style="color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Student</small>
                <strong style="color: var(--navy);">${student.name}</strong><br>
                <small style="color: var(--text-muted);">${student.email}</small>
            </div>
            <div style="margin-bottom: 1rem;">
                <small style="color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Date & Time</small>
                <strong style="color: var(--navy);">${new Date(appointment.appointment_date).toLocaleString('en-US', {
                    dateStyle: 'full',
                    timeStyle: 'short'
                })}</strong>
            </div>
            ${appointment.notes ? `
            <div style="margin-bottom: 1.5rem;">
                <small style="color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Notes</small>
                <p style="margin: 0; color: var(--navy);">${appointment.notes}</p>
            </div>
            ` : ''}
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <a href="/counselor/appointments/${appointmentId}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
                    <i class="bi bi-eye me-1"></i>View Full Details
                </a>
                ${appointment.concern_id ? `
                <a href="/counselor/concerns/${appointment.concern_id}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
                    <i class="bi bi-file-text me-1"></i>View Concern
                </a>
                ` : ''}
            </div>
        `;
        
        document.getElementById('appointmentDetails').innerHTML = html;
        
        // Use proper Bootstrap 5 modal initialization
        const modalElement = document.getElementById('appointmentModal');
        const modal = new bootstrap.Modal(modalElement, {
            backdrop: true,
            keyboard: true,
            focus: true
        });
        modal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to load appointment details');
    });
}
</script>
@endpush
