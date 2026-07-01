@extends('layouts.dashboard')
@section('title', 'Submitted Forms')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h5 class="fw-bold mb-0">Submitted Forms</h5>
        <small class="text-muted">Forms submitted by teachers for your review</small>
    </div>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by student, teacher, form..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="submitted"    {{ request('status') == 'submitted'    ? 'selected' : '' }}>Submitted</option>
                    <option value="reviewed"     {{ request('status') == 'reviewed'     ? 'selected' : '' }}>Reviewed</option>
                    <option value="acknowledged" {{ request('status') == 'acknowledged' ? 'selected' : '' }}>Acknowledged</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="form_type" class="form-select">
                    <option value="">All Form Types</option>
                    <option value="confiscation-electronic" {{ request('form_type') == 'confiscation-electronic' ? 'selected' : '' }}>Confiscation Slip (Electronic)</option>
                    <option value="call-slip"               {{ request('form_type') == 'call-slip'               ? 'selected' : '' }}>Call Slip</option>
                    <option value="risk-assessment"         {{ request('form_type') == 'risk-assessment'         ? 'selected' : '' }}>Risk Assessment</option>
                    <option value="confiscation-prohibited" {{ request('form_type') == 'confiscation-prohibited' ? 'selected' : '' }}>Confiscation Slip (Prohibited)</option>
                    <option value="bag-search"              {{ request('form_type') == 'bag-search'              ? 'selected' : '' }}>Bag Search Plan</option>
                    <option value="good-moral"              {{ request('form_type') == 'good-moral'              ? 'selected' : '' }}>Good Moral Request</option>
                    <option value="home-visitation"         {{ request('form_type') == 'home-visitation'         ? 'selected' : '' }}>Home Visitation</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

{{-- Submissions table --}}
<div class="card border-0 shadow-sm" style="border-radius:16px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-muted small">Form Type</th>
                        <th class="py-3 fw-semibold text-muted small">Student</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Submitted By</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Date</th>
                        <th class="py-3 fw-semibold text-muted small">Status</th>
                        <th class="py-3 fw-semibold text-muted small">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-semibold small" style="color:#20B2AA;">{{ $submission->form_title }}</div>
                            </td>
                            <td class="py-3">
                                @if($submission->student_name)
                                    <div class="fw-semibold small">{{ $submission->student_name }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $submission->grade_section }}</div>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="py-3 table-hide-mobile">
                                <div class="small">{{ $submission->teacher->name ?? '—' }}</div>
                            </td>
                            <td class="py-3 table-hide-mobile small text-muted">
                                {{ $submission->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $submission->status_badge }} text-capitalize">
                                    {{ $submission->status }}
                                </span>
                            </td>
                            <td class="py-3">
                                <a href="{{ route('counselor.forms.submitted.show', $submission->id) }}"
                                   class="btn btn-primary btn-sm"><i class="bi bi-eye me-1"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No submitted forms yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="px-4 py-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
            <small class="text-muted">
                @if($submissions->total() > 0)
                    Showing <strong>{{ $submissions->firstItem() }}–{{ $submissions->lastItem() }}</strong>
                    of <strong>{{ $submissions->total() }}</strong> submitted forms
                @else
                    No records found
                @endif
            </small>
            @if($submissions->hasPages())
                <div>{{ $submissions->onEachSide(1)->links() }}</div>
            @endif
        </div>
    </div>
</div>

<style>
.pagination { margin: 0; gap: 3px; }
.pagination .page-link { border-radius: 8px !important; border: 1px solid #e2e8f0; color: #475569; font-size: 0.875rem; padding: 0.4rem 0.75rem; transition: all .2s; }
.pagination .page-link:hover { background: rgba(32,178,170,.1); border-color: #20B2AA; color: #20B2AA; }
.pagination .page-item.active .page-link { background: #20B2AA; border-color: #20B2AA; color: #fff; }
.pagination .page-item.disabled .page-link { opacity: .5; }
</style>

@endsection
