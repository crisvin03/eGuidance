@extends('layouts.dashboard')

@section('title', 'Browse Counselors')

@section('content')
<!-- Header -->
<div class="mb-4">
    <a href="{{ route('student.connect') }}" class="btn btn-outline-secondary mb-3" style="border-radius:50px;">
        <i class="bi bi-arrow-left me-2"></i>Back to Connect
    </a>
    <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center"
             style="width:48px;height:48px;background:rgba(168,85,247,0.12);">
            <i class="bi bi-people-fill fs-4" style="color:#a855f7;"></i>
        </div>
        <div>
            <h4 class="fw-bold mb-0">Our CARE Team 💜</h4>
            <p class="text-muted small mb-0">Meet the counselors ready to support you</p>
        </div>
    </div>
</div>

<!-- Counselors Grid -->
<div class="row g-4">
    @forelse($counselors as $counselor)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                <div class="card-body p-4 text-center">
                    <!-- Avatar -->
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:80px;height:80px;background:linear-gradient(135deg,rgba(168,85,247,0.15),rgba(168,85,247,0.08));">
                        <i class="bi bi-person-fill" style="font-size:2.5rem;color:#a855f7;"></i>
                    </div>
                    
                    <!-- Info -->
                    <h5 class="fw-bold mb-1">{{ $counselor->name }}</h5>
                    <p class="text-muted small mb-3">Guidance Counselor</p>
                    
                    <!-- Status -->
                    <div class="mb-3">
                        @if($counselor->is_active)
                            <span class="badge bg-success px-3 py-2">
                                <i class="bi bi-circle-fill me-1" style="font-size:.5rem;"></i>Available
                            </span>
                        @else
                            <span class="badge bg-secondary px-3 py-2">Offline</span>
                        @endif
                    </div>
                    
                    <!-- Email (optional) -->
                    @if($counselor->email)
                        <div class="text-muted small mb-3">
                            <i class="bi bi-envelope me-1"></i>{{ $counselor->email }}
                        </div>
                    @endif
                    
                    <!-- Actions -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('student.connect.chat', $counselor->id) }}" 
                           class="btn fw-semibold text-white"
                           style="background:#a855f7;border-radius:50px;">
                            <i class="bi bi-chat-dots me-2"></i>Send Message
                        </a>
                        <a href="{{ route('student.appointments.create') }}?counselor_id={{ $counselor->id }}" 
                           class="btn btn-outline-secondary fw-semibold"
                           style="border-radius:50px;">
                            <i class="bi bi-calendar-plus me-2"></i>Book Session
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:16px;">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox fs-1" style="color:#a855f7;opacity:0.3;"></i>
                    <h5 class="fw-bold mt-3 mb-2">No counselors available</h5>
                    <p class="text-muted">Please check back later or contact the guidance office.</p>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
