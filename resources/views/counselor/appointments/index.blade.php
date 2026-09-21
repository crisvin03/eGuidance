@extends('layouts.dashboard')

@section('title', 'My Appointments')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-page-header-compact { flex-direction: column !important; align-items: flex-start !important; gap: 1rem !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    .modern-stats-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 0.75rem !important; }
    .modern-tabs { flex-wrap: wrap !important; }
    .modern-tab { padding: 0.625rem 1rem !important; font-size: 0.875rem !important; }
    div[style*="display: grid"][style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
    
    /* Filter Form - Stack Vertically */
    .filter-form {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.75rem !important;
        align-items: stretch !important;
        grid-template-columns: unset !important;
    }
    .filter-form > div {
        width: 100% !important;
    }
    .filter-form .form-control,
    .filter-form .form-select {
        width: 100% !important;
        border-radius: 0.5rem !important;
    }
    .filter-form .modern-btn,
    .filter-form button[type="submit"] {
        width: 100% !important;
        border-radius: 0.5rem !important;
    }
    
    /* Table Actions - Icon Only */
    .btn.btn-sm span:not(.bi) { display: none !important; }
    .btn.btn-sm { padding: 0.375rem 0.75rem !important; min-width: auto !important; }
    
    .table-responsive { font-size: 0.875rem !important; }
    .badge { font-size: 0.7rem !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-calendar-check-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">My Appointments</h1>
            <p class="modern-page-subtitle">Manage student and teacher appointments</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <form method="GET" class="filter-form" style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Search by name or notes..." value="{{ request('search') }}" style="border-radius: 10px;">
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Status</label>
            <select name="status" class="form-select" style="border-radius: 10px;">
                <option value="">All Statuses</option>
                <option value="scheduled" {{ request('status')=='scheduled' ? 'selected':'' }}>Scheduled</option>
                <option value="confirmed" {{ request('status')=='confirmed' ? 'selected':'' }}>Confirmed</option>
                <option value="completed" {{ request('status')=='completed' ? 'selected':'' }}>Completed</option>
                <option value="cancelled" {{ request('status')=='cancelled' ? 'selected':'' }}>Cancelled</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('counselor.appointments.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Tabs -->
<div class="modern-card" style="padding: 0; margin-bottom: 1.5rem; overflow: hidden;">
    <div style="display: flex; border-bottom: 2px solid #e5e7eb; background: #f9fafb;">
        <button class="tab-btn active" data-tab="students" style="flex: 1; padding: 1rem 1.5rem; font-size: 0.95rem; font-weight: 600; color: var(--navy); background: transparent; border: none; border-bottom: 3px solid var(--green); cursor: pointer; transition: all 0.2s;">
            <i class="bi bi-person-fill me-2"></i>Student Appointments
            <span class="modern-badge modern-badge-success" style="font-size: 0.75rem; margin-left: 0.5rem;">{{ $appointments->total() }}</span>
        </button>
        <button class="tab-btn" data-tab="teachers" style="flex: 1; padding: 1rem 1.5rem; font-size: 0.95rem; font-weight: 600; color: #6b7280; background: transparent; border: none; border-bottom: 3px solid transparent; cursor: pointer; transition: all 0.2s;">
            <i class="bi bi-person-badge-fill me-2"></i>Teacher Appointments
            <span class="modern-badge" style="background: rgba(107, 114, 128, 0.1); color: #6b7280; font-size: 0.75rem; margin-left: 0.5rem;">{{ $teacherAppointments->total() }}</span>
        </button>
    </div>
</div>

<!-- Student Appointments Tab -->
<div id="tab-students" class="tab-content">
    <div class="modern-card" style="padding: 1.5rem;">
        @include('counselor.appointments._table', ['list' => $appointments, 'type' => 'student'])
    </div>
</div>

<!-- Teacher Appointments Tab -->
<div id="tab-teachers" class="tab-content" style="display: none;">
    <div class="modern-card" style="padding: 1.5rem;">
        @include('counselor.appointments._table', ['list' => $teacherAppointments, 'type' => 'teacher'])
    </div>
</div>

@include('counselor.appointments._modals')

<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // Update button styles
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.style.color = '#6b7280';
            b.style.borderBottomColor = 'transparent';
            b.classList.remove('active');
            const badge = b.querySelector('.modern-badge');
            if (badge) {
                badge.style.background = 'rgba(107, 114, 128, 0.1)';
                badge.style.color = '#6b7280';
            }
        });
        
        btn.style.color = 'var(--navy)';
        btn.style.borderBottomColor = 'var(--green)';
        btn.classList.add('active');
        const badge = btn.querySelector('.modern-badge');
        if (badge) {
            badge.style.background = 'rgba(30, 122, 74, 0.1)';
            badge.style.color = 'var(--green)';
        }
        
        // Show/hide content
        const tab = btn.dataset.tab;
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        document.getElementById('tab-' + tab).style.display = 'block';
    });
});
</script>

<style>
.tab-btn:hover {
    color: var(--green) !important;
    background: rgba(30, 122, 74, 0.05);
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: 2fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
    
    .tab-btn {
        font-size: 0.85rem !important;
        padding: 0.75rem 1rem !important;
    }
    
    .tab-btn i {
        display: none;
    }
}
</style>

@endsection
