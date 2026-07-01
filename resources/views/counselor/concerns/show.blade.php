@extends('layouts.dashboard')

@section('title', 'Concern Details')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('counselor.concerns.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Student Concerns
        </a>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ $concern->title }}</h5>
                @if($concern->status == 'resolved')
                    <span class="badge badge-success">Resolved</span>
                @elseif($concern->status == 'scheduled')
                    <span class="badge badge-info">Scheduled</span>
                @elseif($concern->status == 'under_review')
                    <span class="badge badge-warning">Under Review</span>
                @else
                    <span class="badge badge-warning">Pending</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">Student</small>
                            @if($concern->is_anonymous)
                                <span><i class="bi bi-incognito me-1"></i><em class="text-muted">Anonymous</em></span>
                            @else
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar">{{ strtoupper(substr($concern->student->name, 0, 2)) }}</div>
                                    <strong>{{ $concern->student->name }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-tag me-1"></i>Category</small>
                            <span class="badge bg-info">{{ $concern->category->name }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-calendar me-1"></i>Submitted</small>
                            <strong>{{ $concern->created_at->format('M d, Y h:i A') }}</strong>
                        </div>
                    </div>
                    @if($concern->counseling_date)
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background:#fffbeb; border:1px solid #fbbf24;">
                            <small class="text-muted d-block mb-1"><i class="bi bi-calendar-check me-1"></i>Counseling Scheduled</small>
                            <strong>{{ $concern->counseling_date->format('M d, Y h:i A') }}</strong>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-text-paragraph me-1"></i>Description</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $concern->description }}</p>
                </div>

                {{-- Attachment uploaded by student --}}
                @if($concern->attachment_path)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-paperclip me-1"></i>Student Attachment</h6>
                    @php
                        $ext = strtolower(pathinfo($concern->attachment_name ?? $concern->attachment_path, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg','jpeg','png','gif']);
                    @endphp
                    @if($isImage)
                        <div class="border rounded p-2 d-inline-block bg-light">
                            <img src="{{ asset('storage/' . $concern->attachment_path) }}"
                                 alt="Student attachment"
                                 class="img-fluid rounded"
                                 style="max-height:350px; max-width:100%;">
                        </div>
                        <div class="mt-2 d-flex gap-2">
                            <a href="{{ asset('storage/' . $concern->attachment_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Open Full Image
                            </a>
                            <a href="{{ asset('storage/' . $concern->attachment_path) }}" download="{{ $concern->attachment_name }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-download me-1"></i>Download
                            </a>
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-3 p-3 border rounded bg-light">
                            <i class="bi bi-file-earmark-text" style="font-size:2rem; color:#6366f1;"></i>
                            <div>
                                <div class="fw-semibold">{{ $concern->attachment_name ?? 'Attachment' }}</div>
                                <small class="text-muted text-uppercase">{{ strtoupper($ext) }} file</small>
                            </div>
                            <div class="ms-auto d-flex gap-2">
                                <a href="{{ asset('storage/' . $concern->attachment_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>View
                                </a>
                                <a href="{{ asset('storage/' . $concern->attachment_path) }}" download="{{ $concern->attachment_name }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-download me-1"></i>Download
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                @endif

                @if($concern->counselor_response)
                <div class="alert alert-info">
                    <h6 class="alert-heading fw-semibold"><i class="bi bi-person-check-fill me-1"></i>Your Response</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $concern->counselor_response }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0"><i class="bi bi-reply me-1"></i>Update Concern</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('counselor.concerns.update', $concern) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="concernStatus" required onchange="toggleScheduling()">
                            <option value="submitted" {{ $concern->status == 'submitted' ? 'selected' : '' }}>Submitted (Pending)</option>
                            <option value="scheduled" {{ $concern->status == 'scheduled' ? 'selected' : '' }}>Schedule for Appointment</option>
                            <option value="resolved" {{ $concern->status == 'resolved' ? 'selected' : '' }}>Resolved (No Appointment Needed)</option>
                        </select>
                        @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        <small class="text-muted">Not all concerns require an appointment. You can resolve directly if appropriate.</small>
                    </div>
                    
                    <div class="mb-3" id="schedulingSection" style="display:{{ $concern->status == 'scheduled' ? 'block' : 'none' }};">
                        <label class="form-label fw-semibold">Counseling Date & Time</label>
                        <input type="datetime-local" class="form-control @error('counseling_date') is-invalid @enderror"
                               name="counseling_date" value="{{ $concern->counseling_date ? $concern->counseling_date->format('Y-m-d\TH:i') : old('counseling_date') }}"
                               min="{{ now()->format('Y-m-d\TH:i') }}">
                        @error('counseling_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        <small class="text-muted">Required only if scheduling for appointment</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Counselor Response <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('counselor_response') is-invalid @enderror"
                                  name="counselor_response" rows="4" required
                                  placeholder="Write or edit your response to the student...">{{ old('counselor_response', $concern->counselor_response) }}</textarea>
                        @error('counselor_response')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        <small class="text-muted">You can edit your response anytime</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-1"></i> Update Concern
                    </button>
                </form>
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

        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Concern Timeline</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-circle-fill" style="color:#20B2AA; font-size:.5rem;"></i>
                        <small class="fw-semibold">Submitted — {{ $concern->created_at->format('M d, Y') }}</small>
                    </div>
                    @if(in_array($concern->status, ['under_review','scheduled','resolved']))
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-circle-fill" style="color:#20B2AA; font-size:.5rem;"></i>
                        <small class="fw-semibold">Under Review</small>
                    </div>
                    @endif
                    @if(in_array($concern->status, ['scheduled','resolved']) && $concern->counseling_date)
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-circle-fill" style="color:#20B2AA; font-size:.5rem;"></i>
                        <small class="fw-semibold">Scheduled — {{ $concern->counseling_date->format('M d, Y') }}</small>
                    </div>
                    @endif
                    @if($concern->status == 'resolved')
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-circle-fill" style="color:#22c55e; font-size:.5rem;"></i>
                        <small class="fw-semibold text-success">Resolved — {{ $concern->resolved_at?->format('M d, Y') }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
