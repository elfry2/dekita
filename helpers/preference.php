<?php
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Preference;

function preference(string|array $key, $default = null) {
    if(is_string($key)) {
        $preference = null;

        if(Auth::id()) {
            $preference = Preference::where('user_id', Auth::id())
            ->where('key', $key)
            ->first();

            if(!is_null($preference))
            $preference = $preference->value;
        }

        else $preference = session($key);

        if(is_null($preference) || $preference === '') return $default;

        return $preference;
    }

    if(is_array($key)) {
        $preference = $key;

        if(Auth::id()) Preference::updateOrCreate([
            'user_id' => Auth::id(),
            'key' => key($preference)
        ], [
            'value' => current($preference)
        ]);

        else session([key($preference) => current($preference)]);
    }
}
