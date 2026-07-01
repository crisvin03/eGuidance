@extends('layouts.dashboard')
@section('title', 'Incident Report Details')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('counselor.incident-reports.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Incident Reports
        </a>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ $incidentReport->case_number }} &mdash; {{ $incidentReport->student_name }}</h5>
                @if($incidentReport->status == 'pending')
                    <span class="badge badge-warning">Pending</span>
                @elseif($incidentReport->status == 'ongoing')
                    <span class="badge badge-info">Ongoing</span>
                @else
                    <span class="badge badge-success">Closed</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-person me-1"></i>Student Name</small>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar">{{ strtoupper(substr($incidentReport->student_name, 0, 2)) }}</div>
                                <strong>{{ $incidentReport->student_name }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-123 me-1"></i>Age</small>
                            <strong>{{ $incidentReport->student_age ?? '—' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-book me-1"></i>Grade & Section</small>
                            <strong>{{ $incidentReport->grade_section }}</strong>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-geo-alt me-1"></i>Address</small>
                            <strong>{{ $incidentReport->student_address ?? '—' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-calendar me-1"></i>Date of Referral</small>
                            <strong>{{ $incidentReport->date_of_referral->format('M d, Y') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-clock me-1"></i>Time of Incident</small>
                            <strong>{{ $incidentReport->time_of_incident ? \Carbon\Carbon::parse($incidentReport->time_of_incident)->format('h:i A') : '—' }}</strong>
                        </div>
                    </div>
                            <small class="text-muted d-block mb-1"><i class="bi bi-person-badge me-1"></i>Submitted By</small>
                            <strong>{{ $incidentReport->teacher->name ?? '—' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-tag me-1"></i>Category</small>
                            <span class="badge bg-info">{{ $incidentReport->incident_category_label }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1"><i class="bi bi-chat-dots me-1"></i>Concern Type</small>
                            <strong>{{ $incidentReport->concern_type_label }}</strong>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-text-paragraph me-1"></i>Incident Description</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $incidentReport->incident_description }}</p>
                </div>

                @if($incidentReport->initial_intervention)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-bandaid me-1"></i>Initial Intervention Conducted</h6>
                    <div class="alert alert-success mb-0">
                        <p class="mb-0" style="white-space:pre-wrap;">{{ $incidentReport->initial_intervention }}</p>
                    </div>
                </div>
                @endif

                @if($incidentReport->parent_guardian_name)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-house me-1"></i>Parent / Guardian</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted d-block mb-1">Name</small>
                                <strong>{{ $incidentReport->parent_guardian_name }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted d-block mb-1">Contact</small>
                                <strong>{{ $incidentReport->parent_guardian_contact ?? '—' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($incidentReport->attachment_path)
                <div class="mb-4">
                    <h6 class="fw-semibold mb-2"><i class="bi bi-paperclip me-1"></i>Attachment</h6>
                    <div class="d-flex align-items-center gap-3 p-3 border rounded bg-light">
                        <i class="bi bi-file-earmark-text" style="font-size:2rem; color:#6366f1;"></i>
                        <div>
                            <div class="fw-semibold">{{ $incidentReport->attachment_name ?? 'Attachment' }}</div>
                            <small class="text-muted">{{ strtoupper(pathinfo($incidentReport->attachment_name ?? '', PATHINFO_EXTENSION)) }} file</small>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ asset('storage/' . $incidentReport->attachment_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-up-right me-1"></i>View
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if($incidentReport->counselor_notes)
                <div class="alert alert-info">
                    <h6 class="alert-heading fw-semibold"><i class="bi bi-person-check-fill me-1"></i>Counselor Notes</h6>
                    <p class="mb-0" style="white-space:pre-wrap;">{{ $incidentReport->counselor_notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0"><i class="bi bi-reply me-1"></i>Update Status & Notes</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('counselor.incident-reports.update', $incidentReport) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $incidentReport->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="ongoing" {{ $incidentReport->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="closed" {{ $incidentReport->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Counselor Notes</label>
                        <textarea class="form-control" name="counselor_notes" rows="4"
                                  placeholder="Add observations, recommendations, or follow-up actions...">{{ $incidentReport->counselor_notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg me-1"></i> Update Report
                    </button>
                </form>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Report Details</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Case Number</small>
                        <strong style="color:#20B2AA;">{{ $incidentReport->case_number }}</strong>
                    </div>
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Urgency Level</small>
                        @if($incidentReport->urgency_level == 'high')
                            <span class="badge badge-danger">High</span>
                        @elseif($incidentReport->urgency_level == 'moderate')
                            <span class="badge badge-warning">Moderate</span>
                        @else
                            <span class="badge badge-success">Low</span>
                        @endif
                    </div>
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Assigned Counselor</small>
                        <strong>{{ $incidentReport->counselor->name ?? 'Unassigned' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Referred By</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Name</small>
                        <strong>{{ $incidentReport->referred_by_name }}</strong>
                    </div>
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Designation</small>
                        <strong>{{ $incidentReport->referred_by_designation }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
