<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::with('product')->get();

        return response()->json([
            'message' => 'Data categories berhasil diambil.',
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:product,product_id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Categories::create($validated);

        return response()->json([
            'message' => 'Data categories berhasil ditambahkan.',
            'data' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Categories::with('product')->find($id);

        if (!$category) {
            return response()->json(['message' => 'Categories tidak ditemukan.'], 404);
        }

        return response()->json([
            'message' => 'Data categories ditemukan.',
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Categories::find($id);
        if (!$category) {
            return response()->json(['message' => 'Categories tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'product_id' => 'sometimes|exists:product,product_id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Data categories berhasil diperbarui.',
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Categories::find($id);
        if (!$category) {
            return response()->json(['message' => 'Categories tidak ditemukan.'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Data categories berhasil dihapus.']);
    }
}
