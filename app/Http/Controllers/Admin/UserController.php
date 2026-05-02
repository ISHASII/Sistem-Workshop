<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $departements = \App\Models\Departement::orderBy('name')->get();

        return view('admin.users.create', compact('departements'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,customer,management-customer',
            'department_id' => 'required_if:role,customer,management-customer|exists:departements,id',
        ]);

        $user = User::create([
            'username' => $data['username'],
            'name' => $data['name'] ?? $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'department_id' => $data['department_id'] ?? null,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $departements = \App\Models\Departement::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'departements'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,customer,management-customer',
            'department_id' => 'required_if:role,customer,management-customer|exists:departements,id',
        ]);

        $user->username = $data['username'];
        $user->name = $data['name'] ?? $data['username'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->department_id = $data['department_id'] ?? null;

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // prevent deleting self
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
