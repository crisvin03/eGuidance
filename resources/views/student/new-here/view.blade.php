@extends('layouts.dashboard')

@section('title', 'View Clearance Submission')

@section('content')
@include('student.partials.modern-styles')

<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('student.new-here') }}" class="modern-btn modern-btn-secondary">
        <i class="bi bi-arrow-left"></i>
        <span>Back to New Here</span>
    </a>
</div>

<!-- Status Banner -->
<div class="modern-card mb-4" style="text-align: center; padding: 1.5rem; background: 
    {{ $submission->status === 'approved' ? 'linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05))' : 
       ($submission->status === 'submitted' ? 'linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05))' : 
       'linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05))') }};">
    <h4 class="fw-bold mb-2">
        @if($submission->status === 'approved')
            <i class="bi bi-check-circle-fill" style="color: #10b981;"></i> Clearance Approved
        @elseif($submission->status === 'submitted')
            <i class="bi bi-clock-fill" style="color: #f59e0b;"></i> Pending Review
        @else
            <i class="bi bi-exclamation-circle-fill" style="color: #ef4444;"></i> Needs Revision
        @endif
    </h4>
    <p class="text-muted mb-0">Submitted on {{ $submission->created_at->format('F d, Y h:i A') }}</p>
    @if($submission->reviewer)
        <p class="text-muted mb-0">Reviewed by: <strong>{{ $submission->reviewer->name }}</strong></p>
    @endif
</div>

<!-- Page Header -->
<div class="modern-card mb-4" style="text-align: center; padding: 2rem;">
    <h2 class="fw-bold mb-2" style="color: var(--green); font-size: 1.75rem;">LEARNER REINTEGRATION CLEARANCE</h2>
    <p class="text-muted mb-0" style="font-size: 1.05rem;">For Return to Regular Classroom Participation</p>
</div>

@php
    $data = $submission->form_data;
@endphp

<!-- Basic Information -->
<div class="modern-card mb-4">
    <h6 class="fw-bold mb-3" style="color: #111827;">
        <i class="bi bi-person-fill me-2" style="color: var(--green);"></i>Learner Information
    </h6>
    
    <div class="row g-3">
        <div class="col-md-6">
            <div class="p-3 bg-light rounded">
                <small class="text-muted d-block mb-1">Name of Learner</small>
                <strong>{{ $data['learner_name'] }}</strong>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 bg-light rounded">
                <small class="text-muted d-block mb-1">Grade & Section</small>
                <strong>{{ $data['grade_section'] }}</strong>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 bg-light rounded">
                <small class="text-muted d-block mb-1">Reason for Intervention/Suspension</small>
                <strong>{{ $data['reason'] }}</strong>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 bg-light rounded">
                <small class="text-muted d-block mb-1">Date of Return</small>
                <strong>{{ \Carbon\Carbon::parse($data['return_date'])->format('F d, Y') }}</strong>
            </div>
        </div>
    </div>
</div>

<!-- Reintegration Checklist -->
<div class="modern-card mb-4">
    <h6 class="fw-bold mb-3" style="color: #111827;">
        <i class="bi bi-clipboard-check me-2" style="color: var(--green);"></i>Reintegration Checklist
    </h6>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead style="background: rgba(30, 122, 74, 0.08);">
                <tr>
                    <th style="width: 50%;">Requirement</th>
                    <th style="width: 10%; text-align: center;">Status</th>
                    <th style="width: 40%;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>1. Case Review</strong></td>
                    <td style="text-align: center;">
                        @if(isset($data['checklist']['case_review']) && $data['checklist']['case_review'])
                            <i class="bi bi-check-circle-fill text-success"></i>
                        @else
                            <i class="bi bi-x-circle text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $data['remarks']['case_review'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>2. Intervention</strong></td>
                    <td style="text-align: center;">
                        @if(isset($data['checklist']['intervention']) && $data['checklist']['intervention'])
                            <i class="bi bi-check-circle-fill text-success"></i>
                        @else
                            <i class="bi bi-x-circle text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $data['remarks']['intervention'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>3. Learner Conference</strong></td>
                    <td style="text-align: center;">
                        @if(isset($data['checklist']['conference']) && $data['checklist']['conference'])
                            <i class="bi bi-check-circle-fill text-success"></i>
                        @else
                            <i class="bi bi-x-circle text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $data['remarks']['conference'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>4. Parent Coordination</strong></td>
                    <td style="text-align: center;">
                        @if(isset($data['checklist']['parent_coord']) && $data['checklist']['parent_coord'])
                            <i class="bi bi-check-circle-fill text-success"></i>
                        @else
                            <i class="bi bi-x-circle text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $data['remarks']['parent_coord'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>5. Readiness Assessment</strong></td>
                    <td style="text-align: center;">
                        @if(isset($data['checklist']['readiness']) && $data['checklist']['readiness'])
                            <i class="bi bi-check-circle-fill text-success"></i>
                        @else
                            <i class="bi bi-x-circle text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $data['remarks']['readiness'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>6. Follow-Up Plan</strong></td>
                    <td style="text-align: center;">
                        @if(isset($data['checklist']['followup']) && $data['checklist']['followup'])
                            <i class="bi bi-check-circle-fill text-success"></i>
                        @else
                            <i class="bi bi-x-circle text-muted"></i>
                        @endif
                    </td>
                    <td>{{ $data['remarks']['followup'] ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Support Needs -->
<div class="modern-card mb-4">
    <h6 class="fw-bold mb-3" style="color: #111827;">
        <i class="bi bi-hand-thumbs-up me-2" style="color: var(--green);"></i>Follow-Up Support Requested
    </h6>
    
    @if(isset($data['support']) && count($data['support']) > 0)
        <div class="row g-2">
            @foreach($data['support'] as $support)
                <div class="col-md-6">
                    <div class="p-2 rounded" style="background: rgba(30, 122, 74, 0.05); border-left: 3px solid var(--green);">
                        @if($support === 'counseling')
                            <i class="bi bi-chat-dots text-primary me-2"></i> Counseling Follow-Up
                        @elseif($support === 'teacher_monitoring')
                            <i class="bi bi-person-video3 text-success me-2"></i> Teacher Monitoring
                        @elseif($support === 'parent_coordination')
                            <i class="bi bi-people text-info me-2"></i> Parent/Guardian Coordination
                        @elseif($support === 'behavior_monitoring')
                            <i class="bi bi-clipboard-check text-warning me-2"></i> Behavior Monitoring
                        @elseif($support === 'academic_support')
                            <i class="bi bi-book text-danger me-2"></i> Academic Support
                        @else
                            <i class="bi bi-three-dots text-secondary me-2"></i> Other: {{ $data['other_support'] ?? '' }}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted mb-0">No specific support requested.</p>
    @endif
</div>

<!-- Additional Comments -->
@if(isset($data['additional_comments']) && $data['additional_comments'])
<div class="modern-card mb-4">
    <h6 class="fw-bold mb-3" style="color: #111827;">
        <i class="bi bi-chat-left-text me-2" style="color: var(--green);"></i>Additional Comments
    </h6>
    <p class="mb-0" style="white-space: pre-wrap;">{{ $data['additional_comments'] }}</p>
</div>
@endif

<!-- Counselor Response -->
@if($submission->counselor_notes)
<div class="modern-card mb-4" style="background: rgba(59, 130, 246, 0.05); border-left: 4px solid #3b82f6;">
    <h6 class="fw-bold mb-3" style="color: #3b82f6;">
        <i class="bi bi-person-badge me-2"></i>Counselor's Notes
    </h6>
    <p class="mb-0" style="white-space: pre-wrap;">{{ $submission->counselor_notes }}</p>
</div>
@endif

@endsection
