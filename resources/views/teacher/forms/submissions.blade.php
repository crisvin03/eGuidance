@extends('layouts.dashboard')
@section('title', 'My Submitted Forms')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h5 class="fw-bold mb-0">My Submitted Forms</h5>
        <small class="text-muted">All forms you have generated and sent to the counselor</small>
    </div>
    <a href="{{ route('teacher.forms.index') }}" class="btn text-white fw-semibold btn-sm" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
        <i class="bi bi-file-earmark-plus me-1"></i> Generate New Form
    </a>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label form-label-sm text-muted mb-1">Search</label>
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Student name or form title..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label form-label-sm text-muted mb-1">Form Type</label>
                <select name="form_type" class="form-select form-select-sm">
                    <option value="">All Form Types</option>
                    <option value="confiscation-electronic" {{ request('form_type') == 'confiscation-electronic' ? 'selected' : '' }}>Confiscation Slip (Electronic)</option>
                    <option value="call-slip"               {{ request('form_type') == 'call-slip'               ? 'selected' : '' }}>Call Slip</option>
                    <option value="risk-assessment"         {{ request('form_type') == 'risk-assessment'         ? 'selected' : '' }}>Initial Risk Assessment</option>
                    <option value="confiscation-prohibited" {{ request('form_type') == 'confiscation-prohibited' ? 'selected' : '' }}>Confiscation Slip (Prohibited)</option>
                    <option value="bag-search"              {{ request('form_type') == 'bag-search'              ? 'selected' : '' }}>Random Bag Search Plan</option>
                    <option value="good-moral"              {{ request('form_type') == 'good-moral'              ? 'selected' : '' }}>Good Moral Request</option>
                    <option value="home-visitation"         {{ request('form_type') == 'home-visitation'         ? 'selected' : '' }}>Home Visitation</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label form-label-sm text-muted mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="submitted"    {{ request('status') == 'submitted'    ? 'selected' : '' }}>Submitted</option>
                    <option value="reviewed"     {{ request('status') == 'reviewed'     ? 'selected' : '' }}>Reviewed</option>
                    <option value="acknowledged" {{ request('status') == 'acknowledged' ? 'selected' : '' }}>Acknowledged</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-primary btn-sm flex-fill"><i class="bi bi-search me-1"></i> Filter</button>
                @if(request('search') || request('status') || request('form_type'))
                <a href="{{ route('teacher.forms.submissions') }}" class="btn btn-secondary btn-sm flex-fill">Clear</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Submissions list --}}
<div class="card border-0 shadow-sm" style="border-radius:16px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-muted small">Form Type</th>
                        <th class="py-3 fw-semibold text-muted small">Student</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Date Sent</th>
                        <th class="py-3 fw-semibold text-muted small">Status</th>
                        <th class="py-3 fw-semibold text-muted small">Counselor Notes</th>
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
                            <td class="py-3 table-hide-mobile small text-muted">
                                {{ $submission->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="py-3">
                                @php
                                    $badgeColor = match($submission->status) {
                                        'submitted'    => 'warning',
                                        'reviewed'     => 'info',
                                        'acknowledged' => 'success',
                                        default        => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeColor }} text-capitalize">
                                    {{ $submission->status }}
                                </span>
                            </td>
                            <td class="py-3 small text-muted">
                                {{ $submission->counselor_notes ? \Str::limit($submission->counselor_notes, 50) : '—' }}
                            </td>
                            <td class="py-3">
                                <a href="{{ route('teacher.forms.submissions.show', $submission->id) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye me-1"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No submitted forms yet.
                                <a href="{{ route('teacher.forms.index') }}">Generate one now.</a>
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

{{-- Legend --}}
<div class="d-flex gap-3 mt-3 flex-wrap">
    <small class="text-muted"><span class="badge bg-warning me-1">Submitted</span> Sent, awaiting counselor review</small>
    <small class="text-muted"><span class="badge bg-info me-1">Reviewed</span> Counselor has reviewed it</small>
    <small class="text-muted"><span class="badge bg-success me-1">Acknowledged</span> Counselor has acknowledged and acted on it</small>
</div>

<style>
.pagination { margin: 0; gap: 3px; }
.pagination .page-link { border-radius: 8px !important; border: 1px solid #e2e8f0; color: #475569; font-size: 0.875rem; padding: 0.4rem 0.75rem; transition: all .2s; }
.pagination .page-link:hover { background: rgba(32,178,170,.1); border-color: #20B2AA; color: #20B2AA; }
.pagination .page-item.active .page-link { background: #20B2AA; border-color: #20B2AA; color: #fff; }
.pagination .page-item.disabled .page-link { opacity: .5; }
</style>

@endsection
