@extends('layouts.dashboard')

@section('title', 'Concern Details')

@section('content')
<!-- Back Button -->
<div class="mb-3">
    <a href="{{ route('student.concerns.index') }}" class="btn btn-outline-secondary" style="border-radius:50px;">
        <i class="bi bi-arrow-left me-2"></i>Back to My Concerns
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Main Concern Card -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
            <div class="card-body p-4">
                <!-- Status Badge -->
                <div class="mb-3">
                    @if($concern->status == 'resolved')
                        <span class="badge bg-success px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i>Resolved
                        </span>
                    @elseif($concern->status == 'scheduled')
                        <span class="badge bg-info px-3 py-2">
                            <i class="bi bi-calendar-check me-1"></i>Scheduled
                        </span>
                    @elseif($concern->status == 'under_review')
                        <span class="badge bg-primary px-3 py-2">
                            <i class="bi bi-eye me-1"></i>Under Review
                        </span>
                    @else
                        <span class="badge bg-warning px-3 py-2">
                            <i class="bi bi-hourglass-split me-1"></i>Pending
                        </span>
                    @endif
                </div>

                <!-- Title -->
                <h4 class="fw-bold mb-3">{{ $concern->title }}</h4>

                <!-- Meta Info -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background:rgba(236,72,153,0.05);">
                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-tag me-1" style="color:#ec4899;"></i>Category
                            </small>
                            <span class="badge" style="background:rgba(59,130,246,0.12);color:#3b82f6;">
                                {{ $concern->category->name }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background:rgba(236,72,153,0.05);">
                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-calendar me-1" style="color:#ec4899;"></i>Submitted
                            </small>
                            <strong>{{ $concern->created_at->format('M d, Y') }}</strong>
                            <small class="text-muted d-block">{{ $concern->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @if($concern->is_anonymous)
                    <div class="col-12">
                        <div class="p-3 rounded" style="background:rgba(100,116,139,0.08);">
                            <i class="bi bi-incognito me-2" style="color:#64748b;"></i>
                            <span class="fw-semibold">This was submitted anonymously</span>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-chat-left-quote me-2" style="color:#ec4899;"></i>What you shared
                    </h6>
                    <p class="mb-0" style="white-space:pre-wrap;line-height:1.7;">{{ $concern->description }}</p>
                </div>

                <!-- Attachment -->
                @if($concern->attachment_path)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-paperclip me-2" style="color:#ec4899;"></i>Attachment
                    </h6>
                    @php
                        $ext = strtolower(pathinfo($concern->attachment_name ?? $concern->attachment_path, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg','jpeg','png','gif']);
                    @endphp
                    @if($isImage)
                        <img src="{{ asset('storage/' . $concern->attachment_path) }}"
                             alt="Attachment" class="img-fluid rounded shadow-sm" style="max-height:400px;border-radius:12px;">
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $concern->attachment_path) }}" target="_blank" 
                               class="btn btn-outline-secondary" style="border-radius:50px;">
                                <i class="bi bi-box-arrow-up-right me-2"></i>Open Full Size
                            </a>
                        </div>
                    @else
                        <a href="{{ asset('storage/' . $concern->attachment_path) }}" target="_blank" 
                           class="btn btn-outline-secondary" style="border-radius:50px;">
                            <i class="bi bi-file-earmark-arrow-down me-2"></i>
                            {{ $concern->attachment_name ?? 'Download Attachment' }}
                        </a>
                    @endif
                </div>
                @endif

                <!-- Counselor Response -->
                @if($concern->counselor_response)
                <div class="alert border-0" style="background:linear-gradient(135deg,rgba(32,178,170,0.08),rgba(0,139,139,0.04));border-radius:12px;">
                    <div class="d-flex align-items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:40px;height:40px;background:rgba(32,178,170,0.15);">
                                <i class="bi bi-chat-dots-fill" style="color:#20B2AA;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold mb-2" style="color:#20B2AA;">
                                <i class="bi bi-person-badge me-1"></i>Counselor's Response
                            </h6>
                            <p class="mb-0" style="white-space:pre-wrap;">{{ $concern->counselor_response }}</p>
                            @if($concern->counselor_response_at)
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-clock me-1"></i>{{ $concern->counselor_response_at->diffForHumans() }}
                            </small>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Related Appointments -->
        @if($concern->appointments && $concern->appointments->count() > 0)
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-calendar3 me-2" style="color:#a855f7;"></i>Related Sessions
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                @foreach($concern->appointments as $appointment)
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <div class="fw-semibold">{{ $appointment->counselor->name }}</div>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $appointment->appointment_date->format('M d, Y \a\t h:i A') }}
                            </small>
                        </div>
                        @if($appointment->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                        @elseif($appointment->status == 'confirmed')
                            <span class="badge bg-info">Confirmed</span>
                        @else
                            <span class="badge bg-warning">Scheduled</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Status Timeline -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-2" style="color:#ec4899;"></i>Timeline
                </h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="d-flex gap-3 mb-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center"
                             style="width:32px;height:32px;">
                            <i class="bi bi-check text-white" style="font-size:.9rem;"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold small">Submitted</div>
                        <small class="text-muted">{{ $concern->created_at->format('M d, Y') }}</small>
                    </div>
                </div>

                @if($concern->status != 'submitted')
                <div class="d-flex gap-3 mb-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                             style="width:32px;height:32px;">
                            <i class="bi bi-eye text-white" style="font-size:.9rem;"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold small">Reviewed</div>
                        <small class="text-muted">By our CARE Team</small>
                    </div>
                </div>
                @endif

                @if(in_array($concern->status, ['scheduled', 'resolved']))
                <div class="d-flex gap-3 mb-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle bg-info d-flex align-items-center justify-content-center"
                             style="width:32px;height:32px;">
                            <i class="bi bi-calendar-check text-white" style="font-size:.9rem;"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold small">Session Scheduled</div>
                        <small class="text-muted">Counselor ready to help</small>
                    </div>
                </div>
                @endif

                @if($concern->status == 'resolved')
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center"
                             style="width:32px;height:32px;">
                            <i class="bi bi-check-circle text-white" style="font-size:.9rem;"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold small">Resolved</div>
                        <small class="text-muted">All done! 🎉</small>
                    </div>
                </div>
                @else
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:32px;height:32px;background:rgba(236,72,153,0.15);">
                            <div class="spinner-border spinner-border-sm" style="color:#ec4899;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold small">In Progress...</div>
                        <small class="text-muted">We're working on it</small>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Need Help -->
        <div class="card border-0 shadow-sm" style="border-radius:16px;background:linear-gradient(135deg,rgba(168,85,247,0.08),rgba(168,85,247,0.04));">
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-people fs-2" style="color:#a855f7;"></i>
                </div>
                <h6 class="fw-bold mb-2">Need to talk now?</h6>
                <p class="text-muted small mb-3">
                    Connect directly with a counselor for immediate support.
                </p>
                <a href="{{ route('student.connect') }}" class="btn w-100 fw-semibold text-white"
                   style="background:#a855f7;border-radius:50px;">
                    <i class="bi bi-chat-dots me-2"></i>Connect with Ate/Kuya
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
