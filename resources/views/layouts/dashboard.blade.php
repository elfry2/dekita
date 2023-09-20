<!doctype html>
<html lang="{{ preference('lang', 'en') }}" data-bs-theme="{{ preference('theme', 'light') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ (isset($title) ? "$title | " : '') . config('app.name') }}</title>
    <link href="/packages/bootstrap-5.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/packages/bootstrap-icons-1.11.0/bootstrap-icons.css" rel="stylesheet">
    <link href="/packages/sparksuite-simplemde-markdown-editor-6abda7a/dist/simplemde.min.css" rel="stylesheet">
    <script src="/packages/sparksuite-simplemde-markdown-editor-6abda7a/dist/simplemde.min.js"></script>
    <link href="/css/stylesheet.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-sm-2 h-100 position-sticky d-{{ preference('nav.display') }}" id="nav">
                <div class="d-flex align-items-center mt-2">
                    <span class="hide-on-big-screens me-2">
                        @include('components.navbar-visibility-toggle-button')
                    </span>
                    <h3 class="m-0">{{ config('app.name') }}</h3>
                    <div class="btn invisible"><i class="bi-moon"></i></div>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center">
                        <b>Folders</b>
                        <a href="{{ route('folders.create') }}" class="btn ms-auto p-0"><i class="bi-plus-lg"></i></a>
                    </div>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action border-0 rounded">General</a>
                    </div>
                </div>
                <div class="mt-3">
                    <b>Application</b>
                    <div class="list-group">
                        @if (Auth::user()->role->id == 1) {{-- Administrator role id --}}
                        <a href="{{ route('users.index') }}"
                        class="list-group-item list-group-item-action border-0 @if (Route::is('users.*'))
                          bg-body-secondary rounded
                        @endif"><i
                            class="bi-people"></i><span class="ms-2">Users</span></a>
                        @endif
                        <form action="{{ route('preference.store') }}" method="post">
                            @csrf
                            {{-- <input type="hidden" name="redirectTo" value="{{ url()->current() }}"> --}}
                            <input type="hidden" name="key" value="theme">
                            <button type="submit" name="value"
                                value="{{ preference('theme', 'light') == 'light' ? 'dark' : 'light' }}" class="list-group-item list-group-item-action border-0 rounded"><i
                                    class="bi-{{ preference('theme', 'light') == 'light' ? 'moon' : 'sun' }}"></i><span class="ms-2">{{ preference('theme', 'light') == 'light' ? 'Dark theme' : 'Light theme' }}</span></button>
                        </form>
                    </div>
                </div>
                <div class="mt-3">
                    <b>{{ Auth::user()->name }}</b>
                    <div class="list-group">
                        <a href="{{ route('profile.edit') }}"
                            class="list-group-item list-group-item-action border-0 rounded"><i
                                class="bi-person"></i><span class="ms-2">Profile</span>
                        </a>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button onclick="this.parentElement.submit()"
                                class="list-group-item list-group-item-action border-0 rounded"><i
                                    class="bi-box-arrow-left"></i><span class="ms-2">Log out</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm" id="content">
                <div class="mt-2 d-flex align-items-center position-sticky overflow-auto" id="actions">
                    @include('components.navbar-visibility-toggle-button')
                    <h3 class="m-0 ms-2 me-auto">{{ $title ?? '' }}</h3>
                    @yield('actions')
                </div>
                <div class="mt-2" id="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="/packages/bootstrap-5.3.1-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
