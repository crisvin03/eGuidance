@extends('layouts.dashboard')

@section('title', 'Concern Details')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns: 1fr 380px"] { display: block !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    .modern-btn { width: 100% !important; justify-content: center !important; }
    div[style*="display: flex"][style*="gap"] { flex-direction: column !important; }
    .row.g-3 { gap: 0.5rem !important; }
    .col-md-6, .col-md-4, .col-md-3, .col-12 { width: 100% !important; max-width: 100% !important; }
    h1[style*="font-size: 1.5rem"] { font-size: 1.25rem !important; }
    h6.fw-bold { font-size: 0.95rem !important; }
    .user-avatar { width: 32px !important; height: 32px !important; font-size: 0.75rem !important; }
    textarea.form-control { font-size: 0.875rem !important; }
    .badge { font-size: 0.75rem !important; }
}
</style>

<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('counselor.concerns.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
        <i class="bi bi-arrow-left"></i> Back to Student Concerns
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 1.5rem;">
    <!-- Main Content -->
    <div>
        <!-- Concern Details Card -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 2px solid #e5e7eb;">
                <div>
                    <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--navy); margin: 0 0 0.5rem 0;">{{ $concern->title }}</h1>
                    <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                        @if($concern->status == 'resolved')
                            <span class="modern-badge modern-badge-success"><i class="bi bi-check-circle-fill"></i> Resolved</span>
                        @elseif($concern->status == 'scheduled')
                            <span class="modern-badge modern-badge-info"><i class="bi bi-calendar-check"></i> Scheduled</span>
                        @elseif($concern->status == 'under_review')
                            <span class="modern-badge modern-badge-warning"><i class="bi bi-eye-fill"></i> Under Review</span>
                        @else
                            <span class="modern-badge modern-badge-secondary"><i class="bi bi-clock-fill"></i> Pending</span>
                        @endif
                        
                        <span class="modern-badge modern-badge-info"><i class="bi bi-tag-fill"></i> {{ $concern->category->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Info Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: #f9fafb; border-radius: 12px; padding: 1rem;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Student</div>
                    @if($concern->is_anonymous)
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div class="modern-section-icon" style="width: 36px; height: 36px; background: rgba(107, 114, 128, 0.1); color: #6b7280; font-size: 0.9rem;">
                                <i class="bi bi-incognito"></i>
                            </div>
                            <span style="color: var(--text-muted); font-style: italic;">Anonymous</span>
                        </div>
                    @else
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div class="modern-section-icon" style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; font-size: 0.8rem; font-weight: 700;">
                                {{ strtoupper(substr($concern->student->name, 0, 2)) }}
                            </div>
                            <strong style="color: var(--navy);">{{ $concern->student->name }}</strong>
                        </div>
                    @endif
                </div>

                <div style="background: #f9fafb; border-radius: 12px; padding: 1rem;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">
                        <i class="bi bi-calendar"></i> Submitted
                    </div>
                    <strong style="color: var(--navy);">{{ $concern->created_at->format('M d, Y h:i A') }}</strong>
                </div>

                @if($concern->counseling_date)
                <div style="background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(30, 122, 74, 0.04)); border: 1px solid rgba(30, 122, 74, 0.2); border-radius: 12px; padding: 1rem; grid-column: 1 / -1;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: var(--green); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">
                        <i class="bi bi-calendar-check"></i> Counseling Scheduled
                    </div>
                    <strong style="color: var(--navy); font-size: 1.1rem;">{{ $concern->counseling_date->format('M d, Y h:i A') }}</strong>
                </div>
                @endif
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.5rem;">
                <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">
                    <i class="bi bi-text-paragraph me-2"></i>Description
                </h6>
                <p style="margin: 0; color: #4b5563; line-height: 1.6; white-space: pre-wrap;">{{ $concern->description }}</p>
            </div>

            <!-- Student Attachment -->
            @if($concern->attachment_path)
            <div style="margin-bottom: 1.5rem;">
                <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">
                    <i class="bi bi-paperclip me-2"></i>Student Attachment
                </h6>
                @php
                    $ext = strtolower(pathinfo($concern->attachment_name ?? $concern->attachment_path, PATHINFO_EXTENSION));
                    $isImage = in_array($ext, ['jpg','jpeg','png','gif']);
                @endphp
                @if($isImage)
                    <div style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 1rem; background: #f9fafb; display: inline-block;">
                        <img src="{{ asset('storage/' . $concern->attachment_path) }}"
                             alt="Student attachment"
                             style="max-height: 350px; max-width: 100%; border-radius: 8px;">
                    </div>
                    <div style="margin-top: 0.75rem; display: flex; gap: 0.5rem;">
                        <a href="{{ asset('storage/' . $concern->attachment_path) }}" target="_blank" class="modern-btn modern-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="bi bi-box-arrow-up-right"></i> Open Full Image
                        </a>
                        <a href="{{ asset('storage/' . $concern->attachment_path) }}" download="{{ $concern->attachment_name }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="bi bi-download"></i> Download
                        </a>
                    </div>
                @else
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border: 2px solid #e5e7eb; border-radius: 12px; background: #f9fafb;">
                        <i class="bi bi-file-earmark-text" style="font-size: 2.5rem; color: var(--green);"></i>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: var(--navy);">{{ $concern->attachment_name ?? 'Attachment' }}</div>
                            <small style="color: var(--text-muted); text-transform: uppercase;">{{ strtoupper($ext) }} file</small>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ asset('storage/' . $concern->attachment_path) }}" target="_blank" class="modern-btn modern-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                <i class="bi bi-box-arrow-up-right"></i> View
                            </a>
                            <a href="{{ asset('storage/' . $concern->attachment_path) }}" download="{{ $concern->attachment_name }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            @endif

            <!-- Counselor Response -->
            @if($concern->counselor_response)
            <div style="background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(30, 122, 74, 0.04)); border-left: 4px solid var(--green); border-radius: 12px; padding: 1rem;">
                <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--green); margin-bottom: 0.75rem;">
                    <i class="bi bi-person-check-fill me-2"></i>Your Response
                </h6>
                <p style="margin: 0; color: #4b5563; line-height: 1.6; white-space: pre-wrap;">{{ $concern->counselor_response }}</p>
            </div>
            @endif
        </div>

        <!-- Session Notes Timeline -->
        <div class="modern-card" style="padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--navy); margin: 0;">
                    <i class="bi bi-journal-medical me-2"></i>Session Notes
                </h2>
                <button type="button" class="modern-btn modern-btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal" style="padding: 0.625rem 1rem; font-size: 0.875rem;">
                    <i class="bi bi-plus-circle"></i> Add Note
                </button>
            </div>

            @if($concern->sessionNotes->isEmpty())
                <div class="modern-empty-state" style="padding: 2rem 1rem;">
                    <div class="modern-empty-icon" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="bi bi-journal-x"></i>
                    </div>
                    <h3 class="modern-empty-title" style="font-size: 1rem;">No session notes yet</h3>
                    <p class="modern-empty-text" style="font-size: 0.875rem;">Click "Add Note" to create the first one</p>
                </div>
            @else
                <div class="timeline">
                    @foreach($concern->sessionNotes as $note)
                    <div class="timeline-item" style="position: relative; padding-left: 30px; padding-bottom: 1.5rem;">
                        <div class="timeline-marker" style="position: absolute; left: 0; top: 4px; width: 12px; height: 12px; border-radius: 50%; background: var(--green); border: 3px solid #e5e7eb;"></div>
                        <div class="timeline-content" style="background: #f9fafb; border-radius: 12px; padding: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                                <div>
                                    @if($note->title)
                                        <h6 style="font-weight: 700; color: var(--navy); margin: 0 0 0.25rem 0;">{{ $note->title }}</h6>
                                    @endif
                                    <small style="color: var(--text-muted); font-size: 0.8rem;">
                                        <i class="bi bi-person-circle"></i> {{ $note->counselor->name }}
                                        <span style="margin: 0 0.5rem;">•</span>
                                        <i class="bi bi-calendar3"></i> {{ $note->created_at->format('M d, Y h:i A') }}
                                    </small>
                                </div>
                                <span class="modern-badge modern-badge-{{ $note->session_type == 'crisis' ? 'danger' : ($note->session_type == 'initial' ? 'info' : 'secondary') }}" style="font-size: 0.75rem;">
                                    {{ ucfirst(str_replace('_', ' ', $note->session_type)) }}
                                </span>
                            </div>
                            
                            <div style="margin-bottom: 0.75rem; color: #4b5563; line-height: 1.6; white-space: pre-wrap;">{{ $note->notes }}</div>
                            
                            @if($note->recommendations)
                            <div style="background: rgba(234, 179, 8, 0.1); border-left: 3px solid #eab308; border-radius: 8px; padding: 0.75rem; margin-bottom: 0.75rem;">
                                <strong style="color: #ca8a04; font-size: 0.875rem;"><i class="bi bi-lightbulb"></i> Recommendations:</strong>
                                <div style="color: #4b5563; font-size: 0.875rem; margin-top: 0.25rem;">{{ $note->recommendations }}</div>
                            </div>
                            @endif
                            
                            @if($note->follow_up_date)
                            <div style="color: var(--text-muted); font-size: 0.8rem;">
                                <i class="bi bi-calendar-check"></i> Follow-up: {{ $note->follow_up_date->format('M d, Y') }}
                            </div>
                            @endif
                            
                            @if($note->is_confidential)
                            <div style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">
                                <i class="bi bi-shield-lock-fill"></i> Confidential
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Update Form -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 0 0 1rem 0;">
                <i class="bi bi-reply me-2"></i>Update Concern
            </h6>
            
            <form method="POST" action="{{ route('counselor.concerns.update', $concern) }}">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                        Status <span style="color: #ef4444;">*</span>
                    </label>
                    <select class="form-select @error('status') is-invalid @enderror" name="status" id="concernStatus" required onchange="toggleScheduling()" style="border-radius: 10px;">
                        <option value="submitted" {{ $concern->status == 'submitted' ? 'selected' : '' }}>Submitted (Pending)</option>
                        <option value="scheduled" {{ $concern->status == 'scheduled' ? 'selected' : '' }}>Schedule for Appointment</option>
                        <option value="resolved" {{ $concern->status == 'resolved' ? 'selected' : '' }}>Resolved (No Appointment Needed)</option>
                    </select>
                    @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    <small style="color: var(--text-muted); font-size: 0.75rem;">Not all concerns require an appointment</small>
                </div>
                
                <div style="margin-bottom: 1rem; display: {{ $concern->status == 'scheduled' ? 'block' : 'none' }};" id="schedulingSection">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                        Counseling Date & Time
                    </label>
                    <input type="datetime-local" class="form-control @error('counseling_date') is-invalid @enderror"
                           name="counseling_date" value="{{ $concern->counseling_date ? $concern->counseling_date->format('Y-m-d\TH:i') : old('counseling_date') }}"
                           min="{{ now()->format('Y-m-d\TH:i') }}" style="border-radius: 10px;">
                    @error('counseling_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    <small style="color: var(--text-muted); font-size: 0.75rem;">Required only if scheduling for appointment</small>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                        Counselor Response <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea class="form-control @error('counselor_response') is-invalid @enderror"
                              name="counselor_response" rows="5" required
                              placeholder="Write or edit your response to the student..." style="border-radius: 10px;">{{ old('counselor_response', $concern->counselor_response) }}</textarea>
                    @error('counselor_response')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    <small style="color: var(--text-muted); font-size: 0.75rem;">You can edit your response anytime</small>
                </div>
                
                <button type="submit" class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.95rem;">
                    <i class="bi bi-check-circle"></i> Update Concern
                </button>
            </form>
        </div>

        <!-- Timeline -->
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 0 0 1rem 0;">
                Concern Timeline
            </h6>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-circle-fill" style="color: var(--green); font-size: 0.5rem;"></i>
                    <small style="font-weight: 600; color: var(--navy); font-size: 0.85rem;">Submitted — {{ $concern->created_at->format('M d, Y') }}</small>
                </div>
                @if(in_array($concern->status, ['under_review','scheduled','resolved']))
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-circle-fill" style="color: var(--green); font-size: 0.5rem;"></i>
                    <small style="font-weight: 600; color: var(--navy); font-size: 0.85rem;">Under Review</small>
                </div>
                @endif
                @if(in_array($concern->status, ['scheduled','resolved']) && $concern->counseling_date)
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-circle-fill" style="color: var(--green); font-size: 0.5rem;"></i>
                    <small style="font-weight: 600; color: var(--navy); font-size: 0.85rem;">Scheduled — {{ $concern->counseling_date->format('M d, Y') }}</small>
                </div>
                @endif
                @if($concern->status == 'resolved')
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-circle-fill" style="color: #22c55e; font-size: 0.5rem;"></i>
                    <small style="font-weight: 600; color: #22c55e; font-size: 0.85rem;">Resolved — {{ $concern->resolved_at?->format('M d, Y') ?? 'Now' }}</small>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Session Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem;">
                <h5 class="modal-title" style="font-weight: 700; color: var(--navy);">
                    <i class="bi bi-journal-plus me-2"></i>Add Session Note
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('counselor.concerns.add-note', $concern) }}">
                @csrf
                <div class="modal-body" style="padding: 1.5rem;">
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                            Note Title <small style="color: var(--text-muted);">(Optional)</small>
                        </label>
                        <input type="text" class="form-control" name="title" placeholder="e.g., Initial Assessment, Follow-up Session" style="border-radius: 10px;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                            Session Type <span style="color: #ef4444;">*</span>
                        </label>
                        <select class="form-select" name="session_type" required style="border-radius: 10px;">
                            <option value="initial">Initial Session</option>
                            <option value="follow_up">Follow-up Session</option>
                            <option value="crisis">Crisis Intervention</option>
                            <option value="group">Group Session</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                            Session Notes <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea class="form-control" name="notes" rows="6" required placeholder="Document what was discussed, observations, progress, etc." style="border-radius: 10px;"></textarea>
                        <small style="color: var(--text-muted); font-size: 0.75rem;">These notes will be appended to the timeline</small>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                            Recommendations <small style="color: var(--text-muted);">(Optional)</small>
                        </label>
                        <textarea class="form-control" name="recommendations" rows="3" placeholder="Next steps, suggested interventions, referrals, etc." style="border-radius: 10px;"></textarea>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">
                            Follow-up Date <small style="color: var(--text-muted);">(Optional)</small>
                        </label>
                        <input type="date" class="form-control" name="follow_up_date" min="{{ now()->format('Y-m-d') }}" style="border-radius: 10px;">
                    </div>

                    <div class="form-check" style="padding-left: 1.5rem;">
                        <input class="form-check-input" type="checkbox" name="is_confidential" id="isConfidential" value="1" checked>
                        <label class="form-check-label" for="isConfidential" style="font-size: 0.9rem;">
                            <i class="bi bi-shield-lock-fill text-danger"></i> Mark as Confidential
                        </label>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 1.5rem;">
                    <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal" style="padding: 0.625rem 1.25rem;">
                        Cancel
                    </button>
                    <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem;">
                        <i class="bi bi-check-circle"></i> Add Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleScheduling() {
    const status = document.getElementById('concernStatus').value;
    const schedulingSection = document.getElementById('schedulingSection');
    const dateInput = document.querySelector('input[name="counseling_date"]');
    
    if (status === 'scheduled') {
        schedulingSection.style.display = 'block';
        dateInput.required = true;
    } else {
        schedulingSection.style.display = 'none';
        dateInput.required = false;
    }
}
</script>

<style>
.timeline::before {
    content: '';
    position: absolute;
    left: 5px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e5e7eb;
}

@media (max-width: 1024px) {
    div[style*="grid-template-columns: 1fr 380px"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
