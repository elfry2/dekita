<div class="flex-shrink-0 @if(isset($primary) && $primary->count() == 0) d-none @endif">
    <a href="{{ $primary->previousPageUrl() }}"
        class="btn ms-2 @if ($primary->onFirstPage()) disabled border-0 @endif"><i class="bi-chevron-left"></i></a>
    <span class="ms-2">{{ $primary->currentPage() }}</span>
    <a href="{{ $primary->nextPageUrl() }}" class="btn ms-2 @if ($primary->onLastPage()) disabled border-0 @endif"><i
            class="bi-chevron-right"></i></a>
</div>