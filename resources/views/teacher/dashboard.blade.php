@extends('layouts.dashboard')
@section('title', 'Teacher Dashboard')

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
    div[style*="display: grid"][style*="grid-template-columns: repeat(4"] { grid-template-columns: repeat(2, 1fr) !important; }
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
            <p class="modern-page-subtitle">CARE Konek Teacher Portal — {{ now()->format('l, F d, Y') }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('teacher.incident-reports.create') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-file-earmark-plus"></i>
                <span>New Report</span>
            </a>
            <a href="{{ route('teacher.referrals.create') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-person-plus"></i>
                <span>Refer Student</span>
            </a>
        </div>
    </div>
</div>

<!-- Status Cards Grid -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">
    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-file-earmark-text"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $totalReports }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Total Reports</div>
        </div>
        <a href="{{ route('teacher.incident-reports.index') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-hourglass-split"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $pendingReports }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Pending</div>
        </div>
        <a href="{{ route('teacher.incident-reports.index', ['status' => 'pending']) }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-person-check"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $totalReferrals }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Referrals</div>
        </div>
        <a href="{{ route('teacher.referrals.index') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-clock-history"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $pendingReferrals }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Pending</div>
        </div>
        <a href="{{ route('teacher.referrals.index', ['status' => 'pending']) }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Activity Overview Chart -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <div class="modern-section-header" style="margin-bottom: 1.25rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 40px; height: 40px; font-size: 1.1rem;">
            <i class="bi bi-bar-chart-fill"></i>
        </div>
        <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Activity Overview</h2>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
        <!-- Reports Chart -->
        <div>
            <div style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 1rem;">Incident Reports by Status</div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @php
                    $pending = \App\Models\IncidentReport::where('teacher_id', Auth::id())->where('status', 'pending')->count();
                    $ongoing = \App\Models\IncidentReport::where('teacher_id', Auth::id())->where('status', 'ongoing')->count();
                    $closed = \App\Models\IncidentReport::where('teacher_id', Auth::id())->where('status', 'closed')->count();
                    $total = $pending + $ongoing + $closed;
                    $pendingPercent = $total > 0 ? ($pending / $total) * 100 : 0;
                    $ongoingPercent = $total > 0 ? ($ongoing / $total) * 100 : 0;
                    $closedPercent = $total > 0 ? ($closed / $total) * 100 : 0;
                @endphp
                
                <!-- Pending -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="bi bi-clock-fill" style="color: #f59e0b;"></i> Pending
                        </span>
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--navy);">{{ $pending }} ({{ round($pendingPercent) }}%)</span>
                    </div>
                    <div style="height: 8px; background: #f3f4f6; border-radius: 10px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $pendingPercent }}%; background: linear-gradient(90deg, #fbbf24, #f59e0b); border-radius: 10px; transition: width 0.3s;"></div>
                    </div>
                </div>
                
                <!-- Ongoing -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="bi bi-arrow-repeat" style="color: #3b82f6;"></i> Ongoing
                        </span>
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--navy);">{{ $ongoing }} ({{ round($ongoingPercent) }}%)</span>
                    </div>
                    <div style="height: 8px; background: #f3f4f6; border-radius: 10px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $ongoingPercent }}%; background: linear-gradient(90deg, #60a5fa, #3b82f6); border-radius: 10px; transition: width 0.3s;"></div>
                    </div>
                </div>
                
                <!-- Closed -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="bi bi-check-circle-fill" style="color: #1e7a4a;"></i> Closed
                        </span>
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--navy);">{{ $closed }} ({{ round($closedPercent) }}%)</span>
                    </div>
                    <div style="height: 8px; background: #f3f4f6; border-radius: 10px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $closedPercent }}%; background: linear-gradient(90deg, #34d399, #1e7a4a); border-radius: 10px; transition: width 0.3s;"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Referrals Chart -->
        <div>
            <div style="font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 1rem;">Student Referrals by Status</div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @php
                    $refPending = \App\Models\StudentReferral::where('teacher_id', Auth::id())->where('status', 'pending')->count();
                    $refOngoing = \App\Models\StudentReferral::where('teacher_id', Auth::id())->where('status', 'ongoing')->count();
                    $refClosed = \App\Models\StudentReferral::where('teacher_id', Auth::id())->where('status', 'closed')->count();
                    $refTotal = $refPending + $refOngoing + $refClosed;
                    $refPendingPercent = $refTotal > 0 ? ($refPending / $refTotal) * 100 : 0;
                    $refOngoingPercent = $refTotal > 0 ? ($refOngoing / $refTotal) * 100 : 0;
                    $refClosedPercent = $refTotal > 0 ? ($refClosed / $refTotal) * 100 : 0;
                @endphp
                
                <!-- Pending -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="bi bi-clock-fill" style="color: #f59e0b;"></i> Pending
                        </span>
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--navy);">{{ $refPending }} ({{ round($refPendingPercent) }}%)</span>
                    </div>
                    <div style="height: 8px; background: #f3f4f6; border-radius: 10px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $refPendingPercent }}%; background: linear-gradient(90deg, #fbbf24, #f59e0b); border-radius: 10px; transition: width 0.3s;"></div>
                    </div>
                </div>
                
                <!-- Ongoing -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="bi bi-arrow-repeat" style="color: #3b82f6;"></i> Ongoing
                        </span>
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--navy);">{{ $refOngoing }} ({{ round($refOngoingPercent) }}%)</span>
                    </div>
                    <div style="height: 8px; background: #f3f4f6; border-radius: 10px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $refOngoingPercent }}%; background: linear-gradient(90deg, #60a5fa, #3b82f6); border-radius: 10px; transition: width 0.3s;"></div>
                    </div>
                </div>
                
                <!-- Closed -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="bi bi-check-circle-fill" style="color: #1e7a4a;"></i> Closed
                        </span>
                        <span style="font-size: 0.8rem; font-weight: 600; color: var(--navy);">{{ $refClosed }} ({{ round($refClosedPercent) }}%)</span>
                    </div>
                    <div style="height: 8px; background: #f3f4f6; border-radius: 10px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $refClosedPercent }}%; background: linear-gradient(90deg, #34d399, #1e7a4a); border-radius: 10px; transition: width 0.3s;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Summary Stats -->
    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
            <div style="text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--green);">{{ $total }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Total Reports</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--green);">{{ $refTotal }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Total Referrals</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--green);">{{ $closed + $refClosed }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Resolved Cases</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
    <!-- Recent Incident Reports -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon modern-page-icon-green" style="width: 40px; height: 40px; font-size: 1.1rem;">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Recent Incident Reports</h2>
            <a href="{{ route('teacher.incident-reports.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                View All
            </a>
        </div>
        
        <div class="modern-list">
            @forelse($recentReports as $report)
                <a href="{{ route('teacher.incident-reports.show', $report) }}" class="text-decoration-none">
                    <div class="modern-list-item" style="padding: 1rem 0;">
                        <div style="flex: 1;">
                            <div style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">{{ $report->student_name }}</div>
                            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; font-size: 0.8rem; color: var(--text-muted);">
                                <span><i class="bi bi-book"></i> {{ $report->grade_section }}</span>
                                <span><i class="bi bi-hash"></i> {{ $report->case_number }}</span>
                                <span><i class="bi bi-calendar3"></i> {{ $report->date_of_referral->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: end; gap: 0.5rem;">
                            @if($report->urgency_level == 'high')
                                <span class="modern-badge modern-badge-danger" style="font-size: 0.8rem;"><i class="bi bi-exclamation-triangle-fill"></i> High</span>
                            @elseif($report->urgency_level == 'medium')
                                <span class="modern-badge modern-badge-warning" style="font-size: 0.8rem;"><i class="bi bi-exclamation-circle-fill"></i> Medium</span>
                            @else
                                <span class="modern-badge modern-badge-info" style="font-size: 0.8rem;"><i class="bi bi-info-circle-fill"></i> Low</span>
                            @endif
                            
                            @if($report->status == 'pending')
                                <span class="modern-badge modern-badge-warning" style="font-size: 0.8rem;"><i class="bi bi-clock-fill"></i> Pending</span>
                            @elseif($report->status == 'ongoing')
                                <span class="modern-badge modern-badge-info" style="font-size: 0.8rem;"><i class="bi bi-arrow-repeat"></i> Ongoing</span>
                            @else
                                <span class="modern-badge modern-badge-success" style="font-size: 0.8rem;"><i class="bi bi-check-circle-fill"></i> Closed</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="modern-empty-state" style="padding: 2.5rem 1.5rem;">
                    <div class="modern-empty-icon" style="width: 60px; height: 60px; font-size: 1.75rem;">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h3 class="modern-empty-title" style="font-size: 1.05rem;">No incident reports yet</h3>
                    <p class="modern-empty-text" style="font-size: 0.9rem;">Start by creating your first incident report.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Recent Referrals -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon modern-page-icon-green" style="width: 40px; height: 40px; font-size: 1.1rem;">
                <i class="bi bi-person-check"></i>
            </div>
            <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Recent Referrals</h2>
            <a href="{{ route('teacher.referrals.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                View All
            </a>
        </div>
        
        <div class="modern-list">
            @forelse($recentReferrals as $referral)
                <a href="{{ route('teacher.referrals.show', $referral) }}" class="text-decoration-none">
                    <div class="modern-list-item" style="padding: 1rem 0;">
                        <div style="flex: 1;">
                            <div style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">{{ $referral->student_name }}</div>
                            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; font-size: 0.8rem; color: var(--text-muted);">
                                <span><i class="bi bi-book"></i> {{ $referral->grade_section }}</span>
                                <span><i class="bi bi-hash"></i> {{ $referral->referral_number }}</span>
                                <span><i class="bi bi-calendar3"></i> {{ $referral->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div>
                            @if($referral->status == 'pending')
                                <span class="modern-badge modern-badge-warning" style="font-size: 0.8rem;"><i class="bi bi-clock-fill"></i> Pending</span>
                            @elseif($referral->status == 'ongoing')
                                <span class="modern-badge modern-badge-info" style="font-size: 0.8rem;"><i class="bi bi-arrow-repeat"></i> Ongoing</span>
                            @else
                                <span class="modern-badge modern-badge-success" style="font-size: 0.8rem;"><i class="bi bi-check-circle-fill"></i> Closed</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="modern-empty-state" style="padding: 2.5rem 1.5rem;">
                    <div class="modern-empty-icon" style="width: 60px; height: 60px; font-size: 1.75rem;">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h3 class="modern-empty-title" style="font-size: 1.05rem;">No referrals yet</h3>
                    <p class="modern-empty-text" style="font-size: 0.9rem;">Start by referring your first student.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
