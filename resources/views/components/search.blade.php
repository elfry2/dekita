<form class="d-flex" role="search">
    <div class="input-group flex-nowrap {{-- hide-on-small-screens --}}">
        <input name="q" id="searchSearchInput" class="form-control border-secondary border-end-0" style="min-width: 8em" type="search" placeholder="Search {{ Str::singular($resource) }}..." aria-label="Search">
        <button class="btn border-secondary border-start-0" type="submit"><i class="bi-search"></i></button>
    </div>
</form>
{{-- <a href="#" class="btn ms-2 hide-on-big-screens"><i class="bi-search"></i></a> --}}