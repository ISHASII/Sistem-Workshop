<?php

namespace App\Http\Controllers\ManagementEpp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        if (!$user->isManagementEpp()) {
            abort(403);
        }

        return view('management-epp.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        if (!$user->isManagementEpp()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $data['name'];
        $user->username = $data['username'];

        if (!empty($data['password'])) {
            if (empty($data['current_password']) || !Hash::check($data['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }

            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('management-epp.profile.edit')->with('success', 'Profil diperbarui.');
    }
}
