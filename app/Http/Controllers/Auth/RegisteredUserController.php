<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    protected const resource = 'users';

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
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function edit(User $user)
    {
        $primary = $user;

        $data = (object) [
            'resource' => self::resource,
            'title' => 'Edit ' . str(self::resource)->title()->singular()->lower(),
            'backURL' => route(self::resource . '.index'),
            'primary' => $primary,
            'secondary' => Role::all(),
        ];

        return view(self::resource . '.edit', (array) $data);
    }
    
    public function update(Request $request, User $user) {
        $validated = (object) $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|alpha_num:ascii|max:255',
            'email' => 'required|max:255|email',
            'password' => 'nullable|max:255',
            'role_id' => 'required|integer',
            'avatar' => 'nullable|image|max:10240',
            'suspended_until' => 'nullable|date'
        ]);

        $user->name = $validated->name;

        if($validated->username != $user->username) {
            $request->validate([
                'username' => 'unique:users',
            ]);

            $user->username = $validated->username;
        }

        if($validated->email != $user->email) {
            $request->validate([
                'email' => 'unique:users',
            ]);

            $user->email = $validated->email;
        }

        $user->role_id = $validated->role_id;

        $user->suspended_until = $validated->suspended_until;

        if(isset($validated->avatar)) {
            Storage::delete($user->avatar ?: '');
            
            $avatarPath = $request->file('avatar')->store('avatars');
            
            $user->avatar = $avatarPath;
        }

        if(isset($validated->password)) {
            $user->password = Hash::make($validated->password);
        }

        $user->save();

        return redirect()->back()
        ->with('message', (object) [
            'type' => 'success',
            'content' => str(self::resource)->singular()->title . ' updated.'
        ]);
    }

    public function delete(User $user)
    {
        $primary = $user;

        $data = (object) [
            'resource' => self::resource,
            'title' => 'Delete ' . str(self::resource)->title()->singular()->lower(),
            'primary' => $primary
        ];

        return view(self::resource . '.delete', (array) $data);
    }

    public function destroy(User $user)
    {
        if($user->id == Auth::id())
        return redirect(route(self::resource . '.index'))
        ->with('message', (object) [
            'type' => 'warning',
            'content' => 'Cannot delete as the same user.',
        ]);

        Storage::delete($user->avatar ?: '');

        $user->preferences()->delete();

        $user->delete();

        return redirect(route(self::resource . '.index'))
        ->with('message', (object) [
            'type' => 'success',
            'content' => str(self::resource)->singular()->title . ' deleted.'
        ]);
    }
}
