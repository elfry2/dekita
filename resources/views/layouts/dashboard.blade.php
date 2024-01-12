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
            <div class="col-sm-2 d-{{ preference('sidenav.display') }}" id="sidenav">

                <!-- BEGIN sidenav -->

                <div class="sticky-top pt-2 bg-{{ preference('theme', 'light') == 'light' ? 'white' : 'dark' }}">
                    <div class="d-flex align-items-center">
                        <span class="hide-on-big-screens me-2">
                            @include('components.sidenav-visibility-toggle-button')
                        </span>
                        <h5 onclick="window.location.href = '{{ route('home.index') }}'" class="m-0">
                            {{ config('app.name') }}
                        </h5>
                        <div class="btn invisible"><i class="bi-moon"></i></div>
                    </div>
                    <div class="mt-2">
                        <div class="d-flex align-items-center">
                            <b>Folders</b>
                            <a href="{{ route('folders.create') }}" class="ms-auto btn border-0 btn-outline-{{ preference('theme') == 'dark' ? 'light' : 'dark' }}" title="Create new folder"><i
                                    class="bi-plus-lg"></i></a>
                        </div>
                        <div class="list-group">
                            <form action="{{ route('preference.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="redirectTo" value="{{ route('tasks.index') }}">
                                <input type="hidden" name="key" value="currentFolderId">
                                <button type="submit" name="value" value="" title="The default folder"
                                    class="list-group-item list-group-item-action border-0 rounded @if (Route::is('tasks.*') && empty(preference('currentFolderId'))) bg-body-secondary @endif">General</button>
                            </form>
                            @foreach ((new \App\Models\Folder())->where('user_id', Auth::id())->orderBy('name', 'ASC')->get() as $item)
                                <form action="{{ route('preference.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="redirectTo" value="{{ route('tasks.index') }}">
                                    <input type="hidden" name="key" value="currentFolderId">
                                    <button type="submit" name="value" value="{{ $item->id }}"
                                        title="{{ $item->description ?? '' }}"
                                        class="list-group-item list-group-item-action border-0 py-0 pe-0 rounded @if (Route::is('tasks.*') && preference('currentFolderId') == $item->id) bg-body-secondary @endif">
                                        <div class="d-flex align-items-center">
                                            <span class="flex-grow-1">{{ $item->name }}</span>
                                            <div class="dropdown">
                                                <a href="#" class="btn" data-bs-toggle="dropdown">
                                                    <i class="bi-three-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('folders.edit', ['folder' => $item, 'back' => request()->fullUrl()]) }}"><i
                                                                class="bi-pencil-square"></i><span
                                                                class="ms-2">Edit</span></a></li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('folders.delete', ['folder' => $item, 'back' => request()->fullUrl()]) }}"><i
                                                                class="bi-trash"></i><span
                                                                class="ms-2">Delete</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3">
                        <b>Application</b>
                        <div class="list-group">
                            @if (Auth::user()->role->id == 1)
                                {{-- Administrator role id --}}
                                <a href="{{ route('users.index') }}"
                                    class="list-group-item list-group-item-action border-0 @if (Route::is('users.*')) bg-body-secondary rounded @endif"><i
                                        class="bi-people"></i><span class="ms-2">Users</span></a>
                            @endif
                            <form action="{{ route('preference.store') }}" method="post">
                                @csrf
                                {{-- <input type="hidden" name="redirectTo" value="{{ url()->current() }}"> --}}
                                <input type="hidden" name="key" value="theme">
                                <button type="submit" name="value"
                                    value="{{ preference('theme', 'light') == 'light' ? 'dark' : 'light' }}"
                                    class="list-group-item list-group-item-action border-0 rounded"><i
                                        class="bi-{{ preference('theme', 'light') == 'light' ? 'moon' : 'sun' }}"></i><span
                                        class="ms-2">{{ preference('theme', 'light') == 'light' ? 'Dark theme' : 'Light theme' }}</span></button>
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
                                <button type="submit"
                                    class="list-group-item list-group-item-action border-0 rounded"><i
                                        class="bi-box-arrow-left"></i><span class="ms-2">Log out</span></button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- END sidenav -->

            </div>
            <div class="col-sm">
                <div class="py-2 d-flex align-items-center overflow-auto sticky-top bg-{{ preference('theme', 'light') == 'light' ? 'white' : 'dark' }}"
                    id="topnav">
                    @include('components.sidenav-visibility-toggle-button')
                    <h5 class="m-0 ms-2 me-auto">{{ $title ?? '' }}</h5>
                    <div class="ms-2"></div>
                    @include('components.search')
                    <div class="ms-2"></div>
                    @yield('topnav')
                    @include('components.creation-button')
                    @include('components.pagination-buttons')
                </div>
                <div id="content">
                    @include('components.messages')
                    @include('components.search-text')
                    @yield('content')

                    <div class="mt-2 d-flex align-items-center justify-content-end position-sticky overflow-auto"
                        id="bottomnav">
                        @yield('bottomnav')
                        @include('components.pagination-buttons')
                    </div>
                    <div class="mt-2 hide-on-small-screens"></div>
                    <div class="hide-on-big-screens" style="height: 6em"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="/packages/bootstrap-5.3.1-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
