@extends('layouts.form')
@section('content')
    <form action="{{ route(str($resource) . '.update', [Str::singular($resource) => $primary]) }}" method="post">
        @method('patch')
        @csrf
        <div class="form-floating mt-3">
            <input name="name" type="text" id="nameTextInput" class="form-control" placeholder=""
                value="{{ old('name') ?? $primary->name }}" autofocus>
            <label for="nameTextInput">Name</label>
        </div>
        <div class="form-floating mt-3">
            <input name="description" type="text" id="descriptionTextInput" class="form-control" placeholder=""
                value="{{ old('description') ?? $primary->description }}">
            <label for="descriptionTextInput">Description <span class="text-secondary">(optional)</span></label>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route(str($resource) . '.delete', [Str::singular($resource) => $primary]) }}"
                class="btn border-0 btn-outline-danger" title="Delete {{ str($resource)->singular() }}"><i class="bi-trash"></i></a>
            <button class="btn border-0 btn-outline-{{ preference('theme') == 'dark' ? 'light' : 'dark' }}" type="submit"><i class="bi-pencil-square"></i><span class="ms-2">Save</span></button>
        </div>
    </form>
@endsection
