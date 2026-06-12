@extends('layouts.dashboard')
@section('title', 'Incident Reports')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h5 class="fw-bold mb-0">Incident Reports</h5>
        <small class="text-muted">All incident reports you have submitted</small>
    </div>
    <a href="{{ route('teacher.incident-reports.create') }}" class="btn text-white fw-semibold"
       style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
        <i class="bi bi-plus-lg me-1"></i> New Report
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius:16px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-muted small">Case No.</th>
                        <th class="py-3 fw-semibold text-muted small">Student</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Category</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Date</th>
                        <th class="py-3 fw-semibold text-muted small">Urgency</th>
                        <th class="py-3 fw-semibold text-muted small">Status</th>
                        <th class="py-3 fw-semibold text-muted small">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="fw-semibold small" style="color:#20B2AA;">{{ $report->case_number }}</span>
                            </td>
                            <td class="py-3">
                                <div class="fw-semibold small">{{ $report->student_name }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">{{ $report->grade_section }}</div>
                            </td>
                            <td class="py-3 table-hide-mobile">
                                <span class="small text-muted">{{ $report->incident_category_label }}</span>
                            </td>
                            <td class="py-3 table-hide-mobile small text-muted">
                                {{ $report->date_of_referral->format('M d, Y') }}
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $report->urgency_badge }} text-capitalize">{{ $report->urgency_level }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $report->status_badge }} text-capitalize">{{ $report->status }}</span>
                            </td>
                            <td class="py-3">
                                <a href="{{ route('teacher.incident-reports.show', $report) }}"
                                   class="btn btn-sm btn-outline-secondary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No incident reports found.
                                <a href="{{ route('teacher.incident-reports.create') }}">Submit one now.</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
            <div class="p-4">{{ $reports->links() }}</div>
        @endif
    </div>
</div>
@endsection
