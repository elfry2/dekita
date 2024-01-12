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
<div class="row">
    <div class="col-sm-6">
        <div class="rounded border border-bottom-0 table-responsive">
            <table class="m-0 table table-hover align-middle">
                <tr>
                    <th></th>
                    <th>Due date</th>
                    <th>Title</th>
                </tr>
                @foreach ($primary as $row)
                <tr class="@if(isset($secondary) && $secondary->id == $row->id) fw-bold @endif" id="row{{ $loop->index + 1 }}" style="cursor: pointer" onclick="window.location.href = '{{ route("$resource.show", [Str::singular($resource) => $row->id]) }}'">
                    <td>
                        <form action="{{ route("$resource.update", [Str::singular($resource) => $row]) }}"
                              method="post">
                              @csrf
                              @method('patch')
                              <input type="hidden" name="method" value="toggleCompletionStatus">
                              <button type="submit" class="btn p-0"><i
                                                    class="bi{{ $row->is_completed ? '-check' : '' }}-square @if ($row->is_completed) text-success @endif"></i></button>
                        </form>
                    </td>
                    <td class="text-{{ $row->is_completed ? 'success' : (strtotime($row->due_date) - time() < 0 ? 'danger' : (preference('theme') == 'dark' ? 'light' : 'dark') ) }}" title="{{ date_format(date_create($row->due_date), 'Y/m/d H:i:s') }}">{{ \Illuminate\Support\Carbon::parse($row->due_date)->diffForHumans() }}</td>
                    <td>{{ str($row->title)->length > 40 ? str($row->title)->take(40) . '...' : $row->title }}</td>
                </tr>
                @endforeach
            </table>
        </div>

    </div>
    <div class="col-sm-6">
        <form action="{{ route(str($resource) . '.store') }}" method="post">
            @if(isset($secondary))
            @method('patch')
            @endif
            @csrf
            <div class="d-flex align-items-center justify-content-end">
                <div class="form-floating flex-grow-1">
                    <input name="title" type="text" id="titleTextInput" class="form-control" placeholder="" value="{{ old('title') ?? (isset($secondary) ? $secondary->title : '') }}" autofocus>
                    <label for="titleTextInput">Title</label>
                </div>
                <button class="flex-shrink-0 ms-2 btn border-0 btn-outline-{{ preference('theme') == 'dark' ? 'light' : 'dark' }}" type="submit"><i class="bi-{{ isset($secondary) ? 'pencil-square' : 'plus-lg' }}"></i><span class="ms-2">{{ isset($secondary) ? 'Save' : 'Create' }}</span></button>
            </div>
            <div class="mt-3">
                <textarea name="content" type="text" id="contentTextArea" placeholder="You can use markdown ;)">{{ isset($secondary) ? $secondary->content : '' }}</textarea>
                <script>
                    var simplemde = new SimpleMDE();
                </script>
            </div>
        </form>

    </div>
</div>
@endif
@endsection
