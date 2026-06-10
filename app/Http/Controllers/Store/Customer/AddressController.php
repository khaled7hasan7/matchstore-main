<?php

namespace App\Http\Controllers\Store\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    /**
     * Display a listing of customer addresses
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $addresses = $customer->addresses()->latest()->get();

        return view('themes.xylo.customer.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new address
     */
    public function create()
    {
        return view('themes.xylo.customer.addresses.create');
    }

    /**
     * Store a newly created address
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'additional_info' => 'nullable|string|max:500',
            'is_default' => 'boolean',
        ]);

        $customer = Auth::guard('customer')->user();
        $validated['customer_id'] = $customer->id;

        // If this is set as default, unset all other defaults
        if ($request->has('is_default') && $request->is_default) {
            $customer->addresses()->update(['is_default' => false]);
        }

        // If this is the first address, make it default automatically
        if ($customer->addresses()->count() === 0) {
            $validated['is_default'] = true;
        }

        CustomerAddress::create($validated);

        return redirect()->route('customer.addresses.index')
            ->with('success', __('store.addresses.address_created'));
    }

    /**
     * Show the form for editing an address
     */
    public function edit($id)
    {
        $customer = Auth::guard('customer')->user();
        $address = $customer->addresses()->findOrFail($id);

        return view('themes.xylo.customer.addresses.edit', compact('address'));
    }

    /**
     * Update the specified address
     */
    public function update(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();
        $address = $customer->addresses()->findOrFail($id);

        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'additional_info' => 'nullable|string|max:500',
            'is_default' => 'boolean',
        ]);

        // If this is set as default, unset all other defaults
        if ($request->has('is_default') && $request->is_default) {
            $customer->addresses()->where('id', '!=', $id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('customer.addresses.index')
            ->with('success', __('store.addresses.address_updated'));
    }

    /**
     * Remove the specified address
     */
    public function destroy($id)
    {
        $customer = Auth::guard('customer')->user();
        $address = $customer->addresses()->findOrFail($id);

        // If deleting the default address, set another one as default
        if ($address->is_default) {
            $newDefault = $customer->addresses()->where('id', '!=', $id)->first();
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        $address->delete();

        return redirect()->route('customer.addresses.index')
            ->with('success', __('store.addresses.address_deleted'));
    }

    /**
     * Set an address as default
     */
    public function setDefault($id)
    {
        $customer = Auth::guard('customer')->user();
        $address = $customer->addresses()->findOrFail($id);

        // Unset all other defaults
        $customer->addresses()->update(['is_default' => false]);

        // Set this one as default
        $address->update(['is_default' => true]);

        return redirect()->route('customer.addresses.index')
            ->with('success', __('store.addresses.default_address_set'));
    }
}
