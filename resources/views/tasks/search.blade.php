@extends('layouts.form')
@section('content')
<form action="{{ route($resource . '.index') }}" class="d-flex flex-column align-items-end" role="search">
    <input name="q" id="searchSearchInput" class="form-control border-dark-subtle" style="min-width: 8em" type="search" placeholder="Search {{ Str::singular($resource) }}..." aria-label="Search" autofocus>
    <button class="btn mt-2" type="submit"><i class="bi-search"></i><span class="ms-2">Search</span></button>
</form>
@endsection
