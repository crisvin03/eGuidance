@extends('layouts.dashboard')

@section('title', 'Resources & Community')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-page-header-compact { flex-direction: column !important; align-items: flex-start !important; gap: 1rem !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    div[style*="display: grid"][style*="grid-template-columns: repeat(4"] { grid-template-columns: repeat(2, 1fr) !important; }
    div[style*="display: grid"][style*="grid-template-columns: repeat(2"] { grid-template-columns: 1fr !important; }
    .modern-section-header { flex-direction: column !important; align-items: flex-start !important; }
    .list-item { padding: 0.75rem !important; }
}

.list-item {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    transition: all 0.2s ease;
}

.list-item:last-child {
    border-bottom: none;
}

.list-item:hover {
    background: #f9fafb;
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-collection-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Resources & Community</h1>
            <p class="modern-page-subtitle">Manage teacher resources and review student creative submissions</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('counselor.resources.create') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-cloud-upload-fill"></i>
                <span>Upload Resource</span>
            </a>
            <a href="{{ route('counselor.student-submissions.index', ['status' => 'pending']) }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-eye-fill"></i>
                <span>Review Submissions</span>
                @if($pendingSubmissions > 0)
                    <span class="badge bg-warning ms-1">{{ $pendingSubmissions }}</span>
                @endif
            </a>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">
    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-folder-fill"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $totalResources }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Resources</div>
        </div>
        <a href="{{ route('counselor.resources.index') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-palette-fill"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $totalSubmissions }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Submissions</div>
        </div>
        <a href="{{ route('counselor.student-submissions.index') }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-clock-history"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $pendingSubmissions }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Pending</div>
        </div>
        <a href="{{ route('counselor.student-submissions.index', ['status' => 'pending']) }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-star-fill"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $featuredSubmissions }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Featured</div>
        </div>
        <a href="{{ route('counselor.student-submissions.index', ['featured' => 'yes']) }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none; transition: all 0.2s;">
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Main Content Grid -->
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
    <!-- Teacher Resources -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon modern-page-icon-green">
                <i class="bi bi-book-half"></i>
            </div>
            <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Teacher Resources</h2>
            <a href="{{ route('counselor.resources.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                View All
            </a>
        </div>

        <!-- Categories -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; margin-bottom: 1.5rem;">
            <div style="text-align: center; padding: 0.875rem; background: rgba(59, 130, 246, 0.05); border-radius: 10px; border: 1px solid rgba(59, 130, 246, 0.1);">
                <div style="font-size: 1.5rem; font-weight: 800; color: #3b82f6;">{{ $resourcesByCategory['hrg'] }}</div>
                <div style="font-size: 0.7rem; font-weight: 600; color: var(--navy); text-transform: uppercase;">HRG</div>
            </div>
            <div style="text-align: center; padding: 0.875rem; background: rgba(16, 185, 129, 0.05); border-radius: 10px; border: 1px solid rgba(16, 185, 129, 0.1);">
                <div style="font-size: 1.5rem; font-weight: 800; color: #10b981;">{{ $resourcesByCategory['handbook'] }}</div>
                <div style="font-size: 0.7rem; font-weight: 600; color: var(--navy); text-transform: uppercase;">Handbook</div>
            </div>
            <div style="text-align: center; padding: 0.875rem; background: rgba(139, 92, 246, 0.05); border-radius: 10px; border: 1px solid rgba(139, 92, 246, 0.1);">
                <div style="font-size: 1.5rem; font-weight: 800; color: #8b5cf6;">{{ $resourcesByCategory['gender_dev'] }}</div>
                <div style="font-size: 0.7rem; font-weight: 600; color: var(--navy); text-transform: uppercase;">Gender Dev</div>
            </div>
        </div>

        <!-- Recent Resources List -->
        <div class="modern-list">
            @forelse($recentResources->take(5) as $resource)
                <div class="list-item">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 40px; height: 40px; background: rgba(30, 122, 74, 0.1); color: var(--green); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-file-earmark-fill"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 0.9rem; font-weight: 600; color: var(--navy); margin-bottom: 0.25rem;">
                                {{ Str::limit($resource->title, 50) }}
                            </h4>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ $resource->category_label }} • {{ $resource->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <a href="{{ route('counselor.resources.show', $resource) }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(30, 122, 74, 0.1); color: var(--green); text-decoration: none;">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                    <i class="bi bi-folder-x" style="font-size: 2.5rem; opacity: 0.3; margin-bottom: 0.75rem; display: block;"></i>
                    <p style="font-size: 0.9rem; margin: 0;">No resources uploaded yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Student Submissions -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div class="modern-section-header">
            <div class="modern-section-icon" style="width: 32px; height: 32px; background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                <i class="bi bi-palette"></i>
            </div>
            <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Student Submissions</h2>
            <a href="{{ route('counselor.student-submissions.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                View All
            </a>
        </div>

        <!-- Types -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; margin-bottom: 1.5rem;">
            <div style="text-align: center; padding: 0.875rem; background: rgba(139, 92, 246, 0.05); border-radius: 10px; border: 1px solid rgba(139, 92, 246, 0.1);">
                <div style="font-size: 1.5rem; font-weight: 800; color: #8b5cf6;">{{ $submissionsByType['poetry'] }}</div>
                <div style="font-size: 0.7rem; font-weight: 600; color: var(--navy); text-transform: uppercase;">Poetry</div>
            </div>
            <div style="text-align: center; padding: 0.875rem; background: rgba(16, 185, 129, 0.05); border-radius: 10px; border: 1px solid rgba(16, 185, 129, 0.1);">
                <div style="font-size: 1.5rem; font-weight: 800; color: #10b981;">{{ $submissionsByType['artwork'] }}</div>
                <div style="font-size: 0.7rem; font-weight: 600; color: var(--navy); text-transform: uppercase;">Artwork</div>
            </div>
            <div style="text-align: center; padding: 0.875rem; background: rgba(59, 130, 246, 0.05); border-radius: 10px; border: 1px solid rgba(59, 130, 246, 0.1);">
                <div style="font-size: 1.5rem; font-weight: 800; color: #3b82f6;">{{ $submissionsByType['photography'] }}</div>
                <div style="font-size: 0.7rem; font-weight: 600; color: var(--navy); text-transform: uppercase;">Photos</div>
            </div>
        </div>

        <!-- Recent Submissions List -->
        <div class="modern-list">
            @forelse($recentSubmissions->take(5) as $submission)
                <div class="list-item">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 40px; height: 40px; background: rgba(139, 92, 246, 0.1); color: #8b5cf6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-{{ $submission->type === 'poetry' ? 'feather' : ($submission->type === 'artwork' ? 'palette' : 'camera') }}"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                <h4 style="font-size: 0.9rem; font-weight: 600; color: var(--navy); margin: 0;">
                                    {{ Str::limit($submission->title, 40) }}
                                </h4>
                                <span class="modern-badge {{ $submission->status_badge_class }}" style="font-size: 0.65rem;">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ $submission->student->name }} • {{ $submission->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <a href="{{ route('counselor.student-submissions.show', $submission) }}" style="width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(139, 92, 246, 0.1); color: #8b5cf6; text-decoration: none;">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                    <i class="bi bi-palette-x" style="font-size: 2.5rem; opacity: 0.3; margin-bottom: 0.75rem; display: block;"></i>
                    <p style="font-size: 0.9rem; margin: 0;">No submissions yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
