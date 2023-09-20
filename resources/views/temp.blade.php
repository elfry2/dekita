<div class="row m-0 h-100 overflow-auto">
            <div class="col-sm-2 p-0 h-100 mt-2 mx-2 d-{{ preference('nav.display', 'block') }}" id="nav">
                <div class="d-flex align-items-center">
                    <h3 class="m-0">{{ config('app.name') }}</h3>
                    <button class="btn invisible"><i class="bi-moon"></i></button>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center">
                        <b class="m-0">Folders</b>
                        <a href="{{ route('folders.create') }}" class="ms-auto text-dark"><i class="bi-plus-lg"></i></a>
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
            <div class="col-sm p-0 h-100" id="page">
                <div class="d-flex align-items-center mt-2 mx-2 overflow-auto" id="actions">
                    <form action="{{ route('preference.store') }}" method="post">
                        @csrf
                        {{-- <input type="hidden" name="redirectTo" value="{{ url()->current() }}"> --}}
                        <input type="hidden" name="key" value="nav.display">
                        <button type="submit" name="value"
                            value="{{ preference('nav.display', 'block') == 'block' ? 'none' : 'block' }}" class="btn"><i
                                class="bi-list"></i></button>
                    </form>
                    <h3 class="m-0 ms-2 me-auto">{{ $title ?? '' }}</h3>
                    @yield('actions')
                </div>
                <div class="mt-2 mx-2" id="content">
                  @yield('content')
                </div>
            </div>
        </div>