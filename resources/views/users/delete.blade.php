@extends('layouts.form')
@section('content')
    <h5 class="mt-5">Delete {{ str($resource)->singular() }} {{ $primary->id }}?</h5>
    <p>This action cannot be undone.</p>
    <form action="{{ route(str($resource) . '.destroy', [Str::singular($resource) => $primary]) }}" method="post" class="mt-5">
        @method('delete')
        @csrf
        <div class="d-flex justify-content-end mt-3">
            <button class="btn border-0 btn-outline-danger" type="submit"><i class="bi-trash"></i><span class="ms-2">Delete</span></button>
        </div>
    </form>
@endsection
