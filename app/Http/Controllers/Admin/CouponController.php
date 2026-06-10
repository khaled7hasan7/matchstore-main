<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code',
            'discount' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed',
            'expires_at' => 'nullable|date|after:today',
        ]);

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', __('cms.coupons.success_create'));
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,' . $id,
            'discount' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed',
            'expires_at' => 'nullable|date|after:today',
        ]);

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')
            ->with('success', __('cms.coupons.success_update'));
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', __('cms.coupons.success_delete'));
    }
}
