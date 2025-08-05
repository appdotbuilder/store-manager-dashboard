<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StoreController extends Controller
{
    /**
     * Display a listing of the stores.
     */
    public function index(Request $request)
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $stores = Store::with(['users' => function ($query) {
            $query->where('role', 'store_admin');
        }])
        ->withCount(['orders', 'products', 'customers'])
        ->latest()
        ->paginate(10);

        return Inertia::render('stores/index', [
            'stores' => $stores,
        ]);
    }

    /**
     * Show the form for creating a new store.
     */
    public function create(Request $request)
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        return Inertia::render('stores/create');
    }

    /**
     * Store a newly created store in storage.
     */
    public function store(StoreStoreRequest $request)
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $store = Store::create($request->validated());

        return redirect()->route('stores.show', $store)
            ->with('success', 'Store created successfully.');
    }

    /**
     * Display the specified store.
     */
    public function show(Request $request, Store $store)
    {
        $user = $request->user();
        
        if (!$user->isSuperAdmin() && $user->store_id !== $store->id) {
            abort(403, 'Unauthorized');
        }
        
        $store->load([
            'users' => function ($query) {
                $query->where('role', 'store_admin');
            },
            'orders' => function ($query) {
                $query->latest()->take(5);
            },
            'products' => function ($query) {
                $query->latest()->take(5);
            },
        ]);
        
        $store->loadCount(['orders', 'products', 'customers']);

        return Inertia::render('stores/show', [
            'store' => $store,
        ]);
    }

    /**
     * Show the form for editing the specified store.
     */
    public function edit(Request $request, Store $store)
    {
        $user = $request->user();
        
        if (!$user->isSuperAdmin() && $user->store_id !== $store->id) {
            abort(403, 'Unauthorized');
        }
        
        return Inertia::render('stores/edit', [
            'store' => $store,
        ]);
    }

    /**
     * Update the specified store in storage.
     */
    public function update(UpdateStoreRequest $request, Store $store)
    {
        $user = $request->user();
        
        if (!$user->isSuperAdmin() && $user->store_id !== $store->id) {
            abort(403, 'Unauthorized');
        }
        
        $store->update($request->validated());

        return redirect()->route('stores.show', $store)
            ->with('success', 'Store updated successfully.');
    }

    /**
     * Remove the specified store from storage.
     */
    public function destroy(Request $request, Store $store)
    {
        if (!$request->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $store->delete();

        return redirect()->route('stores.index')
            ->with('success', 'Store deleted successfully.');
    }


}