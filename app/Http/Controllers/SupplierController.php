<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Supplier::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required',
            'address' => 'required|array',
        ]);
    
        $supplier = new Supplier;
        $supplier->name = $request->name;
        $supplier->contact_email = $request->contact_email;
        $supplier->contact_phone = $request->contact_phone;
        $supplier->address = json_encode($request->address, JSON_UNESCAPED_UNICODE);
        $supplier->save();
    
        return response()->json([
            'message' => 'Supplier created successfully',
            'supplier' => $supplier
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::find($id);

        if ($supplier) {
            return response()->json($supplier);
        } else {
            return response()->json(['error' => 'Supplier not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Fornecedor não encontrado'], 404);
        }
    
        $supplier->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Supplier::find($id);
        $product->delete();

        return response()->json(['message' => 'Produto excluído com sucesso.']);
    }
}
