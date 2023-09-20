@extends('layouts.dashboard')
@section('actions')
@if ($users->count() > 0)
<form class="d-flex" role="search">
  <div class="input-group flex-nowrap hide-on-small-screens">
      <input class="form-control border-secondary border-end-0" type="search"
          placeholder="Search" aria-label="Search">
      <button class="btn border-secondary border-start-0" type="submit"><i
              class="bi-search"></i></button>
  </div>
</form>
@endif
<a href="{{ route('register') }}" class="btn ms-2"><i
        class="bi-plus-lg"></i><span class="ms-2 hide-on-small-screens">New</span></a>
<a href="{{ route(Str::lower($title) . '.index', ['page' => 0]) }}" class="btn ms-2"><i class="bi-chevron-left"></i></a>
<a href="{{ route(Str::lower($title) . '.index', ['page' => -1]) }}" class="btn ms-2">1</a>
<a href="{{ route(Str::lower($title) . '.index', ['page' => 2]) }}" class="btn ms-2"><i class="bi-chevron-right"></i></a>
@endsection
@section('content')
@if ($users->count() == 0)
    <h5 class="text-center text-secondary">No {{ data }}</h5>
@else
<div class="rounded border border-bottom-0 table-responsive">
    <table class="m-0 table table-striped table-hover align-middle">
        <tr>
            <th>#</th>
        <th>Id.</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Suspended until</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->name }}</td>
                <td>{{ $user->suspended_until }}</td>
            </tr>
        @endforeach
    </table>
</div>
@endif
@endsection