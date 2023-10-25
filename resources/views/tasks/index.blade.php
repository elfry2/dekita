@extends('layouts.dashboard')
@section('topnav')
    <form action="{{ route('preference.store') }}" method="post">
        @csrf
        <input type="hidden" name="redirectTo" value="{{ route($resource . '.index') }}">
        <input type="hidden" name="key" value="{{ $resource }}.filters.completionStatus">
        <div class="btn-group" role="group" aria-label="Basic outlined example">
            <button type="submit" name="value" value="0"
                class="btn border-secondary @if (!preference($resource . '.filters.completionStatus')) bg-{{ preference('theme', 'light') == 'light' ? 'dark text-light' : 'body-secondary' }} @endif"><i
                    class="hide-on-big-screens bi-square"></i><span
                    class="hide-on-small-screens">Uncompleted</span></button>
            <button type="submit" name="value" value="1"
                class="btn border-secondary @if (preference($resource . '.filters.completionStatus')) bg-{{ preference('theme', 'light') == 'light' ? 'dark text-light' : 'body-secondary' }} @endif"><i
                    class="hide-on-big-screens bi-check-lg"></i><span
                    class="hide-on-small-screens">Completed</span></button>
        </div>
    </form>
@endsection
@section('bottomnav')
@endsection
@section('content')
    @if ($primary->count() == 0)
        @include('components.no-data-text')
    @else
        <div class="row px-2">
            @foreach ($primary as $item)
                <div class="col-sm-3 p-1">
                    <div class="list-group">
                        <a href="{{ route($resource . '.edit', [Str::singular($resource) => $item]) }}"
                            class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div><small
                                    class="flex-grow-1 text-{{ $item->is_completed ? 'success' : (strtotime($item->due_date) - time() < 0 ? 'danger' : 'secondary') }}"><span
                                        title="{{ date_format(date_create($item->due_date), 'Y/m/d H:i:s') }}">{{ \Illuminate\Support\Carbon::parse($item->due_date)->diffForHumans() }}</span></small>
                            <p class="m-0 fade-on-overflow" style="max-height: 4em">{{ $item->title }}</p></div>
                                <form action="{{ route($resource . '.update', [Str::singular($resource) => $item]) }}"
                                    method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="method" value="toggleCompletionStatus">
                                    <button type="submit" class="btn"><i
                                            class="bi{{ $item->is_completed ? '-check' : '' }}-square @if ($item->is_completed) text-success @endif"></i></button>
                                </form>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
