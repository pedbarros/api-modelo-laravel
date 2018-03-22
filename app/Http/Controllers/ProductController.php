<?php

namespace App\Http\Controllers;

use Validator;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    // SELECT * FROM ALL
    public function index()
    {
        return Product::all();
    }

    // SELECT * FROM ALL WHERE ID = :PARAMS
    public function show($id)
    {
        return new ProductResource(Product::find($id));
    }

    // INSERT
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Os campos não foram validados'], 401);
        }

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    // UPDATE
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'price' => 'integer',
            'category_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Os campos não foram validados'], 401);
        }

        $product->update($request->all());

        return response()->json($product, 200);
    }

    // DELETE
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
