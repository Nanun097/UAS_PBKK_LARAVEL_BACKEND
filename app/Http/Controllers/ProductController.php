<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $produk = Product::all();
        return response()->json([
            'message' => 'Data product berhasil diambil.',
            'data' => $produk
        ]);
    }

    public function show($id)
    {
        $produk = Product::find($id);
        if (!$produk) {
            return response()->json(['message' => 'product tidak ditemukan.'], 404);
        }
        return response()->json([
            'message' => 'Data product ditemukan.',
            'data' => $produk
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required|string'
        ]);

        $order = Product::create([
            'product_id' => Str::ulid()->toBase32(),
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
        ]);

        return response()->json([
            'message' => 'Data product berhasil ditambahkan.',
            'data' => $order
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $produk = Product::find($id);
        if (!$produk) {
            return response()->json(['message' => 'product tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|integer',
            'stock' => 'sometimes|required|integer',
            'category_id' => 'sometimes|required|string'
        ]);

        $produk->update($validated);

        return response()->json([
            'message' => 'Data product berhasil diperbarui.',
            'data' => $produk
        ]);
    }

    public function destroy($id)
    {
        $produk = Product::find($id);
        if (!$produk) {
            return response()->json(['message' => 'product tidak ditemukan.'], 404);
        }
        $produk->delete();

        return response()->json(['message' => 'Data product berhasil dihapus.']);
    }
}

