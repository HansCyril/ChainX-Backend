<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rider;
use Illuminate\Http\Request;

class RiderController extends Controller
{
    public function index(Request $request)
    {
        $query = Rider::withCount('orders')->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('vehicle', 'like', '%' . $request->search . '%');
            });
        }

        $riders = $query->paginate(15)->withQueryString();
        return view('admin.riders.index', compact('riders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'vehicle' => 'nullable|string|max:255',
        ]);

        Rider::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'vehicle' => $request->vehicle,
            'is_active' => true,
        ]);

        return back()->with('success', 'Rider added successfully.');
    }

    public function update(Request $request, Rider $rider)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'vehicle' => 'nullable|string|max:255',
        ]);

        $rider->update($request->all());

        return back()->with('success', 'Rider updated successfully.');
    }

    public function destroy(Rider $rider)
    {
        $rider->delete();
        return back()->with('success', 'Rider deleted.');
    }

    public function toggleStatus(Rider $rider)
    {
        $rider->update(['is_active' => !$rider->is_active]);
        return back()->with('success', 'Status updated.');
    }
}
