@extends('layouts.dashboard')
@section('title', 'Appointment Details')

@section('content')

<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('teacher.appointments.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to My Appointments
        </a>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header d-flex justify-content-between align-items-center py-3 px-4"
                 style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <div>
                    <h5 class="card-title mb-0 fw-bold">Appointment Details</h5>
                    <small class="text-muted">Scheduled on {{ $appointment->created_at->format('M d, Y') }}</small>
                </div>
                @php
                    $badge = match($appointment->status) {
                        'confirmed' => ['bg'=>'#eff6ff','color'=>'#1e40af','border'=>'#93c5fd','label'=>'Confirmed'],
                        'completed' => ['bg'=>'#ecfdf5','color'=>'#065f46','border'=>'#6ee7b7','label'=>'Completed'],
                        'cancelled' => ['bg'=>'#fef2f2','color'=>'#991b1b','border'=>'#fca5a5','label'=>'Cancelled'],
                        default     => ['bg'=>'#fef3c7','color'=>'#92400e','border'=>'#fbbf24','label'=>'Scheduled'],
                    };
                @endphp
                <span class="badge fw-semibold px-3 py-2"
                      style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};border:1px solid {{ $badge['border'] }};font-size:.8rem;">
                    {{ $badge['label'] }}
                </span>
            </div>

            <div class="card-body p-4">

                {{-- Counselor info --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-2">
                                <i class="bi bi-person-badge me-1"></i>Counselor
                            </small>
                            <div class="d-flex align-items-center gap-2">
                                @if($appointment->counselor->profile_photo)
                                    <img src="{{ asset('storage/'.$appointment->counselor->profile_photo) }}"
                                         class="rounded-circle" style="width:36px;height:36px;object-fit:cover;">
                                @else
                                    <div class="user-avatar" style="width:36px;height:36px;font-size:.8rem;">
                                        {{ strtoupper(substr($appointment->counselor->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold small">{{ $appointment->counselor->name }}</div>
                                    <div class="text-muted" style="font-size:.72rem;">Guidance Counselor</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-calendar3 me-1"></i>Date & Time
                            </small>
                            <strong>{{ $appointment->appointment_date->format('l, F d, Y') }}</strong>
                            <div class="text-muted small">{{ $appointment->appointment_date->format('h:i A') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                @if($appointment->notes)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2">
                        <i class="bi bi-chat-left-text me-1"></i>Purpose / Notes
                    </h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $appointment->notes }}</p>
                </div>
                @endif

                {{-- Confirmed notice --}}
                @if($appointment->status === 'confirmed')
                <div class="alert alert-info">
                    <h6 class="alert-heading fw-semibold">
                        <i class="bi bi-check-circle-fill me-1"></i>Appointment Confirmed
                    </h6>
                    <p class="mb-0">Your appointment has been confirmed by the counselor. Please be available at the scheduled time.</p>
                </div>
                @endif

                {{-- Completed notice --}}
                @if($appointment->status === 'completed')
                <div class="alert alert-success">
                    <h6 class="alert-heading fw-semibold">
                        <i class="bi bi-check2-circle me-1"></i>Appointment Completed
                    </h6>
                    <p class="mb-0">This appointment has been marked as completed.</p>
                </div>
                @endif

                {{-- Cancelled notice --}}
                @if($appointment->status === 'cancelled')
                <div class="alert alert-danger">
                    <h6 class="alert-heading fw-semibold">
                        <i class="bi bi-x-circle-fill me-1"></i>Appointment Cancelled
                    </h6>
                    @if($appointment->cancellation_reason)
                        <p class="mb-0"><strong>Reason:</strong> {{ $appointment->cancellation_reason }}</p>
                    @else
                        <p class="mb-0">This appointment has been cancelled.</p>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h6 class="card-title mb-0 fw-bold">Appointment Status</h6>
            </div>
            <div class="card-body px-4 py-3">
                <div class="d-flex flex-column gap-3">

                    {{-- Step 1 --}}
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width:28px;height:28px;min-width:28px;background:{{ in_array($appointment->status, ['scheduled','confirmed','completed']) ? 'linear-gradient(135deg,#20B2AA,#008B8B)' : '#e2e8f0' }};">
                            <i class="bi bi-send-fill" style="font-size:.65rem;color:{{ in_array($appointment->status, ['scheduled','confirmed','completed']) ? '#fff' : '#94a3b8' }};"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color:{{ in_array($appointment->status, ['scheduled','confirmed','completed']) ? '#1e293b' : '#94a3b8' }};">
                                Scheduled
                            </div>
                            <div class="text-muted" style="font-size:.72rem;">{{ $appointment->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                    </div>

                    <div style="width:2px;height:20px;background:{{ in_array($appointment->status, ['confirmed','completed']) ? 'linear-gradient(#20B2AA,#20B2AA)' : '#e2e8f0' }};margin-left:13px;"></div>

                    {{-- Step 2 --}}
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width:28px;height:28px;min-width:28px;background:{{ in_array($appointment->status, ['confirmed','completed']) ? 'linear-gradient(135deg,#20B2AA,#008B8B)' : '#e2e8f0' }};">
                            <i class="bi bi-check-circle-fill" style="font-size:.65rem;color:{{ in_array($appointment->status, ['confirmed','completed']) ? '#fff' : '#94a3b8' }};"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color:{{ in_array($appointment->status, ['confirmed','completed']) ? '#1e293b' : '#94a3b8' }};">
                                Confirmed by Counselor
                            </div>
                            @if($appointment->status === 'cancelled')
                                <div class="text-muted" style="font-size:.72rem;">Not applicable</div>
                            @else
                                <div class="text-muted" style="font-size:.72rem;">
                                    {{ in_array($appointment->status, ['confirmed','completed']) ? 'Counselor confirmed' : 'Awaiting confirmation' }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div style="width:2px;height:20px;background:{{ $appointment->status === 'completed' ? 'linear-gradient(#20B2AA,#20B2AA)' : '#e2e8f0' }};margin-left:13px;"></div>

                    {{-- Step 3 --}}
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                             style="width:28px;height:28px;min-width:28px;background:{{ $appointment->status === 'completed' ? 'linear-gradient(135deg,#059669,#047857)' : ($appointment->status === 'cancelled' ? '#fef2f2' : '#e2e8f0') }};">
                            @if($appointment->status === 'cancelled')
                                <i class="bi bi-x-lg" style="font-size:.65rem;color:#ef4444;"></i>
                            @else
                                <i class="bi bi-check2-all" style="font-size:.65rem;color:{{ $appointment->status === 'completed' ? '#fff' : '#94a3b8' }};"></i>
                            @endif
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color:{{ $appointment->status === 'completed' ? '#059669' : ($appointment->status === 'cancelled' ? '#ef4444' : '#94a3b8') }};">
                                @if($appointment->status === 'cancelled') Cancelled
                                @elseif($appointment->status === 'completed') Completed
                                @else Session Done
                                @endif
                            </div>
                            @if($appointment->status === 'completed')
                                <div class="text-muted" style="font-size:.72rem;">Session finished</div>
                            @elseif($appointment->status === 'cancelled' && $appointment->cancellation_reason)
                                <div class="text-muted" style="font-size:.72rem;">{{ \Str::limit($appointment->cancellation_reason, 35) }}</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Quick info card --}}
        <div class="card border-0 shadow-sm mt-3" style="border-radius:16px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Quick Info</h6>
                <div class="d-flex flex-column gap-3">
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Scheduled On</small>
                        <span class="fw-semibold small">{{ $appointment->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Appointment Date</small>
                        <span class="fw-semibold small">{{ $appointment->appointment_date->format('M d, Y h:i A') }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;">Status</small>
                        <span class="badge fw-semibold"
                              style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};border:1px solid {{ $badge['border'] }};">
                            {{ $badge['label'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
