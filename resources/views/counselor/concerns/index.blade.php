@extends('layouts.dashboard')

@section('title', 'Student Concerns')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-page-header-compact { flex-direction: column !important; align-items: flex-start !important; gap: 1rem !important; }
    .modern-btn { width: 100% !important; justify-content: center !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    .modern-stats-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 0.75rem !important; }
    .modern-stat-card { padding: 1rem !important; }
    .modern-stat-value { font-size: 1.5rem !important; }
    
    /* Filter Form - Stack Vertically */
    .filter-form {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.75rem !important;
        align-items: stretch !important;
        grid-template-columns: unset !important;
    }
    .filter-form > div {
        width: 100% !important;
    }
    .filter-form .form-control,
    .filter-form .form-select {
        width: 100% !important;
        border-radius: 0.5rem !important;
    }
    .filter-form .modern-btn,
    .filter-form button[type="submit"] {
        width: 100% !important;
        border-radius: 0.5rem !important;
    }
    
    /* Table Action Buttons - Icon Only */
    .btn span:not([class*="bi"]),
    .btn-sm span:not([class*="bi"]) { 
        display: none !important; 
    }
    .btn i.bi,
    .btn-sm i.bi { 
        margin: 0 !important; 
    }
    .btn-sm { 
        padding: 0.5rem 0.75rem !important; 
        min-width: auto !important; 
    }
    
    div[style*="display: grid"][style*="grid-template-columns"] { grid-template-columns: 1fr !important; gap: 1rem !important; }
    .table-responsive { font-size: 0.875rem !important; }
    .badge { font-size: 0.7rem !important; padding: 0.25rem 0.5rem !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-chat-dots-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Student Concerns</h1>
            <p class="modern-page-subtitle">Manage and respond to student concerns</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <form method="GET" class="filter-form" style="display: grid; grid-template-columns: repeat(4, 1fr) auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Title, description, or student..." value="{{ request('search') }}" style="border-radius: 10px;">
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Status</label>
            <select name="status" class="form-select" style="border-radius: 10px;">
                <option value="">All Statuses</option>
                <option value="submitted" {{ request('status')=='submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="under_review" {{ request('status')=='under_review' ? 'selected' : '' }}>Under Review</option>
                <option value="scheduled" {{ request('status')=='scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="resolved" {{ request('status')=='resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Category</label>
            <select name="category" class="form-select" style="border-radius: 10px;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category')==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Sort By</label>
            <select name="sort" class="form-select" style="border-radius: 10px;">
                <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ request('sort')=='oldest' ? 'selected' : '' }}>Oldest First</option>
            </select>
        </div>
        <div>
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- Concerns List -->
<div class="modern-card" style="padding: 1.5rem;">
    @if($concerns->count() > 0)
        <div class="modern-list">
            @foreach($concerns as $concern)
                <div class="modern-list-item" style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb; display: block;">
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: start;">
                        <!-- Left: Concern Info -->
                        <div style="display: flex; gap: 1rem;">
                            <!-- Student Avatar -->
                            <div>
                                @if($concern->is_anonymous)
                                    <div class="modern-section-icon" style="width: 48px; height: 48px; background: rgba(107, 114, 128, 0.1); color: #6b7280;">
                                        <i class="bi bi-incognito"></i>
                                    </div>
                                @else
                                    <div class="modern-section-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; font-size: 0.9rem; font-weight: 700;">
                                        {{ strtoupper(substr($concern->student->name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 0;">{{ $concern->title }}</h3>
                                    @if($concern->status == 'resolved')
                                        <span class="modern-badge modern-badge-success" style="font-size: 0.75rem;"><i class="bi bi-check-circle-fill"></i> Resolved</span>
                                    @elseif($concern->status == 'scheduled')
                                        <span class="modern-badge modern-badge-info" style="font-size: 0.75rem;"><i class="bi bi-calendar-check"></i> Scheduled</span>
                                    @elseif($concern->status == 'under_review')
                                        <span class="modern-badge modern-badge-warning" style="font-size: 0.75rem;"><i class="bi bi-eye-fill"></i> Under Review</span>
                                    @else
                                        <span class="modern-badge modern-badge-secondary" style="font-size: 0.75rem;"><i class="bi bi-clock-fill"></i> Submitted</span>
                                    @endif
                                </div>
                                
                                <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.75rem;">
                                    <span>
                                        <i class="bi bi-person-fill"></i> 
                                        {{ $concern->is_anonymous ? 'Anonymous' : $concern->student->name }}
                                    </span>
                                    <span>
                                        <i class="bi bi-tag-fill"></i> 
                                        {{ $concern->category->name }}
                                    </span>
                                    <span>
                                        <i class="bi bi-clock"></i> 
                                        {{ $concern->created_at->diffForHumans() }}
                                    </span>
                                    @if($concern->counseling_date)
                                        <span style="color: var(--green); font-weight: 600;">
                                            <i class="bi bi-calendar-check"></i> 
                                            {{ $concern->counseling_date->format('M d, Y h:i A') }}
                                        </span>
                                    @endif
                                </div>
                                
                                <p style="font-size: 0.875rem; color: #6b7280; margin: 0; line-height: 1.6;">
                                    {{ Str::limit($concern->description, 120) }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Right: Actions -->
                        <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                            <a href="{{ route('counselor.concerns.show', $concern->id) }}" 
                               class="modern-btn modern-btn-secondary" 
                               style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;">
                                <i class="bi bi-eye"></i> View
                            </a>
                            @if(!in_array($concern->status, ['resolved', 'scheduled']))
                                <button class="modern-btn modern-btn-primary" 
                                        style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;"
                                        onclick="respondToConcern({{ $concern->id }})">
                                    <i class="bi bi-reply-fill"></i> Respond
                                </button>
                            @endif
                            <button type="button" class="modern-btn" 
                                    style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.5rem 1rem; font-size: 0.875rem;"
                                    onclick="confirmDelete('{{ route('counselor.concerns.destroy', $concern->id) }}', '{{ addslashes($concern->title) }}', 'concern')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($concerns->hasPages())
            <div style="margin-top: 1.5rem;">{{ $concerns->links() }}</div>
        @endif
    @else
        <div class="modern-empty-state" style="padding: 3rem 1.5rem;">
            <div class="modern-empty-icon" style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="bi bi-chat-dots"></i>
            </div>
            <h3 class="modern-empty-title">No concerns found</h3>
            <p class="modern-empty-text">
                @if(request()->hasAny(['search', 'status', 'category']))
                    No concerns match your filter criteria. Try adjusting your filters.
                @else
                    No student concerns have been submitted yet.
                @endif
            </p>
            @if(request()->hasAny(['search', 'status', 'category']))
                <a href="{{ route('counselor.concerns.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
            @endif
        </div>
    @endif
</div>

<!-- Modal for responding to concern -->
<div class="modal fade" id="responseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem;">
                <h5 class="modal-title" style="font-weight: 700; color: var(--navy);">
                    <i class="bi bi-reply-fill me-2" style="color: var(--green);"></i>Respond to Concern
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="responseForm">
                @csrf
                <div class="modal-body" style="padding: 1.5rem;">
                    <input type="hidden" name="concern_id" id="response_concern_id">
                    <input type="hidden" name="status" value="scheduled">

                    <div style="margin-bottom: 1.25rem;">
                        <label for="counseling_date" style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                            <i class="bi bi-calendar3 me-1"></i>Counseling Date & Time <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="datetime-local" class="form-control" name="counseling_date" id="counseling_date"
                            min="{{ now()->format('Y-m-d\TH:i') }}" required style="border-radius: 10px; padding: 0.75rem;">
                        <small style="color: var(--text-muted); font-size: 0.8rem;">Select the date and time for the counseling session</small>
                    </div>
                    
                    <div style="margin-bottom: 1.25rem;">
                        <label for="response" style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                            <i class="bi bi-chat-text me-1"></i>Response Message <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea class="form-control" name="response" id="response" rows="5" required 
                                  placeholder="Enter your response to the student..." 
                                  style="border-radius: 10px; padding: 0.75rem;"></textarea>
                        <small style="color: var(--text-muted); font-size: 0.8rem;">This message will be sent to the student</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 1.5rem;">
                    <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal" style="padding: 0.625rem 1.25rem;">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem;">
                        <i class="bi bi-send-fill"></i> Submit Response
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-body text-center" style="padding: 2rem;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--green), var(--green-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 24px rgba(30, 122, 74, 0.2);">
                    <i class="bi bi-check-circle-fill" style="font-size: 2.5rem; color: white;"></i>
                </div>
                
                <h4 style="font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Response Submitted!</h4>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">The student will be notified about the scheduled counseling session</p>
                
                <div id="confirmationDetails" style="background: #f9fafb; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; text-align: left;"></div>
                
                <button type="button" class="modern-btn modern-btn-primary" onclick="closeConfirmationModal()" style="padding: 0.625rem 1.5rem;">
                    <i class="bi bi-check2"></i> Done
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function respondToConcern(concernId) {
    document.getElementById('response_concern_id').value = concernId;
    document.getElementById('responseForm').action = `/counselor/concerns/${concernId}/respond`;
    
    const now = new Date();
    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
    document.getElementById('counseling_date').min = localDateTime;
    
    document.getElementById('counseling_date').value = '';
    document.getElementById('response').value = '';
    
    const modal = new bootstrap.Modal(document.getElementById('responseModal'));
    modal.show();
}

document.getElementById('responseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    if (!formData.get('counseling_date')) {
        alert('Please select a counseling date and time.');
        return;
    }

    const concernId = formData.get('concern_id');
    const response = formData.get('response');
    const counselingDate = formData.get('counseling_date');
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Submitting...';
    submitBtn.disabled = true;
    
    fetch(this.action, {
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
            const date = new Date(counselingDate);
            const formattedDate = date.toLocaleDateString('en-US', { 
                weekday: 'long',
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const detailsHTML = `
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                        <span style="color: var(--text-muted);">Status:</span>
                        <span style="font-weight: 600; color: var(--green);">Scheduled</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                        <span style="color: var(--text-muted);">Session Date:</span>
                        <span style="font-weight: 600; color: var(--navy);">${formattedDate}</span>
                    </div>
                    <div style="font-size: 0.875rem;">
                        <div style="color: var(--text-muted); margin-bottom: 0.25rem;">Message:</div>
                        <div style="color: var(--navy);">${response}</div>
                    </div>
                </div>
            `;
            
            document.getElementById('confirmationDetails').innerHTML = detailsHTML;
            
            bootstrap.Modal.getInstance(document.getElementById('responseModal')).hide();
            
            setTimeout(() => {
                const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                confirmationModal.show();
            }, 300);
            
        } else {
            alert('Error: ' + (data.message || 'Failed to submit response'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting your response. Please try again.');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

function closeConfirmationModal() {
    bootstrap.Modal.getInstance(document.getElementById('confirmationModal')).hide();
    location.reload();
}

function confirmDelete(url, title, type) {
    if (confirm(`Are you sure you want to delete this ${type}?\n\n"${title}"\n\nThis action cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<style>
@media (max-width: 1200px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"],
    div[style*="grid-template-columns: 1fr auto"] {
        grid-template-columns: 1fr !important;
    }
    
    .modern-list-item > div {
        flex-direction: column;
    }
    
    .modern-list-item > div > div:last-child {
        width: 100%;
    }
    
    .modern-list-item > div > div:last-child > div {
        width: 100%;
        justify-content: stretch;
    }
    
    .modern-list-item > div > div:last-child button,
    .modern-list-item > div > div:last-child a {
        flex: 1;
    }
}
</style>
@endsection
