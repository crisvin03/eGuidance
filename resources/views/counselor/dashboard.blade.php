@extends('layouts.dashboard')

@section('title', 'Counselor Dashboard')

@section('content')

<!-- Welcome Banner -->
<div class="card border-0 mb-4" style="background:linear-gradient(135deg,#20B2AA,#008B8B);border-radius:16px;">
    <div class="card-body p-4 text-white">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Welcome, {{ Auth::user()->name }}! 👋</h4>
                <p class="mb-0 opacity-75">CARE Center Counselor Portal &mdash; {{ now()->format('l, F d, Y') }}</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('counselor.concerns.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-chat-dots me-1"></i> View Concerns
                    @if($pendingConcerns > 0)
                        <span class="badge bg-danger ms-1">{{ $pendingConcerns }}</span>
                    @endif
                </a>
                <a href="{{ route('counselor.appointments.index') }}" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-calendar3 me-1"></i> Appointments
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
                     style="width:48px;height:48px;background:rgba(245,158,11,0.1);">
                    <i class="bi bi-hourglass-split fs-5 text-warning"></i>
                </div>
                <div class="fs-3 fw-bold text-warning">{{ $pendingConcerns }}</div>
                <div class="text-muted small">Pending Concerns</div>
                <div class="text-danger" style="font-size:0.75rem;">need attention</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(32,178,170,0.1);">
                    <i class="bi bi-calendar-check fs-5" style="color:#20B2AA;"></i>
                </div>
                <div class="fs-3 fw-bold" style="color:#20B2AA;">{{ $todayAppointments }}</div>
                <div class="text-muted small">Today's Appointments</div>
                <div class="text-muted" style="font-size:0.75rem;">{{ $todayAppointments > 0 ? 'scheduled today' : 'no sessions today' }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(59,130,246,0.1);">
                    <i class="bi bi-people fs-5 text-primary"></i>
                </div>
                <div class="fs-3 fw-bold text-primary">{{ $upcomingAppointments->count() }}</div>
                <div class="text-muted small">Upcoming Sessions</div>
                <div class="text-muted" style="font-size:0.75rem;">next 7 days</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(16,185,129,0.1);">
                    <i class="bi bi-graph-up-arrow fs-5 text-success"></i>
                </div>
                @php $totalConcerns = App\Models\Concern::count(); $resolved = App\Models\Concern::where('status','resolved')->count(); @endphp
                <div class="fs-3 fw-bold text-success">{{ $totalConcerns > 0 ? round(($resolved/$totalConcerns)*100) : 0 }}%</div>
                <div class="text-muted small">Resolution Rate</div>
                <div class="text-success" style="font-size:0.75rem;">{{ $resolved }} resolved</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
        <h6 class="fw-bold mb-0"><i class="bi bi-lightning-charge me-2" style="color:#20B2AA;"></i>Quick Actions</h6>
    </div>
    <div class="card-body px-4 pb-4">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="{{ route('counselor.concerns.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card position-relative">
                        <i class="bi bi-chat-dots-fill fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Student Concerns</div>
                        @if($pendingConcerns > 0)
                            <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger" style="font-size:0.65rem;">{{ $pendingConcerns }}</span>
                        @endif
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('counselor.appointments.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card">
                        <i class="bi bi-calendar3 fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Appointments</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('counselor.incident-reports.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card position-relative">
                        <i class="bi bi-file-earmark-text fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Incident Reports</div>
                        @php $pendingIR = App\Models\IncidentReport::where('status','pending')->count(); @endphp
                        @if($pendingIR > 0)
                            <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger" style="font-size:0.65rem;">{{ $pendingIR }}</span>
                        @endif
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('counselor.referrals.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card position-relative">
                        <i class="bi bi-person-check fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Student Referrals</div>
                        @php $pendingRef = App\Models\StudentReferral::where('status','pending')->count(); @endphp
                        @if($pendingRef > 0)
                            <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger" style="font-size:0.65rem;">{{ $pendingRef }}</span>
                        @endif
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Appointments + Analytics -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-calendar3 me-2" style="color:#20B2AA;"></i>Upcoming Appointments</h6>
                <a href="{{ route('counselor.appointments.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body px-4 pb-4">
                @forelse($upcomingAppointments as $appointment)
                    <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                                 style="width:38px;height:38px;background:linear-gradient(135deg,#20B2AA,#008B8B);font-size:0.75rem;">
                                {{ strtoupper(substr($appointment->student->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="fw-semibold small">{{ $appointment->student->name }}</div>
                                <div class="text-muted" style="font-size:0.78rem;">
                                    <i class="bi bi-clock me-1"></i>{{ $appointment->appointment_date->format('M d, Y \a\t h:i A') }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-info">Scheduled</span>
                            <a href="{{ route('counselor.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-calendar-x fs-2 d-block mb-2 opacity-50"></i>
                        No upcoming appointments scheduled.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Analytics Mini -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart me-2" style="color:#20B2AA;"></i>Concerns by Status</h6>
            </div>
            <div class="card-body px-4 pb-4">
                @php
                    $submitted = App\Models\Concern::where('status','submitted')->count();
                    $scheduled = App\Models\Concern::where('status','scheduled')->count();
                    $resolvedC = App\Models\Concern::where('status','resolved')->count();
                    $total2    = $submitted + $scheduled + $resolvedC;
                @endphp
                <canvas id="counselorDonut" style="max-height:200px;" class="mb-3"></canvas>
                <div class="d-flex flex-column gap-2 mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2"><span class="rounded-circle d-inline-block" style="width:10px;height:10px;background:#f59e0b;"></span><small>Pending</small></div>
                        <span class="fw-semibold small">{{ $submitted }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2"><span class="rounded-circle d-inline-block" style="width:10px;height:10px;background:#3b82f6;"></span><small>Scheduled</small></div>
                        <span class="fw-semibold small">{{ $scheduled }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2"><span class="rounded-circle d-inline-block" style="width:10px;height:10px;background:#22c55e;"></span><small>Resolved</small></div>
                        <span class="fw-semibold small">{{ $resolvedC }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Case Management: Incident Reports & Referrals from Teachers -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-file-earmark-text me-2" style="color:#20B2AA;"></i>Teacher Incident Reports</h6>
                <div class="d-flex gap-2 align-items-center">
                    @php $pendingReports = App\Models\IncidentReport::where('status','pending')->count(); @endphp
                    @if($pendingReports > 0)
                        <span class="badge bg-danger">{{ $pendingReports }} pending</span>
                    @endif
                    <a href="{{ route('counselor.incident-reports.index') }}" class="btn btn-primary btn-sm">View All</a>
                </div>
            </div>
            <div class="card-body px-4 pb-4">
                @php $reports = App\Models\IncidentReport::with('teacher')->latest()->take(5)->get(); @endphp
                @forelse($reports as $report)
                    <div class="d-flex justify-content-between align-items-start py-3 border-bottom">
                        <div>
                            <div class="fw-semibold text-dark small">{{ $report->student_name }}</div>
                            <div class="text-muted" style="font-size:0.78rem;">{{ $report->grade_section }} &bull; {{ $report->case_number }}</div>
                            <div class="text-muted" style="font-size:0.78rem;">by {{ $report->teacher->name ?? '—' }}</div>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge bg-{{ $report->urgency_badge }} text-capitalize">{{ $report->urgency_level }}</span>
                            <a href="{{ route('counselor.incident-reports.show', $report) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
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
                <h6 class="fw-bold mb-0"><i class="bi bi-person-check me-2" style="color:#20B2AA;"></i>Student Referrals</h6>
                <div class="d-flex gap-2 align-items-center">
                    @php $pendingRefs = App\Models\StudentReferral::where('status','pending')->count(); @endphp
                    @if($pendingRefs > 0)
                        <span class="badge bg-warning text-dark">{{ $pendingRefs }} pending</span>
                    @endif
                    <a href="{{ route('counselor.referrals.index') }}" class="btn btn-primary btn-sm">View All</a>
                </div>
            </div>
            <div class="card-body px-4 pb-4">
                @php $referrals = App\Models\StudentReferral::with('teacher')->latest()->take(5)->get(); @endphp
                @forelse($referrals as $ref)
                    <div class="d-flex justify-content-between align-items-start py-3 border-bottom">
                        <div>
                            <div class="fw-semibold text-dark small">{{ $ref->student_name }}</div>
                            <div class="text-muted" style="font-size:0.78rem;">{{ $ref->grade_section }} &bull; {{ $ref->referral_number }}</div>
                            <div class="text-muted" style="font-size:0.78rem;">by {{ $ref->teacher->name ?? '—' }}</div>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge bg-{{ $ref->status_badge }} text-capitalize">{{ $ref->status }}</span>
                            <a href="{{ route('counselor.referrals.show', $ref) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('counselorDonut'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Scheduled', 'Resolved'],
        datasets: [{ data: [{{ $submitted }}, {{ $scheduled }}, {{ $resolvedC }}], backgroundColor: ['#f59e0b','#3b82f6','#22c55e'], borderWidth: 0 }]
    },
    options: { cutout: '70%', plugins: { legend: { display: false } } }
});
</script>

<style>
.quick-action-card { transition:all 0.2s ease; cursor:pointer; color:#334155; background:#f8fafc; }
.quick-action-card:hover { background:rgba(32,178,170,0.06); border-color:#20B2AA !important; transform:translateY(-3px); box-shadow:0 8px 20px rgba(32,178,170,0.15); }
</style>

<style>
/* End of counselor dashboard */

/* Extra Small Devices (Phones: 320px - 575px) */
@media (max-width: 575px) {
    .stats-grid {
        grid-template-columns: 1fr !important;
        gap: 0.75rem !important;
        margin-bottom: 1rem !important;
    }
    
    .stat-card {
        padding: 0.75rem !important;
        min-height: auto !important;
    }
    
    .stat-value {
        font-size: 1.25rem !important;
        margin-bottom: 0.25rem !important;
    }
    
    .stat-label {
        font-size: 0.75rem !important;
        margin-bottom: 0.25rem !important;
    }
    
    .stat-change {
        font-size: 0.7rem !important;
    }
    
    .stat-icon {
        width: 32px !important;
        height: 32px !important;
        font-size: 0.875rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .card {
        margin-bottom: 1rem !important;
    }
    
    .card-header {
        padding: 0.75rem 1rem !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 0.5rem !important;
    }
    
    .card-body {
        padding: 0.75rem !important;
    }
    
    .card-title {
        font-size: 1rem !important;
        margin-bottom: 0.25rem !important;
    }
    
    .table th,
    .table td {
        padding: 0.375rem 0.5rem !important;
        font-size: 0.75rem !important;
        border: none !important;
    }
    
    .table thead th {
        font-weight: 600 !important;
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    
    .user-avatar {
        width: 24px !important;
        height: 24px !important;
        font-size: 0.625rem !important;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.625rem !important;
    }
    
    .badge {
        font-size: 0.625rem !important;
        padding: 0.25rem 0.5rem !important;
    }
    
    .d-none-mobile {
        display: none !important;
    }
    
    .row {
        margin: 0 !important;
    }
    
    .row > div {
        padding: 0 0.5rem !important;
        margin-bottom: 0.75rem !important;
    }
    
    /* Compact layout for mobile */
    .table-responsive {
        margin: 0 -0.5rem !important;
    }
    
    /* Better touch targets */
    .btn {
        min-height: 32px !important;
    }
    
    /* Reduce spacing */
    .mt-4 {
        margin-top: 1rem !important;
    }
    
    .mt-3 {
        margin-top: 0.75rem !important;
    }
    
    .py-5 {
        padding: 1.5rem 0 !important;
    }
}

/* Small Devices (Large Phones: 576px - 767px) */
@media (min-width: 576px) and (max-width: 767px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1rem !important;
    }
    
    .stat-card {
        padding: 1rem !important;
    }
    
    .stat-value {
        font-size: 1.5rem !important;
    }
    
    .stat-icon {
        width: 36px !important;
        height: 36px !important;
        font-size: 1rem !important;
    }
    
    .d-none-tablet {
        display: none !important;
    }
    
    .card-header {
        padding: 1rem 1.25rem !important;
    }
    
    .card-body {
        padding: 1rem !important;
    }
    
    .table th,
    .table td {
        padding: 0.5rem !important;
        font-size: 0.8125rem !important;
    }
    
    .user-avatar {
        width: 28px !important;
        height: 28px !important;
        font-size: 0.6875rem !important;
    }
}

/* Medium Devices (Tablets: 768px - 991px) */
@media (min-width: 768px) and (max-width: 991px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1.25rem !important;
    }
    
    .stat-card {
        padding: 1.25rem !important;
    }
    
    .d-none-md {
        display: none !important;
    }
    
    .table th,
    .table td {
        padding: 0.75rem !important;
        font-size: 0.875rem !important;
    }
    
    .user-avatar {
        width: 32px !important;
        height: 32px !important;
        font-size: 0.75rem !important;
    }
}

/* Large Devices (Desktops: 992px - 1199px) */
@media (min-width: 992px) and (max-width: 1199px) {
    .stats-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 1.5rem !important;
    }
    
    .d-none-lg {
        display: none !important;
    }
}

/* Extra Large Devices (Large Desktops: 1200px and up) */
@media (min-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 1.5rem !important;
    }
}

/* Ensure proper table scrolling on all mobile devices */
@media (max-width: 767px) {
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0 -1rem;
        padding: 0 1rem;
    }
    
    /* Hide scrollbar on mobile for cleaner look */
    .table-responsive::-webkit-scrollbar {
        display: none;
    }
    
    .table-responsive {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
}

/* Optimize for very small screens */
@media (max-width: 380px) {
    .stat-value {
        font-size: 1.125rem !important;
    }
    
    .stat-label {
        font-size: 0.6875rem !important;
    }
    
    .stat-change {
        font-size: 0.625rem !important;
    }
    
    .card-title {
        font-size: 0.9375rem !important;
    }
    
    .btn-sm {
        padding: 0.1875rem 0.375rem !important;
        font-size: 0.5625rem !important;
    }
}

/* Landscape orientation adjustments */
@media (max-height: 600px) and (orientation: landscape) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.5rem !important;
    }
    
    .stat-card {
        padding: 0.5rem !important;
    }
    
    .card-header {
        padding: 0.5rem 0.75rem !important;
    }
    
    .card-body {
        padding: 0.5rem !important;
    }
}
</style>
@endsection
