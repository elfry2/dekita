<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class FolderController extends Controller
{
    protected const resource = 'folders';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $primary = '\App\Models\\' . str(self::resource)->singular()->title();

        $data = (object) [
            'resource' => self::resource,
            'title' => str(self::resource)->title(),
            'primary'
            => (new $primary)
                ->orderBy(
                    preference(self::resource . '.order.column', 'id'),
                    preference(self::resource . '.order.direction', 'ASC')
            ),
        ];

        if (!empty(request('q'))) {
            $data->primary
            = $data->primary->where('name', 'like', '%' . request('q') . '%');
        }

        $data->primary = $data->primary->paginate(config('app.rowsPerPage'));

        return view(self::resource . '.index', (array) $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = (object) [
            'resource' => self::resource,
            'title' => 'Edit ' . str(self::resource)->title()->singular()->lower(),
            'user_id' => 'required|integer|exists:users,id',
        ];

        return view(self::resource . '.create', (array) $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = (object) $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:255',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        Folder::create([
            'name' => $validated->name,
            'description' => $validated->description,
        ]);
        
        return redirect(route(self::resource . '.index'))
        ->with('message', (object) [
            'type' => 'success',
            'content' => str(self::resource)->singular()->title(). ' created.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Folder $folder)
    {
        $primary = $folder;

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
    public function update(Request $request, Folder $folder)
    {
        $primary = $folder;

        $validated = (object) $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:255',
        ]);

        $primary->name = $validated->name;

        $primary->description = $validated->description;

        $primary->save();

        return redirect()->back()
        ->with('message', (object) [
            'type' => 'success',
            'content' => str(self::resource)->singular()->title(). ' updated.'
        ]);
    }

    /**
     * Show the form for deleting the specified resource.
     */
    public function delete(Folder $folder)
    {
        $primary = $folder;

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
    public function destroy(Folder $folder)
    {
        $primary = $folder;

        $primary->tasks()->delete();

        $primary->delete();

        return redirect(route(self::resource . '.index'))
        ->with('message', (object) [
            'type' => 'success',
            'content' => str(self::resource)->singular()->title() . ' deleted.'
        ]);
    }

    /**
     * Show the form for editing the preferences for specified resource.
     */
    public function preferences() {
        $data = (object) [
            'resource' => self::resource,
            'title' => str(self::resource)->title() . ' preferences',
            'primary' => Schema::getColumnListing(self::resource),
        ];

        $data->primary = collect($data->primary)->map(function($element) {
            return (object) [
                'value' => $element,
                'label' => str($element)->headline(),
            ];
        });
        
        return view(self::resource . '.preferences', (array) $data);
    }

    /**
     * Update the preferences for specified resource in storage.
     */
    public function applyPreferences(Request $request) {
        $validated = (object) $request->validate([
            'order_column' => 'required|max:255',
            'order_direction' => 'required|max:255',
        ]);

        foreach([
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
}
