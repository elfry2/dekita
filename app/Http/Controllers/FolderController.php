<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class FolderController extends Controller
{
    protected const resource = 'folders';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = (object) [
            'resource' => self::resource,
            'title' => 'Create ' . str(self::resource)->title()->singular()->lower()
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
        ]);

        $folder = Folder::create([
            'name' => $validated->name,
            'description' => $validated->description,
            'user_id' => Auth::id(),
        ]);

        preference('currentFolderId', $folder->id);

        return redirect(route('tasks.index'))
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

        if($primary->user != Auth::user()) abort(403);

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

        if($primary->user != Auth::user()) abort(403);

        $validated = (object) $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:255',
        ]);

        $primary->name = $validated->name;

        $primary->description = $validated->description;

        $primary->save();

        preference('currentFolderId', $folder->id);

        return redirect(route('tasks.index')) // tasks.index
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

        return redirect(route('tasks.index')) // tasks.index
        ->with('message', (object) [
            'type' => 'success',
            'content' => str(self::resource)->singular()->title(). ' deleted.'
        ]);
    }

    /**
     * Show the form for editing the preferences for the listing of the resource.
     */
    public function preferences() {
        //
    }

    /**
     * Update the preferences for the listing of the resource in storage.
     */
    public function applyPreferences(Request $request) {
        //
    }

    /**
     * Show the form for searching the resource.
     */
    public function search() {
        //
    }
}
