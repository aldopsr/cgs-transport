<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $drivers = User::where('role', 'driver')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nopol', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get(); 

        return view('admin.drivers.index', compact('drivers'));
    }

    public function edit($id)
    {
        $driver = User::findOrFail($id);
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $driver = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$driver->id,
            'phone' => ['required', 'string', 'max:15'],
            'nopol' => 'required|string|max:20',
            'password' => 'nullable|min:8', 
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nopol' => $request->nopol,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $driver->update($data);

        return redirect()->route('drivers.index')->with('success', '✅ Data Driver Berhasil Diupdate!');
    }

    public function destroy($id)
    {
        $driver = User::findOrFail($id);
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', '🗑️ Driver Berhasil Dihapus!');
    }
}