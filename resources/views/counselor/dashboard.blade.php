@extends('layouts.dashboard')

@section('title', 'Counselor Dashboard')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-page-header-compact { flex-direction: column !important; align-items: flex-start !important; gap: 1rem !important; }
    .modern-stats-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 0.75rem !important; }
    .modern-stat-card { padding: 1rem !important; }
    .modern-stat-value { font-size: 1.5rem !important; }
    .modern-stat-label { font-size: 0.75rem !important; }
    div[style*="display: grid"][style*="grid-template-columns: repeat(2"] { grid-template-columns: 1fr !important; }
    div[style*="display: grid"][style*="grid-template-columns: repeat(3"] { grid-template-columns: 1fr !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    h5, h6 { font-size: 1rem !important; }
    .table { font-size: 0.875rem !important; }
}
</style>

<!-- Welcome Hero Section -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Welcome, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
            <p class="modern-page-subtitle">CARE Konek Counselor Portal — {{ now()->format('l, F d, Y') }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('counselor.concerns.index') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-chat-dots-fill"></i>
                <span>View Concerns</span>
                @if($pendingConcerns > 0)
                    <span class="badge bg-danger ms-1">{{ $pendingConcerns }}</span>
                @endif
            </a>
            <a href="{{ route('counselor.appointments.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-calendar3"></i>
                <span>Appointments</span>
            </a>
        </div>
    </div>
</div>

<!-- Status Cards Grid -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">
    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $pendingConcerns }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Pending</div>
        </div>
        <a href="{{ route('counselor.concerns.index') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-calendar-check"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $todayAppointments }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Today</div>
        </div>
        <a href="{{ route('counselor.appointments.index') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-people"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $upcomingAppointments->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Upcoming</div>
        </div>
        <a href="{{ route('counselor.appointments.index') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-graph-up-arrow"></i>
        </div>
        <div style="flex: 1;">
            @php 
                $totalConcerns = App\Models\Concern::count(); 
                $resolved = App\Models\Concern::where('status','resolved')->count(); 
            @endphp
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $totalConcerns > 0 ? round(($resolved/$totalConcerns)*100) : 0 }}%</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Resolved</div>
        </div>
        <a href="{{ route('counselor.concerns.index') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Main Content Grid -->
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
    <!-- Upcoming Appointments -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon modern-page-icon-green" style="width: 40px; height: 40px; font-size: 1.1rem;">
                <i class="bi bi-calendar3"></i>
            </div>
            <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Upcoming Appointments</h2>
            <a href="{{ route('counselor.appointments.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                View All
            </a>
        </div>
        
        <div class="modern-list">
            @forelse($upcomingAppointments as $appointment)
                <div class="modern-list-item" style="padding: 1rem 0;">
                    <div style="flex: 1;">
                        <div style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">{{ $appointment->student->name }}</div>
                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; font-size: 0.8rem; color: var(--text-muted);">
                            <span><i class="bi bi-calendar3"></i> {{ $appointment->appointment_date->format('M d') }}</span>
                            <span><i class="bi bi-clock"></i> {{ $appointment->appointment_date->format('h:i A') }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="modern-badge modern-badge-info" style="font-size: 0.8rem;"><i class="bi bi-calendar-check"></i> Scheduled</span>
                    </div>
                </div>
            @empty
                <div class="modern-empty-state" style="padding: 2.5rem 1.5rem;">
                    <div class="modern-empty-icon" style="width: 60px; height: 60px; font-size: 1.75rem;">
                        <i class="bi bi-calendar-heart"></i>
                    </div>
                    <h3 class="modern-empty-title" style="font-size: 1.05rem;">No upcoming appointments</h3>
                    <p class="modern-empty-text" style="font-size: 0.9rem;">No sessions scheduled for the next 7 days.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Concerns by Status -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon modern-page-icon-green" style="width: 40px; height: 40px; font-size: 1.1rem;">
                <i class="bi bi-pie-chart"></i>
            </div>
            <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Concerns by Status</h2>
        </div>
        
        @php
            $submitted = App\Models\Concern::where('status','submitted')->count();
            $scheduled = App\Models\Concern::where('status','scheduled')->count();
            $resolvedC = App\Models\Concern::where('status','resolved')->count();
        @endphp
        
        <canvas id="counselorDonut" style="max-height:200px; margin: 1.5rem 0;"></canvas>
        
        <div class="modern-list">
            <div class="modern-list-item" style="padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <div style="display: flex; align-items: center; gap: 0.75rem; flex: 1;">
                    <span class="rounded-circle d-inline-block" style="width:12px;height:12px;background:#f59e0b;"></span>
                    <span style="font-size: 0.9rem; font-weight: 500; color: #374151;">Pending</span>
                </div>
                <span style="font-weight: 600; font-size: 0.95rem; color: var(--navy);">{{ $submitted }}</span>
            </div>
            <div class="modern-list-item" style="padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <div style="display: flex; align-items: center; gap: 0.75rem; flex: 1;">
                    <span class="rounded-circle d-inline-block" style="width:12px;height:12px;background:#3b82f6;"></span>
                    <span style="font-size: 0.9rem; font-weight: 500; color: #374151;">Scheduled</span>
                </div>
                <span style="font-weight: 600; font-size: 0.95rem; color: var(--navy);">{{ $scheduled }}</span>
            </div>
            <div class="modern-list-item" style="padding: 0.75rem 0;">
                <div style="display: flex; align-items: center; gap: 0.75rem; flex: 1;">
                    <span class="rounded-circle d-inline-block" style="width:12px;height:12px;background:#22c55e;"></span>
                    <span style="font-size: 0.9rem; font-weight: 500; color: #374151;">Resolved</span>
                </div>
                <span style="font-weight: 600; font-size: 0.95rem; color: var(--navy);">{{ $resolvedC }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Case Management Grid -->
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-top: 1.5rem;">
    <!-- Incident Reports -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon modern-page-icon-green" style="width: 40px; height: 40px; font-size: 1.1rem;">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Incident Reports</h2>
            <a href="{{ route('counselor.incident-reports.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                View All
            </a>
        </div>
        
        <div class="modern-list">
            @php $reports = App\Models\IncidentReport::with('teacher')->latest()->take(4)->get(); @endphp
            @forelse($reports as $report)
                <div class="modern-list-item" style="padding: 1rem 0;">
                    <div style="flex: 1;">
                        <div style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">{{ $report->student_name }}</div>
                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; font-size: 0.8rem; color: var(--text-muted);">
                            <span class="modern-badge modern-badge-secondary">{{ $report->case_number }}</span>
                            <span>by {{ $report->teacher->name ?? '—' }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="modern-badge modern-badge-{{ $report->urgency_badge }}" style="font-size: 0.8rem; text-transform: capitalize;">{{ $report->urgency_level }}</span>
                    </div>
                </div>
            @empty
                <div class="modern-empty-state" style="padding: 2.5rem 1.5rem;">
                    <div class="modern-empty-icon" style="width: 60px; height: 60px; font-size: 1.75rem;">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h3 class="modern-empty-title" style="font-size: 1.05rem;">No incident reports</h3>
                    <p class="modern-empty-text" style="font-size: 0.9rem;">No incident reports have been submitted yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Student Referrals -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon modern-page-icon-green" style="width: 40px; height: 40px; font-size: 1.1rem;">
                <i class="bi bi-person-check"></i>
            </div>
            <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Student Referrals</h2>
            <a href="{{ route('counselor.referrals.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                View All
            </a>
        </div>
        
        <div class="modern-list">
            @php $referrals = App\Models\StudentReferral::with('teacher')->latest()->take(4)->get(); @endphp
            @forelse($referrals as $ref)
                <div class="modern-list-item" style="padding: 1rem 0;">
                    <div style="flex: 1;">
                        <div style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">{{ $ref->student_name }}</div>
                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; font-size: 0.8rem; color: var(--text-muted);">
                            <span class="modern-badge modern-badge-secondary">{{ $ref->referral_number }}</span>
                            <span>by {{ $ref->teacher->name ?? '—' }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="modern-badge modern-badge-{{ $ref->status_badge }}" style="font-size: 0.8rem; text-transform: capitalize;">{{ $ref->status }}</span>
                    </div>
                </div>
            @empty
                <div class="modern-empty-state" style="padding: 2.5rem 1.5rem;">
                    <div class="modern-empty-icon" style="width: 60px; height: 60px; font-size: 1.75rem;">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h3 class="modern-empty-title" style="font-size: 1.05rem;">No referrals</h3>
                    <p class="modern-empty-text" style="font-size: 0.9rem;">No student referrals have been submitted yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('counselorDonut'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Scheduled', 'Resolved'],
        datasets: [{ 
            data: [{{ $submitted }}, {{ $scheduled }}, {{ $resolvedC }}], 
            backgroundColor: ['#f59e0b','#3b82f6','#22c55e'], 
            borderWidth: 0 
        }]
    },
    options: { 
        cutout: '70%', 
        plugins: { 
            legend: { display: false } 
        } 
    }
});
</script>

<style>
/* Responsive adjustments */
@media (max-width: 1200px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"],
    div[style*="grid-template-columns: repeat(2, 1fr)"] {
        grid-template-columns: 1fr !important;
    }
    
    .modern-page-header-compact {
        flex-direction: column;
        align-items: flex-start !important;
    }
    
    .modern-list-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }
}
</style>
@endsection
