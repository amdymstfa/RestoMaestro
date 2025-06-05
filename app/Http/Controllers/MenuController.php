<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware(['auth', 'role:manager']);
    }
    */

    public function index(Request $request)
    {
        $query = MenuItem::query();

        // Filtres
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('is_available')) {
            $query->where('is_available', $request->is_available);
        }

        $menuItems = $query->orderBy('category')
                          ->orderBy('name')
                          ->paginate(15);

        $categories = MenuItem::distinct('category')
                             ->pluck('category')
                             ->filter()
                             ->sort();

        return view('manager.menus.index', compact('menuItems', 'categories'));
    }

    public function create()
    {
        $categories = MenuItem::distinct('category')
                             ->pluck('category')
                             ->filter()
                             ->sort();

        return view('manager.menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'allergens' => 'nullable|array',
            'allergens.*' => 'string|max:100',
            'is_available' => 'boolean',
            'is_special' => 'boolean',
        ]);

        $validated['is_available'] = $request->has('is_available');
        $validated['is_special'] = $request->has('is_special');
        $validated['allergens'] = $request->input('allergens', []);

        MenuItem::create($validated);

        return redirect()->route('manager.menus.index')
                        ->with('success', 'Plat créé avec succès.');
    }

    public function show(MenuItem $menu)
    {
        return view('manager.menus.show', compact('menu'));
    }

    public function edit(MenuItem $menu)
    {
        $categories = MenuItem::distinct('category')
                             ->pluck('category')
                             ->filter()
                             ->sort();

        return view('manager.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'allergens' => 'nullable|array',
            'allergens.*' => 'string|max:100',
            'is_available' => 'boolean',
            'is_special' => 'boolean',
        ]);

        $validated['is_available'] = $request->has('is_available');
        $validated['is_special'] = $request->has('is_special');
        $validated['allergens'] = $request->input('allergens', []);

        $menu->update($validated);

        return redirect()->route('manager.menus.show', $menu)
                        ->with('success', 'Plat mis à jour avec succès.');
    }

    public function destroy(MenuItem $menu)
    {
        $menu->delete();

        return redirect()->route('manager.menus.index')
                        ->with('success', 'Plat supprimé avec succès.');
    }

    public function toggleSpecial(MenuItem $menu)
    {
        $menu->update([
            'is_special' => !$menu->is_special
        ]);

        $message = $menu->is_special 
            ? 'Plat marqué comme spécial du jour.' 
            : 'Plat retiré des spéciaux.';

        return redirect()->back()->with('success', $message);
    }
}
