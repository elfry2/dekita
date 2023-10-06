@extends('layouts.dashboard')
@section('topnav')
    @include('components.search')
    @include('components.create-button')
    @include('components.preferences-button')
    @include('components.pagination-buttons')
@endsection
@section('bottomnav')
    @include('components.pagination-buttons')
@endsection
@section('content')
    @if (!empty(request('q')))
        <p>Showing {{ $resource }} like "{{ request('q') }}". <a href="{{ url()->current() }}">Clear</a></p>
    @endif
    @if ($primary->count() == 0)
        <h5 class="mt-5 pt-5 text-center text-secondary">No @if (!empty(request('q')))
                such
            @endif {{ str($resource)->singular() }}</h5>
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
                    <th></th>
                </tr>
                @foreach ($primary as $row)
                    <tr>
                        <td>{{ $primary->perPage() * ($primary->currentPage() - 1) + $loop->index + 1 }}</td>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->role->name }}</td>
                        <td>{{ $row->suspended_until ? date_format(date_create($row->suspended_until), 'd M Y') : '' }}</td>
                        <td align="right">
                            {{-- <div class="dropdown">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route(str($resource) . '.edit', [Str::singular($resource) => $row]) }}" class="dropdown-item"><i class="bi-pencil-square"></i><span class="ms-2">Edit</span></a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a href="{{ route(str($resource) . '.delete', [Str::singular($resource) => $row]) }}" class="dropdown-item"><i class="bi-trash"></i><span class="ms-2">Delete</span></a></li>
                                </ul>
                            </div> --}}
                            <a href="{{ route(str($resource) . '.edit', [Str::singular($resource) => $row]) }}" class="btn"><i class="bi-chevron-right"></i></a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
@endsection
