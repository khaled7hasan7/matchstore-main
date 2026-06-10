<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShippingZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.shipping-zones.index');
    }

    /**
     * Get data for DataTables.
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $zones = ShippingZone::query();

            return DataTables::of($zones)
                ->addIndexColumn()
                ->addColumn('countries', function ($zone) {
                    if (in_array('*', $zone->countries)) {
                        return '<span class="badge bg-secondary">All Countries</span>';
                    }
                    return collect($zone->countries)->map(function ($code) {
                        return '<span class="badge bg-primary">' . $code . '</span>';
                    })->implode(' ');
                })
                ->addColumn('base_cost', function ($zone) {
                    return '$' . number_format($zone->base_cost, 2);
                })
                ->addColumn('per_kg_cost', function ($zone) {
                    return '$' . number_format($zone->per_kg_cost, 2);
                })
                ->addColumn('status', function ($zone) {
                    $checked = $zone->is_active ? 'checked' : '';
                    return '<div class="form-check form-switch">
                                <input class="form-check-input status-toggle" type="checkbox"
                                       data-id="' . $zone->id . '" ' . $checked . '>
                            </div>';
                })
                ->addColumn('actions', function ($zone) {
                    return '
                        <a href="' . route('shipping-zones.edit', $zone->id) . '"
                           class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn"
                                data-id="' . $zone->id . '">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    ';
                })
                ->rawColumns(['countries', 'status', 'actions'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping-zones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'countries' => 'required|array|min:1',
            'countries.*' => 'required|string|max:10',
            'base_cost' => 'required|numeric|min:0',
            'per_kg_cost' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        ShippingZone::create([
            'name' => $request->name,
            'countries' => $request->countries,
            'base_cost' => $request->base_cost,
            'per_kg_cost' => $request->per_kg_cost ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('shipping-zones.index')
            ->with('success', 'Shipping zone created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingZone $shippingZone)
    {
        return view('admin.shipping-zones.edit', compact('shippingZone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingZone $shippingZone)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'countries' => 'required|array|min:1',
            'countries.*' => 'required|string|max:10',
            'base_cost' => 'required|numeric|min:0',
            'per_kg_cost' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $shippingZone->update([
            'name' => $request->name,
            'countries' => $request->countries,
            'base_cost' => $request->base_cost,
            'per_kg_cost' => $request->per_kg_cost ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('shipping-zones.index')
            ->with('success', 'Shipping zone updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingZone $shippingZone)
    {
        $shippingZone->delete();

        return response()->json([
            'success' => true,
            'message' => 'Shipping zone deleted successfully!'
        ]);
    }

    /**
     * Toggle the status of a shipping zone.
     */
    public function toggleStatus(Request $request)
    {
        $zone = ShippingZone::findOrFail($request->id);
        $zone->is_active = !$zone->is_active;
        $zone->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }
}
