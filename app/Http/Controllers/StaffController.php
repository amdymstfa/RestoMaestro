<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    /**
     * Display a listing of staff members
     */
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'client');
        
        // Filtres
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $staff = $query->orderBy('name')->paginate(15);
        
        return view('manager.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff member
     */
    public function create()
    {
        return view('manager.staff.create');
    }

    /**
     * Store a newly created staff member
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:manager,waiter,cook'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('manager.staff.index')
            ->with('success', 'Membre du personnel créé avec succès.');
    }

    /**
     * Display the specified staff member
     */
    public function show(User $user)
    {
        return view('manager.staff.show', compact('user'));
    }

    /**
     * Show the form for editing the specified staff member
     */
    public function edit(User $user)
    {
        return view('manager.staff.edit', compact('user'));
    }

    /**
     * Update the specified staff member
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:manager,waiter,cook'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = $request->only(['name', 'email', 'phone', 'role']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('manager.staff.show', $user)
            ->with('success', 'Membre du personnel mis à jour avec succès.');
    }

    /**
     * Remove the specified staff member
     */
    public function destroy(User $user)
    {
        if ($user->role === 'client') {
            return back()->withErrors(['user' => 'Impossible de supprimer un client depuis cette interface.']);
        }

        $user->delete();

        return redirect()->route('manager.staff.index')
            ->with('success', 'Membre du personnel supprimé avec succès.');
    }
}
