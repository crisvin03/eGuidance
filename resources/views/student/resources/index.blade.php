@extends('layouts.dashboard')

@section('title', 'Resources & Community')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-people"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Resources & Community</h1>
            <p class="modern-page-subtitle">Connect, explore, and discover student resources</p>
        </div>
    </div>
</div>

<div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Real Talk Section -->
        <section id="real-talk" class="content-section">
            <div class="modern-card" style="padding: 1.5rem;">
                <div class="modern-section-header">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-broadcast-pin"></i>
                    </div>
                    <div>
                        <h2 class="modern-section-title" style="font-size: 1.15rem;">Real Talk</h2>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">Podcasts & articles</p>
                    </div>
                </div>

                <div class="modern-alert modern-alert-warning" style="margin-top: 1rem; margin-bottom: 1rem; padding: 0.875rem;">
                    <div style="display: flex; align-items: start; gap: 0.75rem;">
                        <i class="bi bi-info-circle" style="font-size: 1.1rem; color: #fb923c; flex-shrink: 0;"></i>
                        <div>
                            <h6 style="font-size: 0.9rem; font-weight: 700; color: #fb923c; margin-bottom: 0.25rem;">Coming Soon!</h6>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Short, relatable articles and SSLG student podcasts about issues that actually matter to you.</p>
                        </div>
                    </div>
                </div>

                <div class="modern-grid-2" style="gap: 1rem;">
                    <div class="modern-card" style="padding: 1.25rem; background: rgba(248, 250, 252, 0.5);">
                        <i class="bi bi-mic-fill" style="font-size: 1.75rem; color: var(--text-muted); display: block; margin-bottom: 0.75rem;"></i>
                        <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">Podcasts</h6>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">SSLG student conversations on real issues</p>
                    </div>
                    <div class="modern-card" style="padding: 1.25rem; background: rgba(248, 250, 252, 0.5);">
                        <i class="bi bi-newspaper" style="font-size: 1.75rem; color: var(--text-muted); display: block; margin-bottom: 0.75rem;"></i>
                        <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">Articles</h6>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Mental health, relationships, school life</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Unfiltered Section -->
        <section id="unfiltered" class="content-section">
            <div class="modern-card" style="padding: 1.5rem;">
                <div class="modern-section-header" style="margin-bottom: 1.5rem;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-palette-fill"></i>
                    </div>
                    <div style="flex: 1;">
                        <h2 class="modern-section-title" style="font-size: 1.15rem;">Unfiltered</h2>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">Express yourself through creative submissions</p>
                    </div>
                    <a href="{{ route('student.submissions.create') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; text-decoration: none;">
                        <i class="bi bi-send-fill"></i>
                        <span>Submit Your Work</span>
                    </a>
                </div>

                <!-- Submission Stats -->
                <div class="modern-grid-3" style="gap: 1rem; margin-bottom: 1.5rem;">
                    <div class="modern-card" style="padding: 1rem; background: rgba(139, 92, 246, 0.05); border: 1px solid rgba(139, 92, 246, 0.1); text-align: center;">
                        <i class="bi bi-pen-fill" style="font-size: 1.5rem; color: #8b5cf6; display: block; margin-bottom: 0.5rem;"></i>
                        <h6 style="font-size: 0.85rem; font-weight: 700; color: var(--navy); margin: 0;">Poetry & Stories</h6>
                    </div>
                    <div class="modern-card" style="padding: 1rem; background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1); text-align: center;">
                        <i class="bi bi-palette" style="font-size: 1.5rem; color: #10b981; display: block; margin-bottom: 0.5rem;"></i>
                        <h6 style="font-size: 0.85rem; font-weight: 700; color: var(--navy); margin: 0;">Artwork</h6>
                    </div>
                    <div class="modern-card" style="padding: 1rem; background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.1); text-align: center;">
                        <i class="bi bi-camera-fill" style="font-size: 1.5rem; color: #3b82f6; display: block; margin-bottom: 0.5rem;"></i>
                        <h6 style="font-size: 0.85rem; font-weight: 700; color: var(--navy); margin: 0;">Photography</h6>
                    </div>
                </div>

                <!-- My Submissions -->
                @if($mySubmissions->count() > 0)
                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-folder-fill"></i>
                        My Submissions
                    </h3>
                    <div class="modern-list" style="background: #f9fafb; border-radius: 12px; overflow: hidden;">
                        @foreach($mySubmissions as $submission)
                        <div class="list-item" style="padding: 1rem; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; background: {{ $submission->type === 'poetry' ? 'rgba(139, 92, 246, 0.1)' : ($submission->type === 'artwork' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(59, 130, 246, 0.1)') }}; color: {{ $submission->type === 'poetry' ? '#8b5cf6' : ($submission->type === 'artwork' ? '#10b981' : '#3b82f6') }}; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-{{ $submission->type === 'poetry' ? 'feather' : ($submission->type === 'artwork' ? 'palette' : 'camera') }}"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 style="font-size: 0.9rem; font-weight: 600; color: var(--navy); margin-bottom: 0.25rem;">
                                    {{ $submission->title }}
                                </h4>
                                <div style="font-size: 0.8rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.5rem;">
                                    <span>{{ ucfirst($submission->type) }}</span>
                                    <span>•</span>
                                    <span>{{ $submission->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <span class="modern-badge {{ $submission->status === 'approved' ? 'modern-badge-success' : ($submission->status === 'rejected' ? 'modern-badge-danger' : 'modern-badge-warning') }}" style="font-size: 0.7rem;">
                                {{ ucfirst($submission->status) }}
                            </span>
                            @if($submission->is_featured)
                            <span class="modern-badge modern-badge-primary" style="font-size: 0.7rem;">
                                <i class="bi bi-star-fill"></i> Featured
                            </span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Featured Submissions -->
                @if($featuredSubmissions->count() > 0)
                <div>
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-star-fill"></i>
                        Featured Works
                    </h3>
                    <div class="modern-grid-2" style="gap: 1rem;">
                        @foreach($featuredSubmissions as $submission)
                        <div class="modern-card" style="padding: 1.25rem; background: rgba(248, 250, 252, 0.8);">
                            <div style="display: flex; align-items: start; gap: 0.75rem; margin-bottom: 0.75rem;">
                                <div style="width: 36px; height: 36px; background: {{ $submission->type === 'poetry' ? 'rgba(139, 92, 246, 0.1)' : ($submission->type === 'artwork' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(59, 130, 246, 0.1)') }}; color: {{ $submission->type === 'poetry' ? '#8b5cf6' : ($submission->type === 'artwork' ? '#10b981' : '#3b82f6') }}; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-{{ $submission->type === 'poetry' ? 'feather' : ($submission->type === 'artwork' ? 'palette' : 'camera') }}"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">
                                        {{ $submission->title }}
                                    </h4>
                                    <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0;">
                                        By {{ $submission->student->name }} • {{ $submission->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            @if($submission->description)
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0; line-height: 1.5;">
                                {{ Str::limit($submission->description, 100) }}
                            </p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Show More / Pagination for Featured -->
                    @if(isset($showAllFeatured) && $showAllFeatured)
                        <!-- Pagination when showing all featured -->
                        @if($featuredSubmissions->hasPages())
                            <div class="d-flex justify-content-center" style="margin-top: 1.5rem;">
                                {{ $featuredSubmissions->appends(['show_all_featured' => 'true'])->links() }}
                            </div>
                        @endif
                    @elseif(isset($totalFeaturedSubmissions) && $totalFeaturedSubmissions > 6)
                        <!-- Show More Button -->
                        <div style="text-align: center; margin-top: 1.5rem;">
                            <a href="{{ route('student.resources.index', ['show_all_featured' => 'true']) }}#unfiltered" 
                               class="modern-btn modern-btn-secondary" 
                               style="padding: 0.875rem 2rem; font-size: 0.95rem;">
                                <i class="bi bi-grid-3x3-gap-fill me-2"></i>
                                <span>Show All {{ $totalFeaturedSubmissions }} Featured Works</span>
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    @endif
                </div>
                @else
                <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
                    <i class="bi bi-palette-fill" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem; display: block;"></i>
                    <p style="font-size: 0.95rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Share Your Creativity</p>
                    <p style="font-size: 0.85rem; margin: 0;">Your story. Your voice. No filter. Submit your creative work to be featured.</p>
                </div>
                @endif
            </div>
        </section>

        <!-- Find Your People Section -->
        <section id="find-people" class="content-section">
            <div class="modern-card" style="padding: 1.5rem;">
                <div class="modern-section-header">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <h2 class="modern-section-title" style="font-size: 1.15rem;">Find Your People</h2>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">Clubs & organizations</p>
                    </div>
                </div>

                <div class="modern-alert modern-alert-success" style="margin-top: 1rem; margin-bottom: 1rem; padding: 0.875rem;">
                    <div style="display: flex; align-items: start; gap: 0.75rem;">
                        <i class="bi bi-info-circle" style="font-size: 1.1rem; color: #10b981; flex-shrink: 0;"></i>
                        <div>
                            <h6 style="font-size: 0.9rem; font-weight: 700; color: #10b981; margin-bottom: 0.25rem;">Coming Soon!</h6>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Looking for your squad? Browse clubs, discover organizations, learn about activities, and connect with officers.</p>
                        </div>
                    </div>
                </div>

                <div class="modern-grid-2" style="gap: 1rem;">
                    <div class="modern-card" style="padding: 1.25rem; background: rgba(248, 250, 252, 0.5);">
                        <i class="bi bi-trophy-fill" style="font-size: 1.75rem; color: var(--text-muted); display: block; margin-bottom: 0.75rem;"></i>
                        <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">Sports Clubs</h6>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Athletics, Basketball, Volleyball, etc.</p>
                    </div>
                    <div class="modern-card" style="padding: 1.25rem; background: rgba(248, 250, 252, 0.5);">
                        <i class="bi bi-music-note-beamed" style="font-size: 1.75rem; color: var(--text-muted); display: block; margin-bottom: 0.75rem;"></i>
                        <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">Arts & Culture</h6>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Music, Dance, Drama, Visual Arts</p>
                    </div>
                    <div class="modern-card" style="padding: 1.25rem; background: rgba(248, 250, 252, 0.5);">
                        <i class="bi bi-laptop" style="font-size: 1.75rem; color: var(--text-muted); display: block; margin-bottom: 0.75rem;"></i>
                        <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">Academic Clubs</h6>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Science, Math, Debate, Journalism</p>
                    </div>
                    <div class="modern-card" style="padding: 1.25rem; background: rgba(248, 250, 252, 0.5);">
                        <i class="bi bi-heart-fill" style="font-size: 1.75rem; color: var(--text-muted); display: block; margin-bottom: 0.75rem;"></i>
                        <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">Service Organizations</h6>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Community service and outreach</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Exit Check Section -->
        <section id="exit-check" class="content-section">
            <div class="modern-card" style="padding: 1.5rem;">
                <div class="modern-section-header">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-door-open-fill"></i>
                    </div>
                    <div>
                        <h2 class="modern-section-title" style="font-size: 1.15rem;">The Exit Check</h2>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">Curriculum exit survey for graduating students</p>
                    </div>
                </div>

                <div class="modern-alert" style="margin-top: 1rem; margin-bottom: 1.5rem; padding: 0.875rem; background: rgba(30, 122, 74, 0.08); border-left: 4px solid var(--green);">
                    <div style="display: flex; align-items: start; gap: 0.75rem;">
                        <i class="bi bi-info-circle-fill" style="font-size: 1.1rem; color: var(--green); flex-shrink: 0;"></i>
                        <div>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                                <strong style="color: var(--green);">For Graduating Students:</strong> Before you go, tell us what you think. Share your feedback about your curriculum experience at BNHS to help us improve.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Exit Survey Card -->
                <div style="padding: 1.25rem; border: 1px solid rgba(30, 122, 74, 0.12); border-radius: 14px; background: rgba(255, 255, 255, 0.5);">
                    <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1.25rem;">
                        <div class="modern-section-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green); flex-shrink: 0;">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                        <div style="flex: 1;">
                            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Curriculum Exit Survey</h6>
                            <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                                <span class="modern-badge modern-badge-secondary" style="font-size: 0.75rem;">Annex B</span>
                                <span class="modern-badge modern-badge-info" style="font-size: 0.75rem; margin-left: 0.5rem;">Senior High Graduates</span>
                            </p>
                            <p style="font-size: 0.875rem; color: var(--text-body); margin: 0; line-height: 1.5;">
                                Required survey for all graduating Senior High School learners. Share your thoughts on the curriculum, teaching methods, facilities, and overall experience.
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding-top: 1rem; border-top: 1px solid rgba(0, 0, 0, 0.06);">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <small style="color: var(--text-muted); font-size: 0.85rem;">
                                <i class="bi bi-clock" style="color: var(--green);"></i>
                                ~15-20 minutes
                            </small>
                        </div>
                        <a href="{{ route('student.forms.show', 'exit-survey') }}" 
                           class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.25rem; font-size: 0.9rem;">
                            <i class="bi bi-pencil-square"></i>
                            <span>Take Survey</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Future Me Section -->
        <section id="future-me" class="content-section">
            <div class="modern-card" style="padding: 1.5rem;">
                <div class="modern-section-header">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-rocket-takeoff-fill"></i>
                    </div>
                    <div>
                        <h2 class="modern-section-title" style="font-size: 1.15rem;">Future Me</h2>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">Career guidance resources</p>
                    </div>
                </div>

                <div class="modern-alert" style="margin-top: 1rem; margin-bottom: 1rem; padding: 0.875rem; background: rgba(30, 122, 74, 0.08); border-left: 4px solid var(--green);">
                    <div style="display: flex; align-items: start; gap: 0.75rem;">
                        <i class="bi bi-info-circle-fill" style="font-size: 1.1rem; color: var(--green); flex-shrink: 0;"></i>
                        <div>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Explore career guidance materials, college information, scholarship opportunities, and future planning resources uploaded by your counselors.</p>
                        </div>
                    </div>
                </div>

                @if($futureMeResources->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.25rem; margin-top: 1.5rem;">
                        @foreach($futureMeResources as $resource)
                            <div class="modern-card" style="padding: 1.25rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'; this.style.borderColor='var(--green)';" onmouseout="this.style.transform=''; this.style.boxShadow=''; this.style.borderColor='';">
                                <!-- Header -->
                                <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1rem;">
                                    @php
                                        $fileTypeColors = [
                                            'pdf' => ['bg' => '#fee2e2', 'color' => '#dc2626'],
                                            'doc' => ['bg' => '#dbeafe', 'color' => '#2563eb'],
                                            'docx' => ['bg' => '#dbeafe', 'color' => '#2563eb'],
                                            'ppt' => ['bg' => '#fed7aa', 'color' => '#ea580c'],
                                            'pptx' => ['bg' => '#fed7aa', 'color' => '#ea580c'],
                                            'xls' => ['bg' => '#d1fae5', 'color' => '#059669'],
                                            'xlsx' => ['bg' => '#d1fae5', 'color' => '#059669'],
                                            'jpg' => ['bg' => '#fce7f3', 'color' => '#db2777'],
                                            'jpeg' => ['bg' => '#fce7f3', 'color' => '#db2777'],
                                            'png' => ['bg' => '#fce7f3', 'color' => '#db2777'],
                                        ];
                                        $fileType = strtolower($resource->file_type);
                                        $typeStyle = $fileTypeColors[$fileType] ?? ['bg' => '#f3f4f6', 'color' => '#6b7280'];
                                    @endphp
                                    <div style="width: 48px; height: 48px; border-radius: 10px; background: {{ $typeStyle['bg'] }}; color: {{ $typeStyle['color'] }}; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; flex-shrink: 0;">
                                        {{ strtoupper($resource->file_type) }}
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem; line-height: 1.3; word-break: break-word;">
                                            {{ $resource->title }}
                                        </h6>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">
                                            <i class="bi bi-person-circle"></i>
                                            {{ $resource->uploader->name }}
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Description -->
                                @if($resource->description)
                                    <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5; margin-bottom: 1rem;">
                                        {{ Str::limit($resource->description, 100) }}
                                    </p>
                                @endif
                                
                                <!-- Meta Info -->
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid rgba(0, 0, 0, 0.06);">
                                    <div style="flex: 1;">
                                        <div style="font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">File Size</div>
                                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--navy);">{{ $resource->formatted_file_size }}</div>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.25rem;">Uploaded</div>
                                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--navy);">{{ $resource->created_at->format('M j, Y') }}</div>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ Storage::url($resource->file_path) }}" 
                                       target="_blank" 
                                       download="{{ $resource->file_name }}"
                                       class="modern-btn modern-btn-primary" 
                                       style="flex: 1; justify-content: center; padding: 0.75rem; font-size: 0.9rem;">
                                        <i class="bi bi-download"></i>
                                        <span>Download</span>
                                    </a>
                                    <a href="{{ Storage::url($resource->file_path) }}" 
                                       target="_blank"
                                       class="modern-btn modern-btn-secondary" 
                                       style="padding: 0.75rem; font-size: 0.9rem;">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Show More / Pagination -->
                    @if(isset($showAll) && $showAll)
                        <!-- Pagination when showing all -->
                        @if($futureMeResources->hasPages())
                            <div class="d-flex justify-content-center" style="margin-top: 2rem;">
                                {{ $futureMeResources->appends(['show_all' => 'true'])->links() }}
                            </div>
                        @endif
                    @elseif(isset($totalFutureMeResources) && $totalFutureMeResources > 6)
                        <!-- Show More Button -->
                        <div style="text-align: center; margin-top: 2rem;">
                            <a href="{{ route('student.resources.index', ['show_all' => 'true']) }}#future-me" 
                               class="modern-btn modern-btn-secondary" 
                               style="padding: 0.875rem 2rem; font-size: 0.95rem;">
                                <i class="bi bi-grid-3x3-gap-fill me-2"></i>
                                <span>Show All {{ $totalFutureMeResources }} Resources</span>
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="modern-card" style="padding: 3rem; text-align: center; margin-top: 1.5rem;">
                        <i class="bi bi-inbox" style="font-size: 3.5rem; color: var(--text-muted); opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">No Resources Yet</h3>
                        <p style="font-size: 0.95rem; color: var(--text-muted); margin: 0;">Your counselors haven't uploaded any career resources yet. Check back soon!</p>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>

<style>
.content-section {
    scroll-margin-top: 20px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modern-grid-2, .modern-grid-3 {
        grid-template-columns: 1fr;
    }
}
</style>
</style>
@endsection
