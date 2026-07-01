@extends('layouts.dashboard')
@section('title', 'Teacher Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="card border-0 mb-4" style="background:linear-gradient(135deg,#20B2AA,#008B8B);border-radius:16px;">
    <div class="card-body p-4 text-white">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Good day, {{ Auth::user()->name }}! 👋</h4>
                <p class="mb-0 opacity-75">CARE Center Teacher Portal &mdash; {{ now()->format('l, F d, Y') }}</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('teacher.incident-reports.create') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-file-earmark-plus me-1"></i> New Incident Report
                </a>
                <a href="{{ route('teacher.referrals.create') }}" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-person-plus me-1"></i> Refer a Student
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(32,178,170,0.1);">
                    <i class="bi bi-file-earmark-text fs-5" style="color:#20B2AA;"></i>
                </div>
                <div class="fs-3 fw-bold" style="color:#20B2AA;">{{ $totalReports }}</div>
                <div class="text-muted small">Total Reports</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(245,158,11,0.1);">
                    <i class="bi bi-hourglass-split fs-5 text-warning"></i>
                </div>
                <div class="fs-3 fw-bold text-warning">{{ $pendingReports }}</div>
                <div class="text-muted small">Pending Reports</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(59,130,246,0.1);">
                    <i class="bi bi-person-check fs-5 text-primary"></i>
                </div>
                <div class="fs-3 fw-bold text-primary">{{ $totalReferrals }}</div>
                <div class="text-muted small">Total Referrals</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(239,68,68,0.1);">
                    <i class="bi bi-clock-history fs-5 text-danger"></i>
                </div>
                <div class="fs-3 fw-bold text-danger">{{ $pendingReferrals }}</div>
                <div class="text-muted small">Pending Referrals</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access Buttons -->
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
        <h6 class="fw-bold mb-0"><i class="bi bi-lightning-charge me-2" style="color:#20B2AA;"></i>Quick Actions</h6>
    </div>
    <div class="card-body px-4 pb-4">
        <div class="row g-3">
            <div class="col-6 col-md-4">
                <a href="{{ route('teacher.incident-reports.create') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center h-100 quick-action-card">
                        <div class="fs-2 mb-2">📋</div>
                        <div class="fw-semibold small">Submit Incident Report</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="{{ route('teacher.referrals.create') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center h-100 quick-action-card">
                        <div class="fs-2 mb-2">👤</div>
                        <div class="fw-semibold small">Refer a Student</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="{{ route('teacher.forms.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center h-100 quick-action-card">
                        <div class="fs-2 mb-2">📄</div>
                        <div class="fw-semibold small">Generate Forms</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="{{ route('teacher.case-tracking.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center h-100 quick-action-card">
                        <div class="fs-2 mb-2">📊</div>
                        <div class="fw-semibold small">View Submitted Cases</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="{{ route('teacher.intervention-guides.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center h-100 quick-action-card">
                        <div class="fs-2 mb-2">📚</div>
                        <div class="fw-semibold small">Intervention Guides</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4">
                <a href="{{ route('teacher.talk-to-counselor') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center h-100 quick-action-card">
                        <div class="fs-2 mb-2">💬</div>
                        <div class="fw-semibold small">Talk to Counselor</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-file-earmark-text me-2" style="color:#20B2AA;"></i>Recent Incident Reports</h6>
                <a href="{{ route('teacher.incident-reports.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body px-4 pb-4">
                @forelse($recentReports as $report)
                    <a href="{{ route('teacher.incident-reports.show', $report) }}" class="text-decoration-none">
                        <div class="d-flex justify-content-between align-items-start py-3 border-bottom">
                            <div>
                                <div class="fw-semibold text-dark small">{{ $report->student_name }}</div>
                                <div class="text-muted" style="font-size:0.78rem;">{{ $report->grade_section }} &bull; {{ $report->case_number }}</div>
                                <div class="text-muted" style="font-size:0.78rem;">{{ $report->date_of_referral->format('M d, Y') }}</div>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-1">
                                <span class="badge bg-{{ $report->urgency_badge }} text-capitalize">{{ $report->urgency_level }}</span>
                                <span class="badge bg-{{ $report->status_badge }} text-capitalize">{{ $report->status }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                        <small>No incident reports yet</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-person-check me-2" style="color:#20B2AA;"></i>Recent Referrals</h6>
                <a href="{{ route('teacher.referrals.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body px-4 pb-4">
                @forelse($recentReferrals as $referral)
                    <a href="{{ route('teacher.referrals.show', $referral) }}" class="text-decoration-none">
                        <div class="d-flex justify-content-between align-items-start py-3 border-bottom">
                            <div>
                                <div class="fw-semibold text-dark small">{{ $referral->student_name }}</div>
                                <div class="text-muted" style="font-size:0.78rem;">{{ $referral->grade_section }} &bull; {{ $referral->referral_number }}</div>
                                <div class="text-muted" style="font-size:0.78rem;">{{ $referral->created_at->format('M d, Y') }}</div>
                            </div>
                            <span class="badge bg-{{ $referral->status_badge }} text-capitalize">{{ $referral->status }}</span>
                        </div>
                    </a>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                        <small>No referrals yet</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.quick-action-card {
    transition: all 0.2s ease;
    cursor: pointer;
    color: #334155;
    background: #f8fafc;
}
.quick-action-card:hover {
    background: rgba(32,178,170,0.06);
    border-color: #20B2AA !important;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(32,178,170,0.15);
}
.quick-action-card .fw-semibold { color: #334155; }
</style>
@endsection
