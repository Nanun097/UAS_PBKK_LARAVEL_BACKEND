<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $items = OrderItem::with(['order', 'product'])->get();

        return response()->json([
            'message' => 'Data order item berhasil diambil.',
            'data' => $items
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'product_id' => 'required|exists:product,product_id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
        ]);

        $item = OrderItem::create($validated);

        return response()->json([
            'message' => 'Order item berhasil ditambahkan.',
            'data' => $item
        ], 201);
    }

    public function show($id)
    {
        $item = OrderItem::with(['order', 'product'])->find($id);

        if (!$item) {
            return response()->json(['message' => 'Order item tidak ditemukan.'], 404);
        }

        return response()->json([
            'message' => 'Order item ditemukan.',
            'data' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = OrderItem::find($id);
        if (!$item) {
            return response()->json(['message' => 'Order item tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'order_id' => 'sometimes|exists:orders,order_id',
            'product_id' => 'sometimes|exists:product,product_id',
            'quantity' => 'sometimes|integer|min:1',
            'price' => 'sometimes|integer|min:0',
        ]);

        $item->update($validated);

        return response()->json([
            'message' => 'Order item berhasil diperbarui.',
            'data' => $item
        ]);
    }

    public function destroy($id)
    {
        $item = OrderItem::find($id);
        if (!$item) {
            return response()->json(['message' => 'Order item tidak ditemukan.'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Order item berhasil dihapus.']);
    }
}
