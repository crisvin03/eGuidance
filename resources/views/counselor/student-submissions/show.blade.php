@extends('layouts.dashboard')

@section('title', 'Submission Details')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 320px"] { display: block !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    .modern-btn { width: 100% !important; justify-content: center !important; }
    div[style*="display: flex"][style*="gap"] { flex-direction: column !important; }
}
</style>

<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('counselor.student-submissions.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
        <i class="bi bi-arrow-left me-2"></i>Back to Submissions
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem;">
    <!-- Main Content -->
    <div>
        <!-- Submission Details Card -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 2px solid #e5e7eb;">
                <div style="flex: 1;">
                    <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--navy); margin: 0 0 0.75rem 0;">{{ $submission->title }}</h1>
                    <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                        @if($submission->status == 'approved')
                            <span class="modern-badge modern-badge-success"><i class="bi bi-check-circle-fill"></i> Approved</span>
                        @elseif($submission->status == 'rejected')
                            <span class="modern-badge modern-badge-danger"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                        @else
                            <span class="modern-badge modern-badge-warning"><i class="bi bi-clock-fill"></i> Pending</span>
                        @endif
                        
                        <span class="modern-badge modern-badge-info"><i class="bi bi-{{ $submission->type === 'poetry' ? 'feather' : ($submission->type === 'artwork' ? 'palette' : 'camera') }}"></i> {{ $submission->type_label }}</span>
                        
                        @if($submission->is_featured)
                            <span class="modern-badge modern-badge-warning"><i class="bi bi-star-fill"></i> Featured</span>
                        @endif
                        
                        @if($submission->is_anonymous)
                            <span class="modern-badge modern-badge-secondary"><i class="bi bi-incognito"></i> Anonymous</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Info Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: #f9fafb; border-radius: 12px; padding: 1rem;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Student</div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div class="modern-section-icon" style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; font-size: 0.8rem; font-weight: 700;">
                            {{ strtoupper(substr($submission->student->name, 0, 2)) }}
                        </div>
                        <strong style="color: var(--navy);">{{ $submission->student->name }}</strong>
                    </div>
                </div>

                <div style="background: #f9fafb; border-radius: 12px; padding: 1rem;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">
                        <i class="bi bi-calendar"></i> Submitted
                    </div>
                    <strong style="color: var(--navy);">{{ $submission->created_at->format('M d, Y h:i A') }}</strong>
                </div>

                @if($submission->reviewed_at)
                <div style="background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(30, 122, 74, 0.04)); border: 1px solid rgba(30, 122, 74, 0.2); border-radius: 12px; padding: 1rem; grid-column: 1 / -1;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--green); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">
                        <i class="bi bi-check-circle"></i> Reviewed By
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <strong style="color: var(--navy); font-size: 1rem;">{{ $submission->reviewer->name }}</strong>
                        <span style="color: var(--text-muted); font-size: 0.875rem;">{{ $submission->reviewed_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Description -->
            @if($submission->description)
            <div style="margin-bottom: 1.5rem;">
                <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">
                    <i class="bi bi-text-paragraph me-2"></i>Description
                </h6>
                <p style="margin: 0; color: #4b5563; line-height: 1.6; white-space: pre-wrap;">{{ $submission->description }}</p>
            </div>
            @endif

            <!-- Content/File -->
            @if($submission->type === 'poetry' && $submission->content)
            <div style="margin-bottom: 1.5rem;">
                <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">
                    <i class="bi bi-feather me-2"></i>Content
                </h6>
                <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.5rem; line-height: 1.8; font-family: 'Georgia', serif; color: var(--navy); white-space: pre-wrap;">{{ $submission->content }}</div>
            </div>
            @elseif($submission->hasFile())
            <div style="margin-bottom: 1.5rem;">
                <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">
                    <i class="bi bi-paperclip me-2"></i>Uploaded File
                </h6>
                @if(in_array(strtolower($submission->file_type), ['jpg', 'jpeg', 'png', 'gif']))
                    <div style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 1rem; background: #f9fafb; text-align: center;">
                        <img src="{{ Storage::url($submission->file_path) }}"
                             alt="{{ $submission->title }}"
                             style="max-width: 100%; max-height: 450px; border-radius: 8px;">
                    </div>
                    <div style="margin-top: 0.75rem; display: flex; gap: 0.5rem;">
                        <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="modern-btn modern-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Open Full Image
                        </a>
                        <a href="{{ Storage::url($submission->file_path) }}" download="{{ $submission->file_name }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="bi bi-download me-2"></i>Download
                        </a>
                    </div>
                @else
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 2px solid #e5e7eb; border-radius: 12px; background: #f9fafb;">
                        <i class="bi bi-file-earmark-text" style="font-size: 2.5rem; color: var(--green);"></i>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: var(--navy);">{{ $submission->file_name }}</div>
                            <small style="color: var(--text-muted); text-transform: uppercase;">{{ strtoupper($submission->file_type) }} • {{ $submission->formatted_file_size }}</small>
                        </div>
                        <a href="{{ Storage::url($submission->file_path) }}" download="{{ $submission->file_name }}" class="modern-btn modern-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="bi bi-download me-2"></i>Download
                        </a>
                    </div>
                @endif
            </div>
            @endif

            <!-- Counselor Notes -->
            @if($submission->counselor_notes)
            <div style="background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(30, 122, 74, 0.04)); border-left: 4px solid var(--green); border-radius: 12px; padding: 1rem;">
                <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--green); margin-bottom: 0.75rem;">
                    <i class="bi bi-person-check-fill me-2"></i>Your Review Notes
                </h6>
                <p style="margin: 0; color: #4b5563; line-height: 1.6; white-space: pre-wrap;">{{ $submission->counselor_notes }}</p>
            </div>
            @endif
        </div>

        <!-- Review Form -->
        @if($submission->status === 'pending')
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">
                <i class="bi bi-clipboard-check me-2"></i>Review This Submission
            </h6>
            
            <form action="{{ route('counselor.student-submissions.review', $submission) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--navy);">
                        <i class="bi bi-check-square me-2"></i>Decision <span class="text-danger">*</span>
                    </label>
                    <div style="display: flex; gap: 1rem;">
                        <div style="flex: 1; padding: 1rem; background: rgba(16, 185, 129, 0.05); border: 2px solid transparent; border-radius: 10px;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="approve" value="approved" required>
                                <label class="form-check-label" for="approve" style="font-weight: 600; color: #10b981; cursor: pointer;">
                                    <i class="bi bi-check-circle me-2"></i>Approve
                                </label>
                            </div>
                        </div>
                        <div style="flex: 1; padding: 1rem; background: rgba(239, 68, 68, 0.05); border: 2px solid transparent; border-radius: 10px;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="reject" value="rejected" required>
                                <label class="form-check-label" for="reject" style="font-weight: 600; color: #ef4444; cursor: pointer;">
                                    <i class="bi bi-x-circle me-2"></i>Reject
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-size: 0.875rem; font-weight: 600; color: var(--navy);">
                        <i class="bi bi-chat-text me-2"></i>Notes <span style="font-size: 0.8rem; font-weight: 400; color: var(--text-muted);">(Optional)</span>
                    </label>
                    <textarea class="form-control" name="counselor_notes" rows="4" 
                              placeholder="Add feedback, suggestions, or notes about this submission..."
                              style="border-radius: 10px;"></textarea>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <div style="padding: 1rem; background: rgba(245, 197, 24, 0.08); border-radius: 10px; border-left: 4px solid #d4a800;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1">
                            <label class="form-check-label" for="is_featured" style="font-size: 0.875rem; color: var(--navy);">
                                <i class="bi bi-star-fill me-2"></i>
                                <strong>Feature this submission</strong>
                                <br>
                                <small class="text-muted">Highlight this as an exemplary work</small>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 0.75rem;">
                    <button type="submit" class="modern-btn modern-btn-primary" style="flex: 1;">
                        <i class="bi bi-check-circle me-2"></i>Submit Review
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div>
        <!-- Quick Stats -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">
                <i class="bi bi-info-circle me-2"></i>Details
            </h6>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; color: var(--text-muted);">Type</span>
                    <strong style="font-size: 0.875rem; color: var(--navy);">{{ $submission->type_label }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; color: var(--text-muted);">Status</span>
                    <strong style="font-size: 0.875rem; color: var(--navy);">{{ ucfirst($submission->status) }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; color: var(--text-muted);">Featured</span>
                    <strong style="font-size: 0.875rem; color: var(--navy);">{{ $submission->is_featured ? 'Yes' : 'No' }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0;">
                    <span style="font-size: 0.875rem; color: var(--text-muted);">Anonymous</span>
                    <strong style="font-size: 0.875rem; color: var(--navy);">{{ $submission->is_anonymous ? 'Yes' : 'No' }}</strong>
                </div>
            </div>
        </div>

        <!-- Actions -->
        @if($submission->status !== 'pending')
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">
                <i class="bi bi-gear me-2"></i>Actions
            </h6>
            <form action="{{ route('counselor.student-submissions.review', $submission) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="is_featured" value="{{ $submission->is_featured ? '0' : '1' }}">
                <input type="hidden" name="status" value="{{ $submission->status }}">
                <button type="submit" class="modern-btn modern-btn-{{ $submission->is_featured ? 'secondary' : 'warning' }}" style="width: 100%; padding: 0.625rem 1rem;">
                    <i class="bi bi-star{{ $submission->is_featured ? '' : '-fill' }} me-2"></i>
                    {{ $submission->is_featured ? 'Unfeature' : 'Feature' }} This
                </button>
            </form>
        </div>
        @endif
    </div>
</div>

@endsection
