@extends('layouts.dashboard')
@section('topnav')
    <form action="{{ route('preference.store') }}" method="post">
        @csrf
        <input type="hidden" name="redirectTo" value="{{ route($resource . '.index') }}">
        <input type="hidden" name="key" value="{{ $resource }}.filters.completionStatus">
        <div class="btn-group" role="group" aria-label="Basic outlined example">
            <button type="submit" name="value" value="0"
                class="btn {{ !preference($resource . '.filters.completionStatus') ? 'btn-' . (preference('theme', 'light') == 'light' ? 'dark' : 'light') : 'border-secondary' }}"><i class="hide-on-big-screens bi-square"></i><span class="hide-on-small-screens">Uncompleted</span></button>
            <button type="submit" name="value" value="1"
                class="btn {{ preference($resource . '.filters.completionStatus') ? 'btn-' . (preference('theme', 'light') == 'light' ? 'dark' : 'light') : 'border-secondary' }}"><i class="hide-on-big-screens bi-check-lg"></i><span class="hide-on-small-screens">Completed</span></button>
        </div>
    </form>
@endsection
@section('bottomnav')
@endsection
@section('content')
    @if ($primary->count() == 0)
        @include('components.no-data-text')
    @else
            @foreach ($primary as $row)
            <div class="list-group mt-2">
                <a href="{{ route($resource . '.edit', [Str::singular($resource) => $row]) }}"
                    class="list-group-item list-group-item-action d-flex align-items-center">
                    <div class="my-2 flex-grow-1">
                        <small class="text-{{ $row->is_completed ? 'success' : (strtotime($row->due_date) - time() < 0 ? 'danger' : 'secondary')  }}"><span title="{{ date_format(date_create($row->due_date), 'Y/m/d H:i:s') }}">{{ \Illuminate\Support\Carbon::parse($row->due_date)->diffForHumans() }}</span></small>
                        <p class="m-0">{{ $row->title }}</p>
                        {{-- @if ($row->content)
                            <p class="m-0">{{ str($row->content)->limit(128) }}</p>
                        @endif --}}
                    </div>
                    <form action="{{ route($resource . '.update', [Str::singular($resource) => $row]) }}" method="post">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="method" value="toggleCompletionStatus">
                        <button type="submit" class="btn"><i
                                class="bi{{ $row->is_completed ? '-check' : '' }}-square @if($row->is_completed) text-success @endif"></i></button>
                    </form>
                </a>
            </div>
            @endforeach
    @endif
@endsection
