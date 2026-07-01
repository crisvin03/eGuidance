<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead style="background:#f8fafc;">
            <tr>
                <th class="px-4 py-3 fw-semibold text-muted small">
                    {{ $type === 'teacher' ? 'Teacher' : 'Student' }}
                </th>
                <th class="py-3 fw-semibold text-muted small">Date & Time</th>
                <th class="py-3 fw-semibold text-muted small table-hide-mobile">Source / Notes</th>
                <th class="py-3 fw-semibold text-muted small">Status</th>
                <th class="py-3 fw-semibold text-muted small">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($list as $appointment)
            <tr id="appt-row-{{ $appointment->id }}">
                <td class="px-4 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="user-avatar" style="{{ $type === 'teacher' ? 'background:linear-gradient(135deg,#6366f1,#4f46e5);' : '' }}">
                            {{ strtoupper(substr($appointment->student->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="fw-semibold small">{{ $appointment->student->name }}</div>
                            <div class="text-muted" style="font-size:.72rem;">
                                @if($type === 'teacher')
                                    <span class="badge" style="background:#ede9fe;color:#4f46e5;font-size:.65rem;">Teacher</span>
                                @else
                                    <span class="badge" style="background:rgba(32,178,170,.1);color:#20B2AA;font-size:.65rem;">Student</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </td>
                <td class="py-3">
                    <div class="fw-semibold small">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                    <div class="text-muted" style="font-size:.75rem;">{{ $appointment->appointment_date->format('h:i A') }}</div>
                </td>
                <td class="py-3 table-hide-mobile">
                    @if($appointment->concern_id)
                        <span class="badge mb-1" style="background:rgba(32,178,170,.12);color:#0f766e;border:1px solid #99f6e4;font-size:.72rem;">
                            <i class="bi bi-chat-left-heart me-1"></i>From Concern
                        </span>
                    @elseif($type === 'teacher')
                        <span class="badge mb-1" style="background:rgba(32,178,170,.12);color:#0f766e;border:1px solid #99f6e4;font-size:.72rem;">
                            <i class="bi bi-person-badge me-1"></i>Teacher Request
                        </span>
                    @else
                        <span class="badge mb-1" style="background:#f1f5f9;color:#475569;font-size:.72rem;">
                            <i class="bi bi-calendar-plus me-1"></i>Direct Booking
                        </span>
                    @endif
                    @if($appointment->notes)
                        <div class="text-muted small mt-1">{{ \Str::limit($appointment->notes, 45) }}</div>
                    @endif
                </td>
                <td class="py-3">
                    <span id="appt-status-{{ $appointment->id }}">
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
                    </span>
                </td>
                <td class="py-3">
                    <div class="d-flex gap-2 flex-wrap" id="appt-actions-{{ $appointment->id }}">
                        <a href="{{ route('counselor.appointments.show', $appointment->id) }}"
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-eye me-1"></i> View
                        </a>
                        @if($appointment->status === 'scheduled')
                            <button class="btn btn-sm text-white fw-semibold"
                                    style="background:linear-gradient(135deg,#20B2AA,#008B8B);"
                                    onclick="openConfirm({{ $appointment->id }})">
                                <i class="bi bi-check-circle me-1"></i>Confirm
                            </button>
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="openCancel({{ $appointment->id }})">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </button>
                        @elseif($appointment->status === 'confirmed')
                            <button class="btn btn-sm btn-warning fw-semibold"
                                    onclick="openComplete({{ $appointment->id }})">
                                <i class="bi bi-check2-all me-1"></i>Complete
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                    <i class="bi bi-calendar-x fs-2 d-block mb-2 opacity-50"></i>
                    No {{ $type === 'teacher' ? 'teacher' : 'student' }} appointments found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="px-4 py-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
    <small class="text-muted">
        @if($list->total() > 0)
            Showing <strong>{{ $list->firstItem() }}–{{ $list->lastItem() }}</strong>
            of <strong>{{ $list->total() }}</strong> appointments
        @else
            No records found
        @endif
    </small>
    @if($list->hasPages())
        <div>{{ $list->onEachSide(1)->links() }}</div>
    @endif
</div>
