@extends('layouts.dashboard')
@section('title', 'Student Referrals')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Student Referrals</h5>
    </div>
    <div class="card-body">
        @if($referrals->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ref. No.</th>
                            <th>Student</th>
                            <th class="table-hide-mobile">Grade & Section</th>
                            <th class="table-hide-mobile">Reason</th>
                            <th class="table-hide-mobile">Submitted By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($referrals as $referral)
                            <tr>
                                <td>
                                    <strong style="color:#20B2AA;">{{ $referral->referral_number }}</strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($referral->student_name, 0, 2)) }}
                                        </div>
                                        <span>{{ $referral->student_name }}</span>
                                    </div>
                                </td>
                                <td class="table-hide-mobile">
                                    <small class="text-muted">{{ $referral->grade_section }}</small>
                                </td>
                                <td class="table-hide-mobile">
                                    <small class="text-muted">{{ Str::limit($referral->reason_for_referral, 60) }}</small>
                                </td>
                                <td class="table-hide-mobile">
                                    <small class="text-muted">{{ $referral->teacher->name ?? '—' }}</small>
                                </td>
                                <td>
                                    @if($referral->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($referral->status == 'ongoing')
                                        <span class="badge badge-info">Ongoing</span>
                                    @else
                                        <span class="badge badge-success">Closed</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('counselor.referrals.show', $referral) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($referrals->hasPages())
                <div class="mt-3">{{ $referrals->links() }}</div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-person-check" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h4 class="mt-3 text-muted">No Student Referrals</h4>
                <p class="text-muted">No student referrals have been submitted by teachers yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
