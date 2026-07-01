@extends('layouts.dashboard')

@section('title', 'My Appointments')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius:16px;">
    <div class="card-header bg-white px-4 pt-4 pb-0 border-0">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-bold mb-0">Appointments</h5>
                <small class="text-muted">Manage student and teacher appointments</small>
            </div>
        </div>

        {{-- Filters --}}
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search by name or notes..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="scheduled" {{ request('status')=='scheduled' ? 'selected':'' }}>Scheduled</option>
                    <option value="confirmed" {{ request('status')=='confirmed' ? 'selected':'' }}>Confirmed</option>
                    <option value="completed" {{ request('status')=='completed' ? 'selected':'' }}>Completed</option>
                    <option value="cancelled" {{ request('status')=='cancelled' ? 'selected':'' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
            </div>
            @if(request('search') || request('status'))
            <div class="col-md-2">
                <a href="{{ route('counselor.appointments.index') }}" class="btn btn-secondary btn-sm w-100">Clear</a>
            </div>
            @endif
        </form>

        {{-- Tabs --}}
        <ul class="nav nav-tabs border-0 gap-1" id="apptTabs">
            <li class="nav-item">
                <a class="nav-link active fw-semibold px-3" href="#" data-tab="students"
                   style="border-radius:8px 8px 0 0;font-size:.875rem;">
                    <i class="bi bi-person me-1"></i>Student Appointments
                    <span class="badge rounded-pill ms-1" style="background:#20B2AA;color:#fff;font-size:.65rem;">
                        {{ $appointments->total() }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold px-3" href="#" data-tab="teachers"
                   style="border-radius:8px 8px 0 0;font-size:.875rem;">
                    <i class="bi bi-person-badge me-1"></i>Teacher Appointments
                    <span class="badge rounded-pill ms-1" style="background:#20B2AA;color:#fff;font-size:.65rem;">
                        {{ $teacherAppointments->total() }}
                    </span>
                </a>
            </li>
        </ul>
    </div>

    <div class="card-body p-0">

        {{-- STUDENT APPOINTMENTS TAB --}}
        <div id="tab-students">
            @include('counselor.appointments._table', ['list' => $appointments, 'type' => 'student'])
        </div>

        {{-- TEACHER APPOINTMENTS TAB --}}
        <div id="tab-teachers" style="display:none;">
            @include('counselor.appointments._table', ['list' => $teacherAppointments, 'type' => 'teacher'])
        </div>

    </div>
</div>

@include('counselor.appointments._modals')

<script>
document.querySelectorAll('#apptTabs .nav-link').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        document.querySelectorAll('#apptTabs .nav-link').forEach(l => l.classList.remove('active'));
        link.classList.add('active');
        const tab = link.dataset.tab;
        document.getElementById('tab-students').style.display = tab === 'students' ? 'block' : 'none';
        document.getElementById('tab-teachers').style.display = tab === 'teachers' ? 'block' : 'none';
    });
});
</script>

<style>
#apptTabs .nav-link { color:#475569; border:none; border-bottom:2px solid transparent; border-radius:0 !important; padding:.5rem 1rem; transition:all .2s; }
#apptTabs .nav-link:hover { color:#20B2AA; background:rgba(32,178,170,.07); }
#apptTabs .nav-link.active { color:#20B2AA; border-bottom-color:#20B2AA; background:transparent; font-weight:700; }
.pagination { margin:0; gap:3px; }
.pagination .page-link { border-radius:8px !important; border:1px solid #e2e8f0; color:#475569; font-size:.875rem; padding:.4rem .75rem; transition:all .2s; }
.pagination .page-link:hover { background:rgba(32,178,170,.1); border-color:#20B2AA; color:#20B2AA; }
.pagination .page-item.active .page-link { background:#20B2AA; border-color:#20B2AA; color:#fff; }
.pagination .page-item.disabled .page-link { opacity:.5; }
</style>

@endsection
