@extends('layouts.dashboard')
@section('title', 'Student Referrals')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h5 class="fw-bold mb-0">Student Referrals</h5>
        <small class="text-muted">All referrals you have submitted</small>
    </div>
    <a href="{{ route('teacher.referrals.create') }}" class="btn text-white fw-semibold"
       style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
        <i class="bi bi-plus-lg me-1"></i> New Referral
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius:16px;">
    <div class="card-body pb-0">
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search ref no, student, grade..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
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
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-muted small">Ref. No.</th>
                        <th class="py-3 fw-semibold text-muted small">Student</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Reason</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Date</th>
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
                            <td class="py-3 table-hide-mobile">
                                <span class="small text-muted">{{ Str::limit($referral->reason_for_referral, 60) }}</span>
                            </td>
                            <td class="py-3 table-hide-mobile small text-muted">
                                {{ $referral->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $referral->status_badge }} text-capitalize">{{ $referral->status }}</span>
                            </td>
                            <td class="py-3">
                                <a href="{{ route('teacher.referrals.show', $referral) }}"
                                   class="btn btn-sm btn-outline-secondary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No referrals found. <a href="{{ route('teacher.referrals.create') }}">Refer a student now.</a>
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
@endsection
