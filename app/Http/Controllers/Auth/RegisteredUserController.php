<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:15'],
            'nopol' => ['required', 'string', 'max:20'], 
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // Validasi tambahan untuk foto: wajib, harus gambar, max 5MB
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'], 
        ]);

        // Proses penyimpanan foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Akan tersimpan di folder: storage/app/public/driver_photos/
            $photoPath = $request->file('photo')->store('driver_photos', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nopol' => strtoupper($request->nopol), 
            'role' => 'driver', 
            'password' => Hash::make($request->password),
            // Simpan path foto ke database
            'photo' => $photoPath,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}