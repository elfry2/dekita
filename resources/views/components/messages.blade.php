@foreach ($errors->all() as $error)
    <div class="mt-2 alert alert-danger alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endforeach
@if (session('message'))
    <div class="mt-2 alert alert-{{ session('message')->type }} alert-dismissible fade show" role="alert">
        {{ session('message')->content }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
