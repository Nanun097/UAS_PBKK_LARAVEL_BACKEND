<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $order = Orders::with(['customer'])->get();

        return response()->json([
            'message' => 'Daftar order.',
            'data' => $order
        ]);
    }

    public function show($id)
    {
        $order = Orders::with(['customer'])->findOrFail($id);

        return response()->json([
            'message' => 'Detail order.',
            'data' => $order
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|string|exists:customers,customer_id',
            'order_date' => 'nullable|date',
            'total_amount' => 'nullable|integer',
            'status' => 'nullable|string',
        ]);

        $order = Orders::create([
            'order_id' => Str::ulid()->toBase32(), 
            'customer_id' => $validated['customer_id'],
            'order_date' => $validated['order_date'],
            'total_amount' => $validated['total_amount'],
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' => 'Orders berhasil ditambahkan.',
            'data' => $order
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $order = Orders::findOrFail($id);

        $validated = $request->validate([
            'customer_id' => 'sometimes|required|string',
            'order_date' => 'sometimes|required|string',
            'total_amount' => 'sometimes|required|string',
            'status' => 'sometimes|required|string',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Orders berhasil diupdate.',
            'data' => $order
        ]);
    }
    
    public function destroy($id)
    {
        $order = Orders::find($id);
        if (!$order) {
            return response()->json(['message' => 'order tidak ditemukan.'], 404);
        }
        $order->delete();

        return response()->json(['message' => 'Data order berhasil dihapus.']);
    }

}
