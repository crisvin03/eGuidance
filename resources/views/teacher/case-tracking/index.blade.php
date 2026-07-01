@extends('layouts.dashboard')
@section('title', 'Case Tracking')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h5 class="fw-bold mb-0">Case Tracking</h5>
        <small class="text-muted">Monitor the status of your submitted incident reports and referrals</small>
    </div>
</div>

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-6">
        <input type="text" name="search" class="form-control" placeholder="Search by case/ref no, student name..." value="{{ request('search') }}">
    </div>
    <div class="col-md-4">
        <select name="status" class="form-select">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
            <option value="ongoing" {{ request('status')=='ongoing' ? 'selected' : '' }}>Ongoing</option>
            <option value="closed" {{ request('status')=='closed' ? 'selected' : '' }}>Closed</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Filter</button>
    </div>
</form>

<!-- Incident Reports -->
<h6 class="fw-bold text-muted mb-3 text-uppercase" style="letter-spacing:0.5px;">
    <i class="bi bi-file-earmark-text me-1"></i>Incident Reports
</h6>
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-muted small">Case No.</th>
                        <th class="py-3 fw-semibold text-muted small">Student</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Category</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Assigned Counselor</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Last Updated</th>
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
                            <td class="py-3 table-hide-mobile small text-muted">{{ $report->incident_category_label }}</td>
                            <td class="py-3 table-hide-mobile small">
                                {{ $report->counselor ? $report->counselor->name : '—' }}
                            </td>
                            <td class="py-3 table-hide-mobile small text-muted">{{ $report->updated_at->format('M d, Y') }}</td>
                            <td class="py-3">
                                <span class="badge bg-{{ $report->urgency_badge }} text-capitalize">{{ $report->urgency_level }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $report->status_badge }} text-capitalize">{{ $report->status }}</span>
                            </td>
                            <td class="py-3">
                                <a href="{{ route('teacher.incident-reports.show', $report) }}"
                                   class="btn btn-primary btn-sm py-1 px-2" style="font-size:.78rem;"><i class="bi bi-eye me-1"></i>View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox d-block fs-3 mb-1 opacity-50"></i>
                                No incident reports found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reports->hasPages())
            <div class="px-4 py-3 border-top">{{ $reports->links() }}</div>
        @endif
    </div>
</div>

<!-- Referrals -->
<h6 class="fw-bold text-muted mb-3 text-uppercase" style="letter-spacing:0.5px;">
    <i class="bi bi-person-check me-1"></i>Student Referrals
</h6>
<div class="card border-0 shadow-sm" style="border-radius:16px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-muted small">Ref. No.</th>
                        <th class="py-3 fw-semibold text-muted small">Student</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Assigned Counselor</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Last Updated</th>
                        <th class="py-3 fw-semibold text-muted small">Status</th>
                        <th class="py-3 fw-semibold text-muted small">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($referrals as $referral)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="fw-semibold small" style="color:#20B2AA;">{{ $referral->referral_number }}</span>
                            </td>
                            <td class="py-3">
                                <div class="fw-semibold small">{{ $referral->student_name }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">{{ $referral->grade_section }}</div>
                            </td>
                            <td class="py-3 table-hide-mobile small">
                                {{ $referral->counselor ? $referral->counselor->name : '—' }}
                            </td>
                            <td class="py-3 table-hide-mobile small text-muted">{{ $referral->updated_at->format('M d, Y') }}</td>
                            <td class="py-3">
                                <span class="badge bg-{{ $referral->status_badge }} text-capitalize">{{ $referral->status }}</span>
                            </td>
                            <td class="py-3">
                                <a href="{{ route('teacher.referrals.show', $referral) }}"
                                   class="btn btn-primary btn-sm py-1 px-2" style="font-size:.78rem;"><i class="bi bi-eye me-1"></i>View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox d-block fs-3 mb-1 opacity-50"></i>
                                No referrals found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($referrals->hasPages())
            <div class="px-4 py-3 border-top">{{ $referrals->links() }}</div>
        @endif
    </div>
</div>

<div class="alert alert-secondary mt-4 border-0 small" style="border-radius:12px;">
    <i class="bi bi-shield-lock me-2"></i>
    <strong>Confidentiality Notice:</strong> You can only view the status, assigned counselor, and last update of your submitted cases. Detailed counseling session notes are restricted.
</div>
@endsection
