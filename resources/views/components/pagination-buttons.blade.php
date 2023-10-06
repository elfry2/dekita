<div class="flex-shrink-0 d-flex align-items-center @if(isset($primary) && $primary->count() == 0) d-none @endif">
    <a href="{{ $primary->previousPageUrl() }}"
        class="btn ms-2 @if ($primary->onFirstPage()) disabled border-0 @endif"><i class="bi-chevron-left"></i></a>
    <form>
        <input type="number" name="page" value="{{ request('page') ?? 1 }}" min="1" max="{{ ceil($primary->total() / $primary->perPage()) }}" class="form-control text-center" style="max-width: 4em" autocomplete="off">
    </form>
    <a href="{{ $primary->nextPageUrl() }}" class="btn @if ($primary->onLastPage()) disabled border-0 @endif"><i
            class="bi-chevron-right"></i></a>
</div>