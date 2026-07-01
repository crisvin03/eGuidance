@extends('layouts.dashboard')
@section('title', 'My Appointments')

@section('content')

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h5 class="fw-bold mb-0">My Appointments</h5>
        <small class="text-muted">All appointments you have scheduled with the counselor</small>
    </div>
    <a href="{{ route('teacher.talk-to-counselor') }}" class="btn text-white fw-semibold"
       style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
        <i class="bi bi-calendar-plus me-1"></i> Schedule New
    </a>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
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
            @if(request('status'))
            <div class="col-md-2">
                <a href="{{ route('teacher.appointments.index') }}" class="btn btn-secondary btn-sm w-100">Clear</a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius:16px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-muted small">Counselor</th>
                        <th class="py-3 fw-semibold text-muted small">Date & Time</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Purpose / Notes</th>
                        <th class="py-3 fw-semibold text-muted small">Status</th>
                        <th class="py-3 fw-semibold text-muted small">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-2">
                                @if($appointment->counselor->profile_photo)
                                    <img src="{{ asset('storage/'.$appointment->counselor->profile_photo) }}"
                                         class="rounded-circle" style="width:34px;height:34px;object-fit:cover;">
                                @else
                                    <div class="user-avatar" style="width:34px;height:34px;font-size:.75rem;">
                                        {{ strtoupper(substr($appointment->counselor->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold small">{{ $appointment->counselor->name }}</div>
                                    <div class="text-muted" style="font-size:.72rem;">Guidance Counselor</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="fw-semibold small">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                            <div class="text-muted" style="font-size:.75rem;">{{ $appointment->appointment_date->format('h:i A') }}</div>
                        </td>
                        <td class="py-3 table-hide-mobile">
                            <span class="small text-muted">{{ $appointment->notes ? \Str::limit($appointment->notes, 60) : '—' }}</span>
                        </td>
                        <td class="py-3">
                            @php
                                $badge = match($appointment->status) {
                                    'confirmed' => ['bg'=>'#eff6ff','color'=>'#1e40af','border'=>'#93c5fd','label'=>'Confirmed'],
                                    'completed' => ['bg'=>'#ecfdf5','color'=>'#065f46','border'=>'#6ee7b7','label'=>'Completed'],
                                    'cancelled' => ['bg'=>'#fef2f2','color'=>'#991b1b','border'=>'#fca5a5','label'=>'Cancelled'],
                                    default     => ['bg'=>'#fef3c7','color'=>'#92400e','border'=>'#fbbf24','label'=>'Scheduled'],
                                };
                            @endphp
                            <span class="badge fw-semibold"
                                  style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};border:1px solid {{ $badge['border'] }};">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td class="py-3">
                            <a href="{{ route('teacher.appointments.show', $appointment) }}"
                               class="btn btn-primary btn-sm py-1 px-2" style="font-size:.78rem;"><i class="bi bi-eye me-1"></i>View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-2 d-block mb-2 opacity-50"></i>
                            No appointments found.
                            <a href="{{ route('teacher.talk-to-counselor') }}" style="color:#20B2AA;">Schedule one now.</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
            <small class="text-muted">
                @if($appointments->total() > 0)
                    Showing <strong>{{ $appointments->firstItem() }}–{{ $appointments->lastItem() }}</strong>
                    of <strong>{{ $appointments->total() }}</strong> appointments
                @else
                    No records found
                @endif
            </small>
            @if($appointments->hasPages())
                <div>{{ $appointments->onEachSide(1)->links() }}</div>
            @endif
        </div>
    </div>
</div>

<style>
.pagination { margin:0; gap:3px; }
.pagination .page-link { border-radius:8px !important; border:1px solid #e2e8f0; color:#475569; font-size:.875rem; padding:.4rem .75rem; transition:all .2s; }
.pagination .page-link:hover { background:rgba(32,178,170,.1); border-color:#20B2AA; color:#20B2AA; }
.pagination .page-item.active .page-link { background:#20B2AA; border-color:#20B2AA; color:#fff; }
.pagination .page-item.disabled .page-link { opacity:.5; }
</style>

@endsection
