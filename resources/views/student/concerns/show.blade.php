@extends('layouts.dashboard')

@section('title', 'Concern Details')

@section('content')
@include('student.partials.modern-styles')

<div class="row">
    <div class="col-md-8 d-flex flex-column" style="gap: 1rem;">
        <div class="modern-card flex-grow-1" style="padding: 1.5rem;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold mb-0" style="font-size: 1.15rem;">{{ $concern->title }}</h5>
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
                <div class="row g-3 mb-4">
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
                    @if($concern->is_anonymous)
                    <div class="col-12">
                        <div class="p-3 bg-light rounded">
                            <span class="badge bg-secondary"><i class="bi bi-incognito me-1"></i>Submitted Anonymously</span>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-text-paragraph me-1"></i>Description</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $concern->description }}</p>
                </div>

                @if($concern->attachment_path)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-paperclip me-1"></i>Attachment</h6>
                    @php
                        $ext = strtolower(pathinfo($concern->attachment_name ?? $concern->attachment_path, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg','jpeg','png','gif']);
                    @endphp
                    @if($isImage)
                        <img src="{{ asset('storage/' . $concern->attachment_path) }}"
                             alt="Attachment" class="img-fluid rounded" style="max-height:300px;">
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $concern->attachment_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Open Full Image
                            </a>
                        </div>
                    @else
                        <a href="{{ asset('storage/' . $concern->attachment_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-file-earmark-arrow-down me-1"></i>
                            {{ $concern->attachment_name ?? 'Download Attachment' }}
                        </a>
                    @endif
                </div>
                @endif

                @if($concern->counselor_response)
                <div class="alert alert-info">
                    <h6 class="alert-heading fw-semibold"><i class="bi bi-person-check-fill me-1"></i>Counselor Response</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $concern->counselor_response }}</p>
                </div>
                @endif

                @if($concern->status == 'scheduled' && $concern->counseling_date)
                <div class="alert alert-warning">
                    <h6 class="alert-heading fw-semibold"><i class="bi bi-calendar-check me-1"></i>Counseling Session Scheduled</h6>
                    <strong>{{ $concern->counseling_date->format('l, F d, Y h:i A') }}</strong>
                </div>
                @endif

                @if($concern->resolved_at)
                <div class="text-success mt-2">
                    <small><i class="bi bi-check-circle-fill me-1"></i>Resolved on {{ $concern->resolved_at->format('F d, Y h:i A') }}</small>
                </div>
                @endif
        </div>

        @if($concern->appointments && $concern->appointments->count() > 0)
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 class="fw-semibold mb-3" style="font-size: 1rem;"><i class="bi bi-calendar-event me-1"></i>Related Appointments</h6>
            <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($concern->appointments as $appt)
                            <tr>
                                <td>{{ $appt->appointment_date->format('M d, Y h:i A') }}</td>
                                <td>
                                    @if($appt->status == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @elseif($appt->status == 'cancelled')
                                        <span class="badge badge-danger">Cancelled</span>
                                    @elseif($appt->status == 'confirmed')
                                        <span class="badge badge-info">Confirmed</span>
                                    @else
                                        <span class="badge badge-warning">Scheduled</span>
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $appt->notes ?? '-' }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
        @endif
    </div>

    <div class="col-md-4 d-flex flex-column" style="gap: 1rem;">
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 class="fw-semibold mb-3" style="font-size: 1rem;">Concern Status</h6>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-circle-fill" style="color:{{ in_array($concern->status, ['submitted','under_review','scheduled','resolved']) ? '#1e7a4a' : '#cbd5e1' }}; font-size:.5rem;"></i>
                    <small class="{{ in_array($concern->status, ['submitted','under_review','scheduled','resolved']) ? 'fw-semibold' : 'text-muted' }}">Submitted</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-circle-fill" style="color:{{ in_array($concern->status, ['under_review','scheduled','resolved']) ? '#1e7a4a' : '#cbd5e1' }}; font-size:.5rem;"></i>
                    <small class="{{ in_array($concern->status, ['under_review','scheduled','resolved']) ? 'fw-semibold' : 'text-muted' }}">Under Review</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-circle-fill" style="color:{{ in_array($concern->status, ['scheduled','resolved']) ? '#1e7a4a' : '#cbd5e1' }}; font-size:.5rem;"></i>
                    <small class="{{ in_array($concern->status, ['scheduled','resolved']) ? 'fw-semibold' : 'text-muted' }}">Counseling Scheduled</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-circle-fill" style="color:{{ $concern->status == 'resolved' ? '#1e7a4a' : '#cbd5e1' }}; font-size:.5rem;"></i>
                    <small class="{{ $concern->status == 'resolved' ? 'fw-semibold text-success' : 'text-muted' }}">Resolved</small>
                </div>
            </div>
        </div>

        <div class="modern-card flex-grow-1" style="padding: 1.5rem;">
            <h6 class="fw-semibold mb-3" style="font-size: 1rem;"><i class="bi bi-info-circle me-2"></i>What's Next?</h6>
            <div style="font-size: 0.85rem; line-height: 1.8;">
                <p class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Your counselor will review your concern</p>
                <p class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>You'll be notified of any updates</p>
                <p class="mb-0"><i class="bi bi-check-circle text-success me-2"></i>A counseling session may be scheduled</p>
            </div>
        </div>
    </div>
</div>
@endsection
