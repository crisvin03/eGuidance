@extends('layouts.dashboard')
@section('title', 'Incident Reports')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Incident Reports</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search case no, student, grade..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ongoing" {{ request('status')=='ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="closed" {{ request('status')=='closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="urgency" class="form-select">
                    <option value="">All Urgency Levels</option>
                    <option value="low" {{ request('urgency')=='low' ? 'selected' : '' }}>Low</option>
                    <option value="moderate" {{ request('urgency')=='moderate' ? 'selected' : '' }}>Moderate</option>
                    <option value="high" {{ request('urgency')=='high' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Filter</button>
            </div>
        </form>
        
        @if($reports->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Case No.</th>
                            <th>Student</th>
                            <th class="table-hide-mobile">Grade & Section</th>
                            <th>Category</th>
                            <th class="table-hide-mobile">Submitted By</th>
                            <th>Urgency</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>
                                    <strong style="color:#20B2AA;">{{ $report->case_number }}</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($report->student_name, 0, 2)) }}
                                        </div>
                                        <span>{{ $report->student_name }}</span>
                                    </div>
                                </td>
                                <td class="table-hide-mobile">
                                    <small class="text-muted">{{ $report->grade_section }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $report->incident_category_label }}</span>
                                </td>
                                <td class="table-hide-mobile">
                                    <small class="text-muted">{{ $report->teacher->name ?? '—' }}</small>
                                </td>
                                <td>
                                    @if($report->urgency_level == 'high')
                                        <span class="badge badge-danger">High</span>
                                    @elseif($report->urgency_level == 'moderate')
                                        <span class="badge badge-warning">Moderate</span>
                                    @else
                                        <span class="badge badge-success">Low</span>
                                    @endif
                                </td>
                                <td>
                                    @if($report->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($report->status == 'ongoing')
                                        <span class="badge badge-info">Ongoing</span>
                                    @else
                                        <span class="badge badge-success">Closed</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('counselor.incident-reports.show', $report) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i> View
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ route('counselor.incident-reports.destroy', $report) }}', '{{ $report->case_number }}', 'incident report')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($reports->hasPages())
                <div class="mt-3">{{ $reports->links() }}</div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-text" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h4 class="mt-3 text-muted">No Incident Reports</h4>
                <p class="text-muted">No incident reports have been submitted by teachers yet.</p>
            </div>
        @endif
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0" style="border-radius:20px;overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,0.18);">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <div style="width:60px;height:60px;background:rgba(239,68,68,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                        <i class="bi bi-trash3-fill text-danger fs-4"></i>
                    </div>
                </div>
                <h6 class="fw-bold mb-1">Delete <span id="deleteItemType"></span>?</h6>
                <p class="text-muted small mb-3"><strong id="deleteItemName" class="text-dark"></strong><br>This action cannot be undone.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm px-3">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function confirmDelete(url, name, type) {
    document.getElementById('deleteForm').action = url;
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('deleteItemType').textContent = type;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection
