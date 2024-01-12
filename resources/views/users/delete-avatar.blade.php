@extends('layouts.form')
@section('content')
    <h5 class="mt-5">Delete avatar?</h5>
    <p>This action cannot be undone.</p>
    <form action="{{ route(str($resource) . '.destroyAvatar', [Str::singular($resource) => $primary]) }}" method="post" class="mt-5">
        @csrf
        <div class="d-flex justify-content-end mt-3">
            <input type="hidden" name="redirectTo" value="{{ request('back') ?? null }}">
            <button class="btn border-0 btn-outline-danger" type="submit"><i class="bi-trash"></i><span class="ms-2">Delete</span></button>
        </div>
    </form>
@endsection
