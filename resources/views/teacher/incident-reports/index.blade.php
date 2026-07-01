@extends('layouts.dashboard')
@section('title', 'Incident Reports')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h5 class="fw-bold mb-0">Incident Reports</h5>
        <small class="text-muted">All incident reports you have submitted</small>
    </div>
    <a href="{{ route('teacher.incident-reports.create') }}" class="btn text-white fw-semibold"
       style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
        <i class="bi bi-plus-lg me-1"></i> New Report
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius:16px;">
    <div class="card-body pb-0">
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search case no, student, grade..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending"  {{ request('status')=='pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="ongoing"  {{ request('status')=='ongoing'  ? 'selected' : '' }}>Ongoing</option>
                    <option value="closed"   {{ request('status')=='closed'   ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="urgency" class="form-select">
                    <option value="">All Urgency Levels</option>
                    <option value="low"      {{ request('urgency')=='low'      ? 'selected' : '' }}>Low</option>
                    <option value="moderate" {{ request('urgency')=='moderate' ? 'selected' : '' }}>Moderate</option>
                    <option value="high"     {{ request('urgency')=='high'     ? 'selected' : '' }}>High</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Filter</button>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-muted small">Case No.</th>
                        <th class="py-3 fw-semibold text-muted small">Student</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Category</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Date</th>
                        <th class="py-3 fw-semibold text-muted small">Urgency</th>
                        <th class="py-3 fw-semibold text-muted small">Status</th>
                        <th class="py-3 fw-semibold text-muted small">Actions</th>
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
                            <td class="py-3 table-hide-mobile">
                                <span class="small text-muted">{{ $report->incident_category_label }}</span>
                            </td>
                            <td class="py-3 table-hide-mobile small text-muted">
                                {{ $report->date_of_referral->format('M d, Y') }}
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $report->urgency_badge }} text-capitalize">{{ $report->urgency_level }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $report->status_badge }} text-capitalize">{{ $report->status }}</span>
                            </td>
                            <td class="py-3">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('teacher.incident-reports.show', $report) }}"
                                       class="btn btn-primary btn-sm py-1 px-2" style="font-size:.78rem;">
                                        <i class="bi bi-eye me-1"></i>View
                                    </a>
                                    @if($report->status === 'pending')
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete Report"
                                            onclick="confirmDelete(
                                                {{ $report->id }},
                                                '{{ $report->case_number }}',
                                                '{{ addslashes($report->student_name) }}',
                                                '{{ $report->date_of_referral->format('M d, Y') }}'
                                            )">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-sm btn-outline-secondary opacity-50"
                                            title="Cannot delete — report is {{ $report->status }}" disabled>
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No incident reports found.
                                <a href="{{ route('teacher.incident-reports.create') }}">Submit one now.</a>
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

{{-- Professional Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content border-0" style="border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,.18);">

            {{-- Danger stripe --}}
            <div style="height:5px;border-radius:20px 20px 0 0;background:linear-gradient(90deg,#ef4444,#dc2626);"></div>

            <div class="modal-body p-4">
                {{-- Icon --}}
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                         style="width:64px;height:64px;background:rgba(239,68,68,.1);">
                        <i class="bi bi-trash3-fill" style="font-size:1.6rem;color:#ef4444;"></i>
                    </div>
                    <h5 class="fw-bold mb-1" id="deleteModalLabel" style="color:#1e293b;">Delete Incident Report?</h5>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>

                {{-- Report details card --}}
                <div class="rounded-3 p-3 mb-4" style="background:#f8fafc;border:1px solid #e2e8f0;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="fw-bold small" style="color:#20B2AA;" id="del_case_no"></div>
                            <div class="fw-semibold" id="del_student" style="font-size:.95rem;color:#1e293b;"></div>
                        </div>
                        <span class="badge" style="background:#fef3c7;color:#92400e;border:1px solid #fbbf24;">Pending</span>
                    </div>
                    <div class="d-flex align-items-center gap-1 text-muted small">
                        <i class="bi bi-calendar3"></i>
                        <span id="del_date"></span>
                    </div>
                </div>

                <p class="small text-muted text-center mb-0">
                    Only <strong>pending</strong> reports can be deleted. Once deleted, the record and any attached files will be permanently removed.
                </p>
            </div>

            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                <button type="button" class="btn btn-secondary flex-fill" style="border-radius:10px;" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Cancel
                </button>
                <form id="deleteForm" method="POST" class="flex-fill">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100 fw-semibold" style="border-radius:10px;">
                        <i class="bi bi-trash3 me-1"></i> Yes, Delete Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, caseNo, student, date) {
    document.getElementById('del_case_no').textContent  = caseNo;
    document.getElementById('del_student').textContent  = student;
    document.getElementById('del_date').textContent     = date;
    document.getElementById('deleteForm').action = '/teacher/incident-reports/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

<style>
.pagination { margin: 0; gap: 3px; }
.pagination .page-link { border-radius: 8px !important; border: 1px solid #e2e8f0; color: #475569; font-size: 0.875rem; padding: 0.4rem 0.75rem; transition: all .2s; }
.pagination .page-link:hover { background: rgba(32,178,170,.1); border-color: #20B2AA; color: #20B2AA; }
.pagination .page-item.active .page-link { background: #20B2AA; border-color: #20B2AA; color: #fff; }
.pagination .page-item.disabled .page-link { opacity: .5; }
</style>

@endsection
