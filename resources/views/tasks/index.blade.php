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
<div class="row">
    <div class="col-sm-6">
        <div class="rounded border border-bottom-0 table-responsive">
            <table class="m-0 table table-hover align-middle">
                <tr>
                    <th></th>
                    <th>Due date</th>
                    <th>Title</th>
                </tr>
                @if ($primary->count() == 0)
                <tr>
                    <td class="text-center" colspan="3">No task yet. Let's create one!</td>
                </tr>
                @else
                @foreach ($primary as $row)
                <tr class="@if(isset($secondary) && $secondary->id == $row->id) fw-bold @endif" id="row{{ $loop->index + 1 }}" style="cursor: pointer" onclick="window.location.href = '{{ route("$resource.edit", [Str::singular($resource) => $row->id]) }}'">
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
                    <td class="text-{{ $row->is_completed ? 'success' : (strtotime($row->due_date) - time() < 0 ? 'danger' : (preference('theme') == 'dark' ? 'light' : 'dark') ) }}" title="{{ date_format(date_create($row->due_date), 'Y/m/d H:i:s') }}">{{ isset($row->due_date) ? \Illuminate\Support\Carbon::parse($row->due_date)->diffForHumans() : '' }}</td>
                    <td>{{ str($row->title)->length > 40 ? str($row->title)->take(40) . '...' : $row->title }}</td>
                </tr>
                @endforeach
            @endif
            </table>
        </div>
    </div>
    <div class="col-sm-6">
        <form action="{{ isset($secondary) ? route("$resource.update", [Str::singular($resource) => $secondary]) : route("$resource.store") }}" method="post">
            @if(isset($secondary))
            @method('patch')
            @endif
            @csrf
            <div class="d-flex align-items-center justify-content-end">
                <div class="form-floating flex-grow-1">
                    <input name="title" type="text" id="titleTextInput" class="form-control" placeholder="" value="{{ old('title') ?? (isset($secondary) ? $secondary->title : '') }}" autofocus>
                    <label for="titleTextInput">Title</label>
                </div>
                <button class="flex-shrink-0 ms-2 btn border-0 btn-outline-{{ preference('theme') == 'dark' ? 'light' : 'dark' }}" type="submit"><i class="bi-pencil-square"></i><span class="ms-2">Save</span></button>
                @if(isset($secondary))
                    <a href="{{ route(str($resource) . '.delete', [Str::singular($resource) => $secondary]) }}" class="btn border-0 btn-outline-danger" title="Delete {{ str($resource)->singular() }}"><i class="bi-trash"></i></a>
                @endif
            </div>
        <div class="row mt-2">
            <div class="col-sm-7 mt-1">
                <div class="form-floating">
                    <input name="due_date" type="date" id="dueDateInput" class="form-control"
                        placeholder=""
                        value="{{ old('due_date') ?? (isset($secondary->due_date) ? date_format(date_create($secondary->due_date), 'Y-m-d') : '') }}">
                    <label for="dueDateInput">Date</label>
                </div>
            </div>
            <div class="col-sm-5 mt-1">
                <div class="form-floating">
                    <input name="due_time" type="time" id="dueTimeInput" class="form-control"
                        placeholder=""
                        value="{{ old('due_time') ?? (isset($secondary->due_date) ? date_format(date_create($secondary->due_date), 'H:i:s') : '') }}">
                    <label for="suspendedUntilDateInput">Time</label>
                </div>
            </div>
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
@endsection
