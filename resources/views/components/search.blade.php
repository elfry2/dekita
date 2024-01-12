@if ($primary->count() > 0)
<form class="d-flex hide-on-small-screens" role="search">
    <div class="input-group flex-nowrap {{-- hide-on-small-screens --}}">
        <input name="q" id="searchSearchInput" class="form-control border-dark-subtle border-end-0" style="min-width: 8em" type="search" placeholder="Search {{ Str::singular($resource) }}..." aria-label="Search" autofocus>
        <button class="btn border-dark-subtle border-start-0 btn-outline-{{ preference('theme') == 'dark' ? 'light' : 'dark' }}" type="submit" title="Search for {{ $resource }} like the query"><i class="bi-search"></i></button>
    </div>
</form>
<a href="{{ route($resource . '.search') }}" class="btn ms-2 hide-on-big-screens"><i class="bi-search"></i></a>
@endif
