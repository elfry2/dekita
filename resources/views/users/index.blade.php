@extends('layouts.dashboard')
@section('topnav')
@endsection
@section('bottomnav')
@endsection
@section('content')
    @if ($primary->count() == 0)
        @include('components.no-data-text')
    @else
        <div class="rounded border border-bottom-0 table-responsive">
            <table class="m-0 table table-striped table-hover align-middle">
                <tr>
                    <th>#</th>
                    <th>Id.</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Suspended until</th>
                    <th></th>
                </tr>
                @foreach ($primary as $row)
                    <tr id="row{{ $loop->count }}">
                        <td>{{ $primary->perPage() * ($primary->currentPage() - 1) + $loop->count }}</td>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->role->name }}</td>
                        <td>{{ $row->suspended_until ? date_format(date_create($row->suspended_until), 'Y/m/d H:i') : '' }}
                        </td>
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
                            {{-- <a href="{{ route($resource . '.edit', [Str::singular($resource) => $row, 'back' => request()->fullUrl() . '#row' . $loop->count]) }}"
                                class="btn"><i class="bi-chevron-right"></i></a> --}}
                            <div class="dropdown">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route($resource . '.edit', [Str::singular($resource) => $row, 'back' => request()->fullUrl() . '#row' . $loop->count]) }}"><i class="bi-pencil-square"></i><span
                                                class="ms-2">Edit</span></a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route($resource . '.delete', [Str::singular($resource) => $row, 'back' => request()->fullUrl() . '#row' . $loop->count]) }}"><i class="bi-trash"></i><span
                                                class="ms-2">Delete</span></a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
@endsection
