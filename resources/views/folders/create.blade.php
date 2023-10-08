@extends('layouts.form')
@section('content')
    <form action="{{ route(str($resource) . '.store') }}" method="post">
        @csrf
        <div class="form-floating mt-3">
            <input name="name" type="text" id="nameTextInput" class="form-control" placeholder=""
                value="{{ old('name') }}" autofocus>
            <label for="nameTextInput">Name</label>
        </div>
        <div class="form-floating mt-3">
            <input name="description" type="text" id="descriptionTextInput" class="form-control" placeholder=""
                value="{{ old('description') }}">
            <label for="descriptionTextInput">Description <span class="text-secondary">(optional)</span></label>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button class="btn" type="submit"><i class="bi-plus-lg"></i><span class="ms-2">Create</span></button>
        </div>
    </form>
@endsection
