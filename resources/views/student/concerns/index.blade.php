@extends('layouts.dashboard')

@section('title', 'My Concerns')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">My Concerns</h5>
        <a href="{{ route('student.concerns.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Submit New Concern
        </a>
    </div>
    <div class="card-body">
        @if($concerns->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th class="table-hide-mobile">Description</th>
                            <th>Status</th>
                            <th class="table-hide-mobile">Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($concerns as $concern)
                            <tr>
                                <td>
                                    <strong>{{ $concern->title }}</strong>
                                    @if($concern->is_anonymous)
                                        <div class="mt-1">
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-incognito"></i>
                                                Anonymous
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $concern->category->name }}</span>
                                </td>
                                <td class="table-hide-mobile">
                                    <small class="text-muted">{{ Str::limit($concern->description, 80) }}</small>
                                </td>
                                <td>
                                    @if($concern->status == 'resolved')
                                        <span class="badge badge-success">Resolved</span>
                                    @elseif($concern->status == 'scheduled')
                                        <span class="badge badge-info">Scheduled</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td class="table-hide-mobile">
                                    <small class="text-muted">{{ $concern->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="showDetails({{ $concern->id }})">
                                        <i class="bi bi-eye"></i>
                                        View
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-chat-dots" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h4 class="mt-3 text-muted">No Concerns Submitted</h4>
                <p class="text-muted">You haven't submitted any concerns yet.</p>
                <a href="{{ route('student.concerns.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Submit Your First Concern
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modal for concern details -->
<div class="modal fade" id="concernModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Concern Details</h5>
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
function showDetails(concernId) {
    // Show loading state
    const modal = new bootstrap.Modal(document.getElementById('concernModal'));
    document.querySelector('#concernModal .modal-body').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading concern details...</p>
        </div>
    `;
    modal.show();

    // Fetch concern details via AJAX
    fetch(`/student/concerns/${concernId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const concern = data.concern;
            
            // Format the status badge
            let statusBadge = '';
            if (concern.status === 'resolved') {
                statusBadge = '<span class="badge bg-success">Resolved</span>';
            } else if (concern.status === 'scheduled') {
                statusBadge = '<span class="badge bg-info">Scheduled</span>';
            } else if (concern.status === 'under_review') {
                statusBadge = '<span class="badge bg-warning">Under Review</span>';
            } else {
                statusBadge = '<span class="badge bg-secondary">Submitted</span>';
            }

            // Build the concern details HTML
            let detailsHTML = `
                <div class="concern-details">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5 class="mb-2">${concern.title}</h5>
                            ${concern.is_anonymous ? '<span class="badge bg-secondary"><i class="bi bi-incognito"></i> Anonymous</span>' : ''}
                        </div>
                        <div class="col-md-4 text-md-end">
                            ${statusBadge}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted"><strong>Category:</strong></small>
                            <div><span class="badge bg-info">${concern.category.name}</span></div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <small class="text-muted"><strong>Submitted:</strong></small>
                            <div>${new Date(concern.created_at).toLocaleDateString('en-US', { 
                                year: 'numeric', 
                                month: 'short', 
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            })}</div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="text-muted">Description</h6>
                        <p class="mb-0">${concern.description.replace(/\n/g, '<br>')}</p>
                    </div>
            `;

            // Add counselor response if it exists
            if (concern.counselor_response) {
                detailsHTML += `
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="bi bi-person-check-fill"></i>
                            Counselor Response
                        </h6>
                        <p class="mb-0">${concern.counselor_response.replace(/\n/g, '<br>')}</p>
                    </div>
                `;
            }

            // Add resolved timestamp if resolved
            if (concern.resolved_at) {
                detailsHTML += `
                    <div class="text-success">
                        <small><i class="bi bi-check-circle-fill"></i> 
                        Resolved on ${new Date(concern.resolved_at).toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</small>
                    </div>
                `;
            }

            // Add counseling date if status is scheduled and date is provided
            if (concern.status === 'scheduled' && concern.counseling_date) {
                const counselingDate = new Date(concern.counseling_date);
                
                detailsHTML += `
                    <div class="alert alert-warning mt-3">
                        <h6 class="alert-heading">
                            <i class="bi bi-calendar-check"></i>
                            Counseling Session Scheduled
                        </h6>
                        <div class="row">
                            <div class="col-md-12">
                                <strong>Date & Time:</strong><br>
                                ${counselingDate.toLocaleDateString('en-US', { 
                                    weekday: 'long',
                                    year: 'numeric', 
                                    month: 'long', 
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}
                            </div>
                        </div>
                    </div>
                `;
            }

            // Add scheduled appointment date if exists (additional info)
            if (concern.appointments && concern.appointments.length > 0) {
                const appointment = concern.appointments[0]; // Get the most recent appointment
                const appointmentDate = new Date(appointment.appointment_date);
                
                let appointmentStatus = '';
                if (appointment.status === 'scheduled') {
                    appointmentStatus = '<span class="badge bg-warning">Scheduled</span>';
                } else if (appointment.status === 'confirmed') {
                    appointmentStatus = '<span class="badge bg-info">Confirmed</span>';
                } else if (appointment.status === 'completed') {
                    appointmentStatus = '<span class="badge bg-success">Completed</span>';
                }

                detailsHTML += `
                    <div class="alert alert-info mt-2">
                        <h6 class="alert-heading">
                            <i class="bi bi-calendar-event"></i>
                            Appointment Details
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Date & Time:</strong><br>
                                ${appointmentDate.toLocaleDateString('en-US', { 
                                    weekday: 'long',
                                    year: 'numeric', 
                                    month: 'long', 
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}
                            </div>
                            <div class="col-md-6 text-md-end">
                                <strong>Status:</strong><br>
                                ${appointmentStatus}
                            </div>
                        </div>
                        ${appointment.notes ? `
                            <div class="mt-2">
                                <strong>Notes:</strong><br>
                                <small>${appointment.notes.replace(/\n/g, '<br>')}</small>
                            </div>
                        ` : ''}
                    </div>
                `;
            }

            detailsHTML += '</div>';
            
            // Update modal content
            document.querySelector('#concernModal .modal-body').innerHTML = detailsHTML;
        } else {
            throw new Error('Failed to load concern details');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.querySelector('#concernModal .modal-body').innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i>
                <strong>Error:</strong> Failed to load concern details. Please try again.
            </div>
        `;
    });
}
</script>
@endsection
