@extends('layouts.dashboard')
@section('topnav')
@endsection
@section('bottomnav')
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col screen-center-x" style="max-width: 36em">
            @for ($i = 0; $i < 12; $i++)
                <div class="card mt-2">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5>{{ str(fake()->realText())->limit(40) }}</h5>
                                <p class="m-0">{{ str(fake()->realText())->limit(100) }}</p>
                            </div>
                            <a href="#" class="btn"><i class="bi-chevron-right"></i></a>
                            <div class="dropdown">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="bi-pencil-square"></i><span
                                                class="ms-2">Edit</span></a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i class="bi-trash"></i><span
                                                class="ms-2">Delete</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection
