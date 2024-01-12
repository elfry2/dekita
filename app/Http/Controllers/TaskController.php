<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Folder;
use App\Models\Task;

class TaskController extends Controller
{
    protected const resource = 'tasks';

    /**
     * Display a listing of the resource.
     */
    public function index(Task $task = null)
    {
        $primary = '\App\Models\\' . str(self::resource)->singular()->title();

        $data = (object) [
            'resource' => self::resource,
            'title' => str(self::resource)->title(),
            'primary'
            => (new $primary)->orderBy(
                preference(self::resource . '.order.column', 'due_date'),
                preference(self::resource . '.order.direction', 'ASC')
            ),
        ];

        $data->primary = $data->primary->where('user_id', Auth::id());

        $currentFolder = Folder::find(preference('currentFolderId'));

        $data->title = $currentFolder ? $currentFolder->name : 'General';

        $data->primary = $data->primary->where(
            'folder_id',
            preference('currentFolderId')
        );

        $data->primary = $data->primary->where(
            'is_completed',
            preference(self::resource . '.filters.completionStatus', false)
        );


        if (!empty(request('q'))) {
            $data->primary
            = $data->primary->where('title', 'like', '%' . request('q') . '%');
        }

        $data->primary = $data->primary
        ->paginate(config('app.rowsPerPage'))->withQueryString();

        if(isset($task)) {

            if($task->user != Auth::user()) abort(403);

            $data->secondary = $task;
        }

        return view(self::resource . '.index', (array) $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::resource . '.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = (object) $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'due_date' => [
                'nullable',
                'date',
                Rule::requiredIf(fn () => !empty($request->due_time))
            ],
            'due_time' => 'nullable|max:9',
        ]);

        $validated->due_date
            = isset($validated->due_date) ? $validated->due_date : null;

        if(isset($validated->due_date))
            $validated->due_date
            .= ' ' . (isset($validated->due_time) ? $validated->due_time : '23:59:59');

       $task = Task::create([
            'title' => $validated->title,
            'content' => $validated->content,
            'due_date' => $validated->due_date ?: null,
            'folder_id' => preference('currentFolderId'),
            'user_id' => Auth::id(),
        ]);

        return redirect(route(
            self::resource . '.edit',
            [Str::singular(self::resource) => $task]
        ))->with('message', (object) [
            'type' => 'success',
            'content' => str(self::resource)->singular()->title() . ' created.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return redirect(route(self::resource . '.edit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $primary = $task;

        $data = (object) [
            'resource' => self::resource,
            'title' => 'Edit ' . str(self::resource)->title()->singular()->lower(),
            'primary' => $primary,
        ];

        return view(self::resource . '.edit', (array) $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $primary = $task;

        if($primary->user != Auth::user()) abort(403);

        if ($request->method === 'toggleCompletionStatus') {
            $currentCompletionStatus = $primary->is_completed;

            $primary->update(['is_completed' => !$currentCompletionStatus]);

            return redirect()->back()
            ->with('message', (object) [
                'type' => 'success',
                'content' => str(self::resource)->title()->singular()
                . ($currentCompletionStatus ? ' completion cancelled.' : ' completed.')
            ]);
        }

        $validated = (object) $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'due_date' => [
                'nullable',
                'date',
                Rule::requiredIf(fn () => !empty($request->due_time))
            ],
            'due_time' => 'nullable|max:9',
            'folder_id' => 'integer|exists:folders,id'
        ]);

        $validated->due_date
            = isset($validated->due_date) ? $validated->due_date : null;

        if(isset($validated->due_date))
            $validated->due_date
            .= ' ' . (isset($validated->due_time) ? $validated->due_time : '23:59:59');

        $primary->update([
            'title' => $validated->title,
            'content' => $validated->content,
            'due_date' => $validated->due_date ?: null,
            'folder_id' => preference('currentFolderId'),
            'user_id' => Auth::id(),
        ]);

        return redirect(route(
            self::resource . '.edit',
            [Str::singular(self::resource) => $task]
        ))->with('message', (object) [
            'type' => 'success',
            'content' => str(self::resource)->singular()->title() . ' updated.'
        ]);
    }

    /**
     * Show the form for deleting the specified resource.
     */
    public function delete(Task $task)
    {
        $primary = $task;

        $data = (object) [
            'resource' => self::resource,
            'title' => 'Delete ' . str(self::resource)->title()->singular()->lower(),
            'primary' => $primary
        ];

        return view(self::resource . '.delete', (array) $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $primary = $task;

        $primary->delete();

        return redirect(route(self::resource . '.index'))
        ->with('message', (object) [
            'type' => 'success',
            'content' => str(self::resource)->singular()->title() . ' deleted.'
        ]);
    }

    /**
     * Show the form for editing the preferences for the listing of the resource.
     */
    public function preferences()
    {
        $data = (object) [
            'resource' => self::resource,
            'title' => str(self::resource)->title() . ' preferences',
            'primary' => Schema::getColumnListing(self::resource),
        ];

        $data->primary = collect($data->primary)->map(function ($element) {
            return (object) [
                'value' => $element,
                'label' => str($element)->headline(),
            ];
        });

        return view(self::resource . '.preferences', (array) $data);
    }

    /**
     * Update the preferences for the listing of the resource in storage.
     */
    public function applyPreferences(Request $request)
    {
        $validated = (object) $request->validate([
            'order_column' => 'required|max:255',
            'order_direction' => 'required|max:255',
        ]);

        foreach ([
            [self::resource . '.order.column' => $validated->order_column],
            [self::resource . '.order.direction' => $validated->order_direction],
        ] as $preference) {
            preference($preference);
        }

        return redirect(route(self::resource . '.index'))
            ->with('message', (object) [
                'type' => 'success',
                'content' => 'Preferences updated.'
            ]);
    }

    /**
     * Show the form for searching the resource.
     */
    public function search()
    {
        $data = (object) [
            'resource' => self::resource,
            'title' => 'Search ' . str(self::resource)->title()->lower()
        ];

        return view(self::resource . '.search', (array) $data);
    }
}
