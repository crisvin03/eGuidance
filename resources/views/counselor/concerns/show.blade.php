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
        @if(!in_array($concern->status, ['resolved', 'scheduled']))
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0"><i class="bi bi-reply me-1"></i>Respond to Concern</h6>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <form method="POST" action="{{ route('counselor.concerns.respond', $concern) }}">
                    @csrf
                    <input type="hidden" name="status" value="scheduled">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Counseling Date & Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('counseling_date') is-invalid @enderror"
                               name="counseling_date" value="{{ old('counseling_date') }}"
                               min="{{ now()->format('Y-m-d\TH:i') }}" required>
                        @error('counseling_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Response <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('response') is-invalid @enderror"
                                  name="response" rows="4" required
                                  placeholder="Write your response to the student...">{{ old('response') }}</textarea>
                        @error('response')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send me-1"></i> Submit Response
                    </button>
                </form>
            </div>
        </div>
        @endif

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
