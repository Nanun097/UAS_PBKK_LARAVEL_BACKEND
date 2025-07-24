<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = Customers::all();
        return response()->json([
            'message' => 'Data customer berhasil diambil.',
            'data' => $customers
        ]);
    }

    public function show($id)
    {
        $customer = Customers::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer tidak ditemukan.'], 404);
        }
        return response()->json([
            'message' => 'Data customer ditemukan.',
            'data' => $customer
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:customers,email',
            'password' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:100',
        ]);

        $customer = Customers::create([
            'customer_id' => Str::ulid()->toBase32(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return response()->json([
            'message' => 'Data customer berhasil ditambahkan.',
            'data' => $customer
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $customer = Customers::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|email|max:50|unique:customers,email,' . $id . ',customer_id',
            'password' => 'sometimes|required|string|max:50',
            'phone' => 'sometimes|required|string|max:20',
            'address' => 'sometimes|required|string|max:100',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $customer->update($validated);

        return response()->json([
            'message' => 'Data customer berhasil diperbarui.',
            'data' => $customer
        ]);
    }

    public function destroy($id)
    {
        $customer = Customers::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer tidak ditemukan.'], 404);
        }

        $customer->delete();
        return response()->json(['message' => 'Data customer berhasil dihapus.']);
    }
}
