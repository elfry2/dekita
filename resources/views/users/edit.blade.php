@extends('layouts.form')
@section('content')
    <form action="{{ route(str($resource) . '.update', [Str::singular($resource) => $primary]) }}" method="post"
        enctype="multipart/form-data">
        @method('patch')
        @csrf
        @if (!empty($primary->avatar))
            <div class="d-flex justify-content-center">
                <img src="{{ asset('storage/' . $primary->avatar) }}" class="img-thumbnail"
                    style="max-width: 16em; border-radius: 8em">
            </div>
        @endif
        <div class="mt-3">
            <input name="avatar" type="file" id="avatarFileInput" class="form-control" placeholder="">
            <small class="text-secondary">Leave blank if you don't want to change avatar</small>
        </div>
        <div class="form-floating mt-3">
            <input name="name" type="text" id="nameTextInput" class="form-control" placeholder=""
                value="{{ old('name') ?? $primary->name }}">
            <label for="nameTextInput">Name</label>
        </div>
        <div class="form-floating mt-3">
            <input name="username" type="text" id="usernameTextInput" class="form-control" placeholder=""
                value="{{ old('username') ?? $primary->username }}">
            <label for="usernameTextInput">Username</label>
        </div>
        <div class="form-floating mt-3">
            <input name="email" type="email" id="emailEmailInput" class="form-control" placeholder=""
                value="{{ old('email') ?? $primary->email }}">
            <label for="emailEmailInput">Email</label>
        </div>
        <div class="form-floating mt-3">
            <select name="role_id" class="form-select" id="roleSelectInput">
                @foreach ($secondary as $row)
                    <option value="{{ $row->id }}" @if ($primary->role->id == $row->id) selected @endif>
                        {{ $row->name }}</option>
                @endforeach
            </select>
            <label for="floatingSelect">Role</label>
        </div>
        <div class="form-floating mt-3">
            <input name="password" type="password" id="passwordPasswordInput" class="form-control" placeholder="">
            <label for="passwordPasswordInput">Password</label>
            <small class="text-secondary">Leave blank if you don't want to change password</small>
        </div>
        <div class="form-floating mt-3">
            <input name="suspended_until" type="date" id="suspendedUntilDateInput" class="form-control" placeholder=""
                value="{{ $primary->suspended_until ? date_format(date_create($primary->suspended_until), 'Y-m-d') : '' }}">
            <label for="suspendedUntilDateInput">Suspended until</label>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route(str($resource) . '.delete', [Str::singular($resource) => $primary]) }}"
                class="btn text-danger"><i class="bi-trash"></i></a>
            <button class="btn" type="submit"><i class="bi-pencil-square"></i><span class="ms-2">Save</span></button>
        </div>
    </form>
@endsection
