@extends('layouts.dashboard')

@section('title', 'New Message')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-pencil-square"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">New Message</h1>
            <p class="modern-page-subtitle">Start a conversation</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="modern-card" style="padding: 1.5rem;">
            <!-- Search Users -->
            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size: 0.9rem;">Search User</label>
                <div class="position-relative">
                    <input 
                        type="text" 
                        id="userSearch" 
                        class="form-control" 
                        placeholder="Search by name or email..."
                        style="border-radius:12px;padding:0.75rem 0.875rem 0.75rem 2.75rem;font-size:0.9rem;">
                    <i class="bi bi-search position-absolute" style="left:1rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:1rem;"></i>
                </div>
                
                <!-- Search Results -->
                <div id="searchResults" class="mt-3" style="display:none;">
                    <div class="list-group" id="usersList"></div>
                </div>
            </div>

            <!-- Available Users -->
            @if($users->count() > 0)
                <div>
                    <h6 class="fw-semibold mb-3" style="font-size: 1rem; color: var(--text-primary);">
                        <i class="bi bi-people me-2" style="font-size: 1.1rem;"></i>
                        @if(Auth::user()->isStudent())
                            Available Counselors & Teachers
                        @elseif(Auth::user()->isTeacher())
                            Available Counselors & Students
                        @else
                            Available Users
                        @endif
                    </h6>
                    
                    <div class="list-group">
                        @foreach($users as $user)
                            <a href="{{ route('messages.show', $user->id) }}" class="list-group-item list-group-item-action border-0 mb-2" style="border-radius:12px;padding:1rem;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle-md">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-semibold" style="font-size: 1rem;">{{ $user->name }}</h6>
                                        <small class="text-muted" style="font-size: 0.8rem;">
                                            <i class="bi bi-person-badge me-1"></i>
                                            {{ ucfirst($user->role->name ?? 'User') }}
                                            @if($user->role->name === 'counselor')
                                                <span class="badge bg-success ms-2" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">Counselor</span>
                                            @elseif($user->role->name === 'teacher')
                                                <span class="badge bg-info ms-2" style="font-size: 0.7rem; padding: 0.25rem 0.5rem;">Teacher</span>
                                            @endif
                                        </small>
                                    </div>
                                    <div>
                                        <i class="bi bi-chat-dots text-primary" style="font-size: 1.25rem;"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="modern-empty-state">
                    <div class="modern-empty-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h6 class="modern-empty-title">No users available</h6>
                    <p class="modern-empty-text">There are no users available to message at this time.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Quick Tips -->
        <div class="modern-card mb-3" style="background:rgba(30,122,74,0.08);border:none;padding:1.5rem;">
            <h6 class="fw-semibold mb-3" style="font-size: 1rem; color: var(--text-primary);">
                <i class="bi bi-lightbulb text-success me-2" style="font-size: 1.1rem;"></i>
                Quick Tips
            </h6>
            <ul class="mb-0 ps-3" style="font-size: 0.85rem;line-height:1.8;">
                <li class="mb-2">Messages are private and secure</li>
                <li class="mb-2">Counselors typically respond within 24 hours</li>
                <li class="mb-2">For urgent matters, visit the guidance office</li>
                <li>Be respectful and professional</li>
            </ul>
        </div>

        <!-- Who Can I Message? -->
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 class="fw-semibold mb-3" style="font-size: 1rem; color: var(--text-primary);">
                <i class="bi bi-question-circle me-2" style="font-size: 1.1rem;"></i>
                Who can I message?
            </h6>
            <div style="font-size: 0.85rem;line-height:1.8;">
                @if(Auth::user()->isStudent())
                    <p class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>All counselors</p>
                    <p class="mb-0"><i class="bi bi-check-circle text-success me-2"></i>Your teachers</p>
                @elseif(Auth::user()->isTeacher())
                    <p class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>All counselors</p>
                    <p class="mb-0"><i class="bi bi-check-circle text-success me-2"></i>Your students</p>
                @else
                    <p class="mb-0"><i class="bi bi-check-circle text-success me-2"></i>Everyone</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle-md {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #1e7a4a, #145e38);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.list-group-item {
    transition: all 0.2s;
}

.list-group-item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

#searchResults .list-group-item {
    cursor: pointer;
}
</style>

<script>
let searchTimeout;

document.getElementById('userSearch').addEventListener('input', function() {
    const query = this.value.trim();
    const searchResults = document.getElementById('searchResults');
    const usersList = document.getElementById('usersList');
    
    // Clear previous timeout
    clearTimeout(searchTimeout);
    
    if (query.length < 2) {
        searchResults.style.display = 'none';
        return;
    }
    
    // Debounce search
    searchTimeout = setTimeout(() => {
        fetch(`{{ route('messages.search-users') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(users => {
                if (users.length === 0) {
                    usersList.innerHTML = `
                        <div class="list-group-item text-center text-muted" style="border-radius:12px;padding:1.5rem;font-size:0.85rem;">
                            No users found
                        </div>
                    `;
                } else {
                    usersList.innerHTML = users.map(user => `
                        <a href="/messages/conversation/${user.id}" class="list-group-item list-group-item-action border-0 mb-2" style="border-radius:12px;padding:1rem;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle-md">
                                    ${user.name.charAt(0)}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-semibold" style="font-size:1rem;">${escapeHtml(user.name)}</h6>
                                    <small class="text-muted" style="font-size:0.8rem;">
                                        <i class="bi bi-person-badge me-1"></i>
                                        ${user.role ? user.role.name : 'User'}
                                    </small>
                                </div>
                                <div>
                                    <i class="bi bi-chat-dots text-primary" style="font-size:1.25rem;"></i>
                                </div>
                            </div>
                        </a>
                    `).join('');
                }
                searchResults.style.display = 'block';
            })
            .catch(error => {
                console.error('Search error:', error);
                usersList.innerHTML = `
                    <div class="list-group-item text-center text-danger" style="border-radius:12px;padding:1.5rem;font-size:0.85rem;">
                        Search failed. Please try again.
                    </div>
                `;
                searchResults.style.display = 'block';
            });
    }, 300);
});

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Hide search results when clicking outside
document.addEventListener('click', function(event) {
    const searchInput = document.getElementById('userSearch');
    const searchResults = document.getElementById('searchResults');
    
    if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
        searchResults.style.display = 'none';
    }
});
</script>
@endsection
