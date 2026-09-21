@extends('layouts.dashboard')

@section('title', 'Tambayan')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon">
            <i class="bi bi-chat-dots-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title">Tambayan</h1>
            <p class="modern-page-subtitle">Connect with counselors, teachers, and peers</p>
        </div>
        <a href="{{ route('messages.create') }}" class="modern-btn modern-btn-primary">
            <i class="bi bi-plus-circle"></i>
            <span>New Message</span>
        </a>
    </div>
</div>

<!-- Conversations List -->
<div class="modern-card">
    @forelse($conversations as $conversation)
        @php
            $other = $conversation->getOtherUser(Auth::id());
            $unreadCount = $conversation->unreadCount(Auth::id());
            $latestMessage = $conversation->latestMessage;
        @endphp
        <a href="{{ route('messages.show', $other->id) }}" class="conversation-link">
            <div class="conversation-item @if($unreadCount > 0) unread @endif">
                <div class="d-flex align-items-center gap-3">
                    <!-- Avatar -->
                    <div class="conversation-avatar">
                        {{ substr($other->name, 0, 1) }}
                        @if($unreadCount > 0)
                            <span class="conversation-badge">{{ $unreadCount }}</span>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="conversation-content">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div>
                                <h6 class="conversation-name">{{ $other->name }}</h6>
                                <small class="conversation-role">{{ ucfirst($other->role->name ?? 'User') }}</small>
                            </div>
                            @if($latestMessage)
                                <small class="conversation-time">{{ $latestMessage->created_at->diffForHumans() }}</small>
                            @endif
                        </div>
                        @if($latestMessage)
                            <div class="conversation-preview @if($unreadCount > 0) unread-message @endif">
                                <i class="bi bi-{{ $latestMessage->sender_id == Auth::id() ? 'check-all' : 'arrow-down-left' }}"></i>
                                @if($latestMessage->attachment && !$latestMessage->message)
                                    <span class="text-muted"><i class="bi bi-image"></i> Photo</span>
                                @else
                                    <span>{{ Str::limit($latestMessage->message, 50) }}</span>
                                @endif
                            </div>
                        @else
                            <div class="conversation-preview text-muted">
                                <i class="bi bi-chat-dots"></i>
                                <span>No messages yet</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="modern-empty-state">
            <div class="modern-empty-icon">
                <i class="bi bi-chat-dots"></i>
            </div>
            <h6 class="modern-empty-title">No conversations yet</h6>
            <p class="modern-empty-text">Start chatting with counselors and peers</p>
            <a href="{{ route('messages.create') }}" class="modern-btn modern-btn-primary" style="margin-top: 1rem;">
                <i class="bi bi-plus-circle"></i>
                <span>Start Conversation</span>
            </a>
        </div>
    @endforelse
</div>

<style>
/* Conversation List Styles */
.conversation-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.conversation-item {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
}

.conversation-item:hover {
    background: linear-gradient(135deg, rgba(30, 122, 74, 0.03), rgba(20, 94, 56, 0.03));
    transform: translateX(4px);
}

.conversation-item.unread {
    background: linear-gradient(135deg, rgba(30, 122, 74, 0.05), rgba(20, 94, 56, 0.05));
}

.conversation-item:last-child {
    border-bottom: none;
}

.conversation-avatar {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--green), var(--green-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.25rem;
    flex-shrink: 0;
    position: relative;
    box-shadow: 0 2px 8px rgba(30, 122, 74, 0.2);
}

.conversation-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: #ef4444;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 600;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.conversation-content {
    flex: 1;
    min-width: 0;
}

.conversation-name {
    font-size: 1rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.125rem;
}

.conversation-role {
    font-size: 0.8rem;
    color: #6b7280;
    text-transform: capitalize;
}

.conversation-time {
    font-size: 0.75rem;
    color: #9ca3af;
    white-space: nowrap;
}

.conversation-preview {
    font-size: 0.875rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    margin-top: 0.25rem;
}

.conversation-preview i {
    font-size: 0.875rem;
    flex-shrink: 0;
}

.conversation-preview span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.conversation-preview.unread-message {
    color: #111827;
    font-weight: 500;
}

/* New Message Button */
.modern-btn-primary {
    white-space: nowrap;
}

/* Responsive */
@media (max-width: 768px) {
    .modern-page-header-compact {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .modern-btn-primary {
        width: 100%;
        justify-content: center;
    }
    
    .conversation-item {
        padding: 1rem;
    }
    
    .conversation-avatar {
        width: 48px;
        height: 48px;
        font-size: 1.1rem;
    }
    
    .conversation-badge {
        width: 20px;
        height: 20px;
        font-size: 0.65rem;
    }
    
    .conversation-name {
        font-size: 0.95rem;
    }
    
    .conversation-preview {
        font-size: 0.8rem;
    }
}
</style>

<script>
// Poll for unread messages every 10 seconds
setInterval(function() {
    fetch('{{ route('messages.unread-count') }}')
        .then(response => response.json())
        .then(data => {
            const currentUnread = {{ $conversations->sum(fn($c) => $c->unreadCount(Auth::id())) }};
            if (data.count > 0 && data.count !== currentUnread) {
                // Reload page if there are new messages
                location.reload();
            }
        })
        .catch(error => console.error('Error checking unread messages:', error));
}, 10000);
</script>
@endsection
