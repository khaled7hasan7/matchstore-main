<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    public function getData(Request $request)
    {
        $query = Order::query()->latest()->with('customer');

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('customer', function (Order $order) {
                if ($order->customer) {
                    return $order->customer->name.' ('.$order->customer->email.')';
                }

                return $order->guest_email ?? 'Guest';
            })
            ->addColumn('order_date', function (Order $order) {
                return $order->created_at?->format('Y-m-d H:i');
            })
            ->addColumn('total_price', function (Order $order) {
                return order_amount($order->total);
            })
            ->editColumn('status', function (Order $order) {
                $statusColors = [
                    'pending' => 'warning',
                    'completed' => 'success',
                    'canceled' => 'danger',
                    'processing' => 'info',
                ];
                $color = $statusColors[$order->status] ?? 'secondary';
                return '<span class="badge bg-'.$color.'">'.ucfirst($order->status).'</span>';
            })
            ->addColumn('action', function (Order $order) {
                return '
                    <a href="'.route('admin.orders.show', $order->id).'" class="border border-primary dt-view rounded-3 d-inline-block me-2" title="View Details">
                        <i class="bi bi-eye-fill text-primary"></i>
                    </a>
                    <span class="border border-danger dt-trash rounded-3 d-inline-block" onclick="deleteOrder('.$order->id.')" title="Delete">
                        <i class="bi bi-trash-fill text-danger"></i>
                    </span>
                ';
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id')
            ->make(true);
    }

    public function show($id)
    {
        $order = Order::with(['details.product.translations', 'customer'])
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        // "canceled" (one l) matches the orders.status enum in the database
        $request->validate([
            'status' => 'required|in:pending,processing,completed,canceled',
        ]);

        $order = Order::with('details')->findOrFail($id);

        DB::transaction(function () use ($order, $request) {
            // Return reserved stock when an order is canceled (once)
            if ($request->status === 'canceled' && $order->status !== 'canceled') {
                foreach ($order->details as $detail) {
                    if ($detail->variant_id) {
                        ProductVariant::whereKey($detail->variant_id)
                            ->lockForUpdate()
                            ->increment('stock', $detail->quantity);
                    }
                }
            }

            $order->status = $request->status;
            $order->save();
        });

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['success' => true, 'message' => __('cms.orders.deleted_success')]);
    }
}
