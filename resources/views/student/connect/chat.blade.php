@extends('layouts.dashboard')

@section('title', 'Chat with ' . $user->name)

@section('content')
<!-- Header -->
<div class="mb-4">
    <a href="{{ route('student.connect') }}" class="btn btn-outline-secondary mb-3" style="border-radius:50px;">
        <i class="bi bi-arrow-left me-2"></i>Back to Connect
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Chat Card -->
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <!-- Chat Header -->
            <div class="card-header bg-white border-0 p-4" style="border-radius:16px 16px 0 0;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;background:rgba(168,85,247,0.12);">
                        <i class="bi bi-person-fill fs-4" style="color:#a855f7;"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">{{ $user->name }}</h6>
                        <small class="text-muted">{{ ucfirst($user->role->name) }}</small>
                    </div>
                </div>
            </div>

            <!-- Chat Body -->
            <div class="card-body p-4" style="min-height:400px;max-height:500px;overflow-y:auto;">
                <!-- Coming Soon Notice -->
                <div class="alert border-0 text-center" 
                     style="background:rgba(168,85,247,0.08);border-radius:12px;">
                    <div class="mb-3">
                        <i class="bi bi-chat-dots fs-1" style="color:#a855f7;"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Direct Messaging Coming Soon! 💬</h6>
                    <p class="text-muted small mb-3">
                        Real-time chat is currently under development. In the meantime, you can:
                    </p>
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="{{ route('student.spill-tea') }}" 
                           class="btn btn-sm fw-semibold text-white"
                           style="background:#ec4899;border-radius:50px;">
                            <i class="bi bi-chat-heart me-1"></i>Share a Concern
                        </a>
                        <a href="{{ route('student.appointments.create') }}" 
                           class="btn btn-sm btn-outline-secondary fw-semibold"
                           style="border-radius:50px;">
                            <i class="bi bi-calendar-plus me-1"></i>Book Session
                        </a>
                    </div>
                </div>

                <!-- Placeholder for future messages -->
                <div class="text-center text-muted mt-4">
                    <small>
                        <i class="bi bi-lock me-1"></i>
                        All messages are confidential and secure
                    </small>
                </div>
            </div>

            <!-- Chat Footer (Disabled) -->
            <div class="card-footer bg-white border-0 p-4" style="border-radius:0 0 16px 16px;">
                <form class="d-flex gap-2">
                    <input type="text" class="form-control" placeholder="Type your message..." 
                           disabled style="border-radius:50px;">
                    <button type="submit" class="btn btn-primary" disabled style="border-radius:50px;padding:0 1.5rem;">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
                <small class="text-muted d-block mt-2 text-center">
                    <i class="bi bi-info-circle me-1"></i>
                    Messaging will be available soon. Use the alternatives above for now.
                </small>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4 mt-4 mt-lg-0">
        <!-- User Info -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius:16px;">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                     style="width:80px;height:80px;background:linear-gradient(135deg,rgba(168,85,247,0.15),rgba(168,85,247,0.08));">
                    <i class="bi bi-person-fill" style="font-size:2.5rem;color:#a855f7;"></i>
                </div>
                <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
                <p class="text-muted small mb-3">{{ ucfirst($user->role->name) }}</p>
                @if($user->email)
                    <small class="text-muted d-block mb-3">
                        <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                    </small>
                @endif
                <a href="{{ route('student.appointments.create') }}" 
                   class="btn w-100 fw-semibold text-white"
                   style="background:#a855f7;border-radius:50px;">
                    <i class="bi bi-calendar-plus me-2"></i>Book Session
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('student.spill-tea') }}" 
                       class="btn btn-outline-secondary text-start"
                       style="border-radius:12px;">
                        <i class="bi bi-chat-heart me-2" style="color:#ec4899;"></i>
                        Share a Concern
                    </a>
                    <a href="{{ route('student.mind-check') }}" 
                       class="btn btn-outline-secondary text-start"
                       style="border-radius:12px;">
                        <i class="bi bi-heart-pulse me-2" style="color:#ef4444;"></i>
                        Take Mind Check
                    </a>
                    <a href="{{ route('student.connect.counselors') }}" 
                       class="btn btn-outline-secondary text-start"
                       style="border-radius:12px;">
                        <i class="bi bi-people me-2" style="color:#a855f7;"></i>
                        View All Counselors
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
