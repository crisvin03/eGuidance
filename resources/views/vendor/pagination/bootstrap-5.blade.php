@if ($paginator->hasPages())
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.75rem; padding:0.75rem 0;">
        {{-- Record count info --}}
        <p style="margin:0; font-size:0.8rem; color:#64748b;">
            Showing <strong>{{ $paginator->firstItem() }}</strong> to <strong>{{ $paginator->lastItem() }}</strong> of <strong>{{ $paginator->total() }}</strong> results
        </p>

        {{-- Page links --}}
        <ul style="display:flex; flex-wrap:wrap; gap:0.25rem; list-style:none; padding:0; margin:0;">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; color:#94a3b8; font-size:0.8rem; cursor:default;">
                        <i class="bi bi-chevron-left"></i>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:#fff; color:#475569; font-size:0.8rem; text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span style="display:inline-flex; align-items:center; justify-content:center; min-width:34px; height:34px; padding:0 0.5rem; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; color:#94a3b8; font-size:0.8rem;">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="display:inline-flex; align-items:center; justify-content:center; min-width:34px; height:34px; padding:0 0.5rem; border-radius:8px; border:1px solid #20B2AA; background:linear-gradient(135deg,#20B2AA,#008B8B); color:#fff; font-size:0.8rem; font-weight:600;">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" style="display:inline-flex; align-items:center; justify-content:center; min-width:34px; height:34px; padding:0 0.5rem; border-radius:8px; border:1px solid #e2e8f0; background:#fff; color:#475569; font-size:0.8rem; text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:#fff; color:#475569; font-size:0.8rem; text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li>
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; color:#94a3b8; font-size:0.8rem; cursor:default;">
                        <i class="bi bi-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </div>
@endif
