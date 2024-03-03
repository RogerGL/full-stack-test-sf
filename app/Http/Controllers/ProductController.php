<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price_unit' => 'required|numeric',
            'category' => 'required',
            'supplier' => 'required',
            'quantity_stock' => 'required|integer',
        ]);
    
        $product = new Product;
        $product->code = $request->code;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price_unit = $request->price_unit;
        $product->category = $request->category;
        $product->supplier = $request->supplier;
        $product->quantity_stock = $request->quantity_stock;
        $product->save();
    
        return response()->json(['message' => 'Produto criado com sucesso.', 'product' => $product], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
    
        $product->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json(['message' => 'Produto excluído com sucesso.']);
    }
}
