@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')

@section('content')
@php
    $lastMonthStart = now()->subMonth()->startOfMonth();
    $lastMonthEnd   = now()->subMonth()->endOfMonth();
    $lastMonthConcerns     = App\Models\Concern::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
    $thisMonthConcerns     = App\Models\Concern::whereBetween('created_at', [now()->startOfMonth(), now()])->count();
    $lastMonthAppointments = App\Models\Appointment::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
    $thisMonthAppointments = App\Models\Appointment::whereBetween('created_at', [now()->startOfMonth(), now()])->count();
    $concernsChange        = $lastMonthConcerns > 0 ? round((($thisMonthConcerns - $lastMonthConcerns) / $lastMonthConcerns) * 100, 1) : 0;
    $appointmentsChange    = $lastMonthAppointments > 0 ? round((($thisMonthAppointments - $lastMonthAppointments) / $lastMonthAppointments) * 100, 1) : 0;
    $todayPending          = App\Models\Concern::where('status', 'submitted')->whereDate('created_at', today())->count();
    $totalStudents         = App\Models\User::whereHas('role', fn($q) => $q->where('name', 'student'))->count();
    $totalTeachers         = App\Models\User::whereHas('role', fn($q) => $q->where('name', 'teacher'))->count();
    $totalIncidentReports  = App\Models\IncidentReport::count();
    $totalReferrals        = App\Models\StudentReferral::count();

    // Analytics data
    $concernsByCategory = App\Models\Concern::join('concern_categories','concerns.category_id','=','concern_categories.id')
        ->selectRaw('concern_categories.name as label, count(*) as total')
        ->groupBy('concern_categories.name')->get();
    $monthlyLabels = collect();
    $monthlyConcerns = collect();
    for ($i = 5; $i >= 0; $i--) {
        $m = now()->subMonths($i);
        $monthlyLabels->push($m->format('M Y'));
        $monthlyConcerns->push(App\Models\Concern::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count());
    }
    $incidentsByCategory = App\Models\IncidentReport::selectRaw('incident_category as label, count(*) as total')
        ->groupBy('incident_category')->get();
@endphp

<!-- Welcome Banner -->
<div class="card border-0 mb-4" style="background:linear-gradient(135deg,#20B2AA,#008B8B);border-radius:16px;">
    <div class="card-body p-4 text-white">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Admin Dashboard 🛡️</h4>
                <p class="mb-0 opacity-75">BNHS Care Corner Admin Dashboard &mdash; {{ now()->format('l, F d, Y') }}</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-person-plus me-1"></i> Add User
                </a>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-bar-chart me-1"></i> Reports
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
                    <i class="bi bi-chat-dots-fill fs-5" style="color:#20B2AA;"></i>
                </div>
                <div class="fs-3 fw-bold" style="color:#20B2AA;">{{ $totalConcerns }}</div>
                <div class="text-muted small">Total Concerns</div>
                <div class="{{ $concernsChange >= 0 ? 'text-success' : 'text-danger' }}" style="font-size:0.75rem;">
                    <i class="bi bi-arrow-{{ $concernsChange >= 0 ? 'up' : 'down' }}"></i> {{ abs($concernsChange) }}% vs last month
                </div>
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
                <div class="fs-3 fw-bold text-warning">{{ $pendingConcerns }}</div>
                <div class="text-muted small">Pending Concerns</div>
                <div class="text-danger" style="font-size:0.75rem;">{{ $todayPending }} new today</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(16,185,129,0.1);">
                    <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                </div>
                <div class="fs-3 fw-bold text-success">{{ $resolvedConcerns }}</div>
                <div class="text-muted small">Resolved Concerns</div>
                <div class="text-success" style="font-size:0.75rem;">{{ $totalConcerns > 0 ? round(($resolvedConcerns/$totalConcerns)*100) : 0 }}% rate</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(59,130,246,0.1);">
                    <i class="bi bi-calendar3 fs-5 text-primary"></i>
                </div>
                <div class="fs-3 fw-bold text-primary">{{ $totalAppointments }}</div>
                <div class="text-muted small">Total Appointments</div>
                <div class="{{ $appointmentsChange >= 0 ? 'text-success' : 'text-danger' }}" style="font-size:0.75rem;">
                    <i class="bi bi-arrow-{{ $appointmentsChange >= 0 ? 'up' : 'down' }}"></i> {{ abs($appointmentsChange) }}% vs last month
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(139,92,246,0.1);">
                    <i class="bi bi-people-fill fs-5" style="color:#8b5cf6;"></i>
                </div>
                <div class="fs-3 fw-bold" style="color:#8b5cf6;">{{ $totalStudents }}</div>
                <div class="text-muted small">Students</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(236,72,153,0.1);">
                    <i class="bi bi-person-video3 fs-5" style="color:#ec4899;"></i>
                </div>
                <div class="fs-3 fw-bold" style="color:#ec4899;">{{ $totalTeachers }}</div>
                <div class="text-muted small">Teachers</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(239,68,68,0.1);">
                    <i class="bi bi-file-earmark-text-fill fs-5 text-danger"></i>
                </div>
                <div class="fs-3 fw-bold text-danger">{{ $totalIncidentReports }}</div>
                <div class="text-muted small">Incident Reports</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
            <div class="card-body text-center p-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:48px;height:48px;background:rgba(245,158,11,0.1);">
                    <i class="bi bi-person-check-fill fs-5 text-warning"></i>
                </div>
                <div class="fs-3 fw-bold text-warning">{{ $totalReferrals }}</div>
                <div class="text-muted small">Student Referrals</div>
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
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card">
                        <i class="bi bi-people-fill fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Manage Users</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card">
                        <i class="bi bi-tags-fill fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Categories</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.reports.index') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card">
                        <i class="bi bi-bar-chart-fill fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Reports &amp; Analytics</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('admin.reports.export.full') }}" class="text-decoration-none">
                    <div class="border rounded-3 p-3 text-center quick-action-card">
                        <i class="bi bi-download fs-2 mb-2 d-block" style="color:#20B2AA;"></i>
                        <div class="fw-semibold small">Export Full Report</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Charts -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-graph-up me-2" style="color:#20B2AA;"></i>Monthly Concerns (Last 6 Months)</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <canvas id="monthlyChart" style="max-height:250px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart me-2" style="color:#20B2AA;"></i>Concerns by Category</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <canvas id="categoryChart" style="max-height:220px;" class="mb-3"></canvas>
                <div class="d-flex flex-column gap-1" style="font-size:0.78rem;">
                    @foreach($concernsByCategory->take(5) as $i => $row)
                        @php $colors = ['#20B2AA','#3b82f6','#f59e0b','#22c55e','#ef4444','#8b5cf6','#ec4899']; @endphp
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="rounded-circle d-inline-block" style="width:8px;height:8px;background:{{ $colors[$i % count($colors)] }};"></span>
                                <small>{{ Str::limit($row->label, 25) }}</small>
                            </div>
                            <span class="fw-semibold">{{ $row->total }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incident Reports Analytics + System Info -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-bar-chart me-2" style="color:#20B2AA;"></i>Incident Reports by Category</h6>
            </div>
            <div class="card-body px-4 pb-4">
                @forelse($incidentsByCategory as $row)
                    @php
                        $maxVal = $incidentsByCategory->max('total') ?: 1;
                        $pct    = round(($row->total / $maxVal) * 100);
                        $label  = match($row->label) {
                            'bullying'           => 'Bullying',
                            'behavioral_concern' => 'Behavioral',
                            'mental_health'      => 'Mental Health',
                            'academic_risk'      => 'Academic Risk',
                            'child_protection'   => 'Child Protection',
                            'classroom_incident' => 'Classroom Incident',
                            default              => ucfirst($row->label),
                        };
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="fw-semibold">{{ $label }}</small>
                            <small class="text-muted">{{ $row->total }}</small>
                        </div>
                        <div class="progress" style="height:6px;border-radius:4px;">
                            <div class="progress-bar" style="width:{{ $pct }}%;background:#20B2AA;"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-bar-chart fs-2 d-block mb-2 opacity-50"></i>
                        <small>No incident report data yet</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-server me-2" style="color:#20B2AA;"></i>System Overview</h6>
            </div>
            <div class="card-body px-4 pb-4">
                @php $totalUsers = App\Models\User::count(); @endphp
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-circle-fill text-success" style="font-size:0.5rem;"></i>
                        <span class="small fw-semibold">System Status</span>
                    </div>
                    <span class="badge bg-success">Online</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-database-fill me-1" style="color:#20B2AA;"></i>
                        <span class="small fw-semibold">Database</span>
                    </div>
                    <span class="badge bg-success">Connected</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <span class="small fw-semibold"><i class="bi bi-people me-2 text-muted"></i>Total Users</span>
                    <span class="fw-bold" style="color:#20B2AA;">{{ $totalUsers }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <span class="small fw-semibold"><i class="bi bi-calendar me-2 text-muted"></i>Today's Appointments</span>
                    <span class="fw-bold text-primary">{{ $todayAppointments }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                    <span class="small fw-semibold"><i class="bi bi-clock me-2 text-muted"></i>Last Updated</span>
                    <span class="text-muted small">{{ now()->format('M d, Y h:i A') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-3">
                    <span class="small fw-semibold"><i class="bi bi-info-circle me-2 text-muted"></i>Version</span>
                    <span class="badge" style="background:rgba(32,178,170,0.1);color:#20B2AA;">v1.0.0</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const accentColor = '#20B2AA';
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlyLabels) !!},
        datasets: [{
            label: 'Concerns',
            data: {!! json_encode($monthlyConcerns) !!},
            backgroundColor: 'rgba(32,178,170,0.2)',
            borderColor: accentColor,
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($concernsByCategory->pluck('label')) !!},
        datasets: [{
            data: {!! json_encode($concernsByCategory->pluck('total')) !!},
            backgroundColor: ['#20B2AA','#3b82f6','#f59e0b','#22c55e','#ef4444','#8b5cf6','#ec4899'],
            borderWidth: 0
        }]
    },
    options: { cutout: '65%', plugins: { legend: { display: false } } }
});
</script>

<style>
.quick-action-card { transition:all 0.2s ease; cursor:pointer; color:#334155; background:#f8fafc; }
.quick-action-card:hover { background:rgba(32,178,170,0.06); border-color:#20B2AA !important; transform:translateY(-3px); box-shadow:0 8px 20px rgba(32,178,170,0.15); }
</style>
@endsection
