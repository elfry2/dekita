@extends('layouts.dashboard')
@section('topnav')
@include('components.preferences-button')
@endsection
@section('bottomnav')
@endsection
@section('content')
    @if ($primary->count() == 0)
        @include('components.no-data-text')
    @else
        <div class="rounded border border-bottom-0 table-responsive">
            <table class="m-0 table table-hover align-middle">
                <tr>
                    <th>#</th>
                    <th>Id.</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Suspended until</th>
                </tr>
                @foreach ($primary as $row)
                <tr id="row{{ $loop->index + 1 }}" style="cursor: pointer" onclick="window.location.href = '{{ route("$resource.edit", [Str::singular($resource) => $row->id]) }}'">
                        <td>{{ $primary->perPage() * ($primary->currentPage() - 1) + $loop->index + 1 }}</td>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->username }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->role->name }}</td>
                        <td>{{ $row->suspended_until ? date_format(date_create($row->suspended_until), 'Y/m/d H:i') : '' }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
@endsection
