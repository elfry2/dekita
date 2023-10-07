@extends('layouts.form')
@section('content')
    <div class="text-center mt-5">
        <p>Your account is suspended until {{ date_format(date_create(Auth::user()->suspended_until), 'Y/m/d H:i:s') }} {{ config('app.timezone') }}.</p>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit"
                class="btn btn-primary"><i
                    class="bi-box-arrow-left"></i><span class="ms-2">Log out</span></button>
        </form>
    </div>
@endsection