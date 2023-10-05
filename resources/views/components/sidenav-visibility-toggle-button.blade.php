<form action="{{ route('preference.store') }}" method="post">
    @csrf
    {{-- <input type="hidden" name="redirectTo" value="{{ url()->current() }}"> --}}
    <input type="hidden" name="key" value="nav.display">
    <button id="sidenavVisibilityToggleButton" type="submit" name="value"
        value="{{ preference('nav.display', 'block') == 'block' ? 'none' : 'block' }}" class="btn"><i
            class="bi-list"></i></button>
</form>