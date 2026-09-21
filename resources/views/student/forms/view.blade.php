@extends('layouts.dashboard')

@section('title', 'Form Submission Details')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('student.forms.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to My Forms
        </a>
    </div>

    <div class="col-lg-8 mx-auto">
        <div class="card border-0 shadow-sm" style="border-radius:16px;">
            <div class="card-header py-3 px-4" style="background:#f8fafc;border-radius:16px 16px 0 0;">
                <h5 class="fw-bold mb-1">{{ $submission->form_type_name }}</h5>
                <div class="d-flex align-items-center gap-2 mt-2">
                    <small class="text-muted">Submitted: {{ $submission->created_at->format('F d, Y h:i A') }}</small>
                    <span class="badge bg-{{ $submission->status_badge }}">{{ ucfirst($submission->status) }}</span>
                </div>
            </div>
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Your Responses:</h6>
                
                @if($submission->form_data)
                    @foreach($submission->form_data as $key => $value)
                    <div class="mb-3 p-3 bg-light rounded">
                        <div class="fw-semibold mb-2 text-capitalize" style="color:#1e7a4a;">
                            {{ str_replace('_', ' ', $key) }}
                        </div>
                        <div>
                            @if(is_array($value))
                                @foreach($value as $item)
                                    <span class="badge bg-secondary me-1">{{ $item }}</span>
                                @endforeach
                            @else
                                {{ $value ?: 'No response provided' }}
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted">No response data available</p>
                @endif

                @if($submission->counselor_notes)
                <div class="mt-4 alert alert-info border-0" style="border-radius:12px;">
                    <h6 class="alert-heading fw-bold"><i class="bi bi-chat-left-dots me-2"></i>Counselor Feedback</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $submission->counselor_notes }}</p>
                    @if($submission->reviewed_at)
                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-clock me-1"></i>Reviewed on {{ $submission->reviewed_at->format('F d, Y h:i A') }}
                    </small>
                    @endif
                </div>
                @endif

                @if($submission->status === 'submitted')
                <div class="alert alert-warning border-0 mt-4" style="border-radius:12px;">
                    <i class="bi bi-hourglass-split me-2"></i>
                    Your form is pending review by the counselor.
                </div>
                @elseif($submission->status === 'approved')
                <div class="alert alert-success border-0 mt-4" style="border-radius:12px;">
                    <i class="bi bi-check-circle me-2"></i>
                    Your form has been approved by the counselor.
                </div>
                @elseif($submission->status === 'rejected')
                <div class="alert alert-danger border-0 mt-4" style="border-radius:12px;">
                    <i class="bi bi-x-circle me-2"></i>
                    Your form was rejected. Please check the counselor's feedback above.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
