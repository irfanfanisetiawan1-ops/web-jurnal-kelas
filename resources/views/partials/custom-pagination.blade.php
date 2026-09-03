@if ($paginator->hasPages())
    <div class="custom-pagination-bar">
        <div class="pagination-info">
            Menampilkan <strong style="color: #0f172a;">{{ $paginator->firstItem() }}</strong> – <strong style="color: #0f172a;">{{ $paginator->lastItem() }}</strong> dari <strong style="color: #0f172a;">{{ $paginator->total() }}</strong> Data
        </div>
        <ul class="pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
            @else
                <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">&lsaquo;</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">&rsaquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
            @endif
        </ul>
    </div>
@endif
