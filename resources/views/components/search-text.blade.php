@if (!empty(request('q')))
        <p>Showing {{ $resource }} like "{{ request('q') }}". <a href="{{ url()->current() }}">Clear</a></p>
    @endif