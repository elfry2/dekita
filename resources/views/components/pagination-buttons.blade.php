<div class="flex-shrink-0 d-flex align-items-center @if(isset($primary) && $primary->count() == 0) d-none @endif">
    <a href="{{ $primary->previousPageUrl() }}" title="Go to the previous page"
    class="btn border-0 btn-outline-{{ preference('theme') == 'dark' ? 'light' : 'dark' }} ms-2 @if ($primary->onFirstPage()) disabled border-0 @endif"><i class="bi-chevron-left"></i></a>
    <form>
        @foreach(request()->collect()->except(['page']) as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <input type="number" name="page" value="{{ request('page') ?? 1 }}" min="1" max="{{ ceil($primary->total() / $primary->perPage()) }}" class="form-control text-center" style="max-width: 4em" autocomplete="off">
    </form>
    <a href="{{ $primary->nextPageUrl() }}" title="Go to the next page" class="btn border-0 btn-outline-{{ preference('theme') == 'dark' ? 'light' : 'dark' }} @if ($primary->onLastPage()) disabled border-0 @endif"><i
            class="bi-chevron-right"></i></a>
</div>
