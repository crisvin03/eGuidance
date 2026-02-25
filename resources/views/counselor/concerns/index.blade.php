@extends('layouts.dashboard')

@section('title', 'Student Concerns')

<style>
.success-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
    animation: successPulse 0.6s ease-out;
    position: relative;
    overflow: hidden;
}

.success-icon::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
    transform: rotate(45deg);
    animation: shimmer 2s infinite;
}

@keyframes successPulse {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes shimmer {
    0% {
        transform: translateX(-100%) translateY(-100%) rotate(45deg);
    }
    100% {
        transform: translateX(100%) translateY(100%) rotate(45deg);
    }
}

.detail-item {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-radius: 6px;
    padding: 6px 10px;
    margin-bottom: 6px;
    border-left: 2px solid #007bff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.detail-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,123,255,0.05) 0%, transparent 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.detail-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.detail-item:hover::before {
    opacity: 1;
}

.detail-item:last-child {
    margin-bottom: 0;
}

.detail-label {
    font-weight: 600;
    color: #495057;
    font-size: 0.75rem;
    margin-bottom: 2px;
    text-transform: uppercase;
    letter-spacing: 0.2px;
}

.detail-value {
    color: #212529;
    font-size: 0.8rem;
    line-height: 1.2;
}

.status-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 15px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

.status-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s ease;
}

.status-badge:hover::before {
    left: 100%;
}

.status-scheduled {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
}

.status-resolved {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    color: white;
}

.status-review {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    color: #212529;
}

.counseling-date {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-radius: 4px;
    padding: 4px 8px;
    display: inline-block;
    margin-top: 2px;
    border: 1px solid #90caf9;
    position: relative;
}

.counseling-date i {
    color: #1976d2;
    margin-right: 4px;
    font-size: 0.8rem;
}

.action-buttons {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 6px;
    padding: 8px;
    margin-top: 8px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}

.btn-enhanced {
    border-radius: 15px;
    padding: 4px 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.2px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-size: 0.75rem;
}

.btn-enhanced::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s ease, height 0.6s ease;
}

.btn-enhanced:hover::before {
    width: 150px;
    height: 150px;
}

.btn-enhanced:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

.confetti {
    position: absolute;
    width: 4px;
    height: 4px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    animation: confetti-fall 3s ease-out forwards;
}

@keyframes confetti-fall {
    0% {
        transform: translateY(-100vh) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
    }
}

.progress-indicator {
    display: flex;
    justify-content: center;
    margin-bottom: 8px;
    gap: 4px;
}

.progress-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #dee2e6;
    transition: all 0.3s ease;
}

.progress-dot.active {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    transform: scale(1.2);
}

.timestamp {
    font-size: 0.65rem;
    color: #6c757d;
    text-align: center;
    margin-top: 6px;
    font-style: italic;
}

/* Prevent scrollbars on confirmation modal */
#confirmationModal {
    overflow: hidden !important;
}

#confirmationModal .modal-dialog {
    overflow: hidden !important;
}

#confirmationModal .modal-content {
    overflow: hidden !important;
}

#confirmationModal .modal-body {
    overflow: hidden !important;
}

#confirmationModal * {
    overflow: hidden !important;
}
</style>

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Student Concerns</h5>
    </div>
    <div class="card-body">
        @if($concerns->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th class="table-hide-mobile">Description</th>
                            <th>Status</th>
                            <th class="table-hide-mobile">Counseling Date</th>
                            <th class="table-hide-mobile">Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($concerns as $concern)
                            <tr>
                                <td>
                                    @if($concern->is_anonymous)
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar">
                                                <i class="bi bi-incognito"></i>
                                            </div>
                                            <span class="text-muted">Anonymous</span>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($concern->student->name, 0, 2)) }}
                                            </div>
                                            <span>{{ $concern->student->name }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $concern->title }}</strong>
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
                                    @if($concern->counseling_date)
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-check"></i>
                                            {{ $concern->counseling_date->format('M d, Y h:i A') }}
                                        </small>
                                    @else
                                        <small class="text-muted">Not scheduled</small>
                                    @endif
                                </td>
                                <td class="table-hide-mobile">
                                    <small class="text-muted">{{ $concern->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-primary btn-sm" onclick="showDetails({{ $concern->id }})">
                                            <i class="bi bi-eye"></i>
                                            View
                                        </button>
                                        @if($concern->status !== 'resolved')
                                            <button class="btn btn-success btn-sm" onclick="respondToConcern({{ $concern->id }})">
                                                <i class="bi bi-reply"></i>
                                                Respond
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
                <i class="bi bi-chat-dots" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h4 class="mt-3 text-muted">No Student Concerns</h4>
                <p class="text-muted">No student concerns have been submitted yet.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal for concern details -->
<div class="modal fade" id="concernModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
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

<!-- Modal for responding to concern -->
<div class="modal fade" id="responseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Respond to Concern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="responseForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="concern_id" id="response_concern_id">
                    
                    <input type="hidden" name="status" value="scheduled">

                    <div class="mb-3">
                        <label for="counseling_date" class="form-label">
                            <i class="bi bi-calendar3 me-1"></i>Counseling Date & Time <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control" name="counseling_date" id="counseling_date"
                            min="{{ now()->format('Y-m-d\TH:i') }}" required>
                        <small class="text-muted">Select the date and time for the counseling session</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="response" class="form-label">Response</label>
                        <textarea class="form-control" name="response" id="response" rows="4" required placeholder="Enter your response to the student..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i>
                        Submit Response
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Professional Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body text-center p-3">
                <div class="progress-indicator">
                    <div class="progress-dot active"></div>
                    <div class="progress-dot active"></div>
                    <div class="progress-dot active"></div>
                </div>
                
                <div class="mb-2">
                    <div class="success-icon mx-auto">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
                
                <h5 class="mb-1 text-success fw-bold">Response Submitted!</h5>
                <p class="text-muted mb-2 small">Student will be notified</p>
                
                <div id="confirmationDetails" class="text-start mb-2">
                    <!-- Details will be inserted here -->
                </div>
                
                <div class="action-buttons">
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-primary btn-enhanced btn-sm" onclick="closeConfirmationModal()">
                            <i class="bi bi-check2 me-1"></i>
                            Done
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-enhanced btn-sm" onclick="viewAnotherConcern()">
                            <i class="bi bi-plus me-1"></i>
                            Another
                        </button>
                    </div>
                </div>
                
                <div class="timestamp" id="timestamp">
                    <!-- Timestamp will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showDetails(concernId) {
    const modal = new bootstrap.Modal(document.getElementById('concernModal'));
    document.querySelector('#concernModal .modal-body').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">Loading concern details...</p>
        </div>`;
    modal.show();

    fetch(`/counselor/concerns/${concernId}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json().then(data => ({ ok: r.ok, data })))
    .then(({ ok, data }) => {
        if (!ok || !data.success) throw new Error('Failed to load');
        const c = data.concern;

        let statusBadge = '';
        if (c.status === 'resolved')      statusBadge = '<span class="badge bg-success">Resolved</span>';
        else if (c.status === 'scheduled') statusBadge = '<span class="badge bg-info">Scheduled</span>';
        else if (c.status === 'under_review') statusBadge = '<span class="badge bg-warning text-dark">Under Review</span>';
        else statusBadge = '<span class="badge bg-secondary">Submitted</span>';

        const submitted = new Date(c.created_at).toLocaleDateString('en-US', {
            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
        });

        let html = `
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Student</small>
                        <strong>${c.is_anonymous ? '<i class="bi bi-incognito me-1"></i>Anonymous' : c.student.name}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Status</small>
                        ${statusBadge}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Category</small>
                        <span class="badge bg-info">${c.category.name}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1">Submitted</small>
                        <small>${submitted}</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1"><i class="bi bi-chat-dots me-1"></i>Title</small>
                        <strong>${c.title}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block mb-1"><i class="bi bi-text-paragraph me-1"></i>Description</small>
                        <p class="mb-0">${c.description.replace(/\n/g, '<br>')}</p>
                    </div>
                </div>`;

        if (c.counseling_date) {
            const cDate = new Date(c.counseling_date).toLocaleDateString('en-US', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
            });
            html += `
                <div class="col-12">
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-calendar-check me-2"></i>
                        <strong>Counseling Scheduled:</strong> ${cDate}
                    </div>
                </div>`;
        }

        if (c.counselor_response) {
            html += `
                <div class="col-12">
                    <div class="alert alert-info mb-0">
                        <h6 class="alert-heading"><i class="bi bi-person-check-fill me-1"></i>Counselor Response</h6>
                        <p class="mb-0">${c.counselor_response.replace(/\n/g, '<br>')}</p>
                    </div>
                </div>`;
        }

        html += `</div>`;
        document.querySelector('#concernModal .modal-body').innerHTML = html;
    })
    .catch(() => {
        document.querySelector('#concernModal .modal-body').innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>Failed to load concern details. Please try again.
            </div>`;
    });
}

function respondToConcern(concernId) {
    document.getElementById('response_concern_id').value = concernId;
    
    // Set the correct form action with the concern ID
    document.getElementById('responseForm').action = `/counselor/concerns/${concernId}/respond`;
    
    // Set minimum date to current date/time
    const now = new Date();
    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
    document.getElementById('counseling_date').min = localDateTime;
    
    // Reset form
    document.getElementById('counseling_date').value = '';
    document.getElementById('response').value = '';
    
    const modal = new bootstrap.Modal(document.getElementById('responseModal'));
    modal.show();
}


document.getElementById('responseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);

    // Validate counseling date
    if (!formData.get('counseling_date')) {
        alert('Please select a counseling date and time.');
        return;
    }

    // Get form data
    const concernId = formData.get('concern_id');
    const response = formData.get('response');
    const counselingDate = formData.get('counseling_date');
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Submitting...';
    submitBtn.disabled = true;
    
    // Submit the form via AJAX/Fetch
    fetch(this.action || '/counselor/concerns/respond', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Generate professional confirmation details
            let statusClass = '';
            let statusText = status.replace('_', ' ').toUpperCase();
            
            if (status === 'scheduled') {
                statusClass = 'status-scheduled';
            } else if (status === 'resolved') {
                statusClass = 'status-resolved';
            } else {
                statusClass = 'status-review';
            }
            
            let detailsHTML = `
                <div class="detail-item">
                    <div class="detail-label">Status Update</div>
                    <div class="detail-value">
                        <span class="status-badge ${statusClass}">${statusText}</span>
                    </div>
                </div>
            `;
            
            if (status === 'scheduled' && counselingDate) {
                const date = new Date(counselingDate);
                const formattedDate = date.toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric' 
                });
                const formattedTime = date.toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                
                detailsHTML += `
                    <div class="detail-item">
                        <div class="detail-label">Counseling Session</div>
                        <div class="detail-value">
                            <div class="counseling-date">
                                <i class="bi bi-calendar-check"></i>
                                ${formattedDate} at ${formattedTime}
                            </div>
                        </div>
                    </div>
                `;
            }
            
            detailsHTML += `
                <div class="detail-item">
                    <div class="detail-label">Response Message</div>
                    <div class="detail-value">${response}</div>
                </div>
            `;
            
            // Add timestamp
            const now = new Date();
            const timestamp = now.toLocaleString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Update confirmation modal with details
            document.getElementById('confirmationDetails').innerHTML = detailsHTML;
            document.getElementById('timestamp').innerHTML = `<i class="bi bi-clock me-1"></i>Submitted on ${timestamp}`;
            
            // Close response modal and show confirmation
            bootstrap.Modal.getInstance(document.getElementById('responseModal')).hide();
            
            setTimeout(() => {
                const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                confirmationModal.show();
                
                // Create confetti effect
                createConfetti();
                
                // Animate progress dots
                animateProgressDots();
            }, 300);
            
            // Update the table row to reflect changes
            updateConcernRow(concernId, status, counselingDate);
            
        } else {
            alert('Error: ' + (data.message || 'Failed to submit response'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting your response. Please try again.');
    })
    .finally(() => {
        // Reset button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

function updateConcernRow(concernId, status, counselingDate) {
    // Find the table row for this concern
    const rows = document.querySelectorAll('tbody tr');
    let targetRow = null;
    
    rows.forEach(row => {
        const respondBtn = row.querySelector('button[onclick*="' + concernId + '"]');
        if (respondBtn) {
            targetRow = row;
        }
    });
    
    if (targetRow) {
        // Update status badge
        const statusCell = targetRow.cells[4]; // Status column
        let statusClass = '';
        let statusText = '';
        
        if (status === 'scheduled') {
            statusClass = 'badge-info';
            statusText = 'Scheduled';
        } else if (status === 'resolved') {
            statusClass = 'badge-success';
            statusText = 'Resolved';
        } else {
            statusClass = 'badge-warning';
            statusText = 'Pending';
        }
        
        statusCell.innerHTML = `<span class="badge ${statusClass}">${statusText}</span>`;
        
        // Update counseling date column
        const counselingDateCell = targetRow.cells[5]; // Counseling Date column
        if (status === 'scheduled' && counselingDate) {
            const date = new Date(counselingDate);
            const formattedDate = date.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric', 
                year: 'numeric' 
            });
            const formattedTime = date.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            counselingDateCell.innerHTML = `
                <small class="text-muted">
                    <i class="bi bi-calendar-check"></i>
                    ${formattedDate} ${formattedTime}
                </small>
            `;
        } else {
            counselingDateCell.innerHTML = '<small class="text-muted">Not scheduled</small>';
        }
        
        // Hide respond button if resolved
        if (status === 'resolved') {
            const respondBtn = targetRow.querySelector('button[onclick*="respondToConcern"]');
            if (respondBtn) {
                respondBtn.style.display = 'none';
            }
        }
    }
}

function createConfetti() {
    const modal = document.getElementById('confirmationModal');
    const colors = ['#28a745', '#20c997', '#007bff', '#17a2b8', '#ffc107'];
    
    for (let i = 0; i < 10; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.animationDelay = Math.random() * 0.3 + 's';
            confetti.style.animationDuration = (Math.random() * 1.5 + 1.5) + 's';
            modal.appendChild(confetti);
            
            // Remove confetti after animation
            setTimeout(() => {
                confetti.remove();
            }, 3000);
        }, i * 50);
    }
}

function animateProgressDots() {
    const dots = document.querySelectorAll('.progress-dot');
    dots.forEach((dot, index) => {
        setTimeout(() => {
            dot.classList.add('active');
        }, index * 200);
    });
}

function closeConfirmationModal() {
    bootstrap.Modal.getInstance(document.getElementById('confirmationModal')).hide();
    // In a real application, you might refresh the page or update the table
    // window.location.reload();
}

function viewAnotherConcern() {
    bootstrap.Modal.getInstance(document.getElementById('confirmationModal')).hide();
    // Reset form for new concern
    document.getElementById('responseForm').reset();
    document.getElementById('counselingDateGroup').style.display = 'none';
    
    // Reset progress dots
    const dots = document.querySelectorAll('.progress-dot');
    dots.forEach(dot => dot.classList.remove('active'));
}
</script>
@endsection
