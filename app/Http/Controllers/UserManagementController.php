<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeAdmin();

        $activeRole = $request->query('role', $request->route('role'));

        $usersQuery = User::query()->latest();
        if (in_array($activeRole, ['admin', 'petugas', 'peminjam'], true)) {
            $usersQuery->where('role', $activeRole);
        } else {
            $activeRole = null;
        }

        return view('users.index', [
            'users' => $usersQuery->paginate(10)->withQueryString(),
            'totalAdmin' => User::where('role', 'admin')->count(),
            'totalPetugas' => User::where('role', 'petugas')->count(),
            'totalPeminjam' => User::where('role', 'peminjam')->count(),
            'activeRole' => $activeRole,
        ]);
    }

    public function create(): View
    {
        $this->authorizeAdmin();
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,petugas,peminjam'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user): View
    {
        $this->authorizeAdmin();
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $this->authorizeAdmin();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,petugas,peminjam'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorizeAdmin();

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->withErrors(['user' => 'Tidak bisa menghapus akun sendiri.']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403, 'Akses ditolak.');
    }
}
