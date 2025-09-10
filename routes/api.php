<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/products', function (Request $request) {
    $file = storage_path('app/products.json');
    $products = json_decode(file_get_contents($file), true) ?: [];

    $products[] = $request->only(['id','name','description','price','quantity']);

    file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT));
    return response()->json(['success' => true]);
});

// GET /products/{id} → get product by ID
Route::get('/products/{id}', function ($id) {
    $file = storage_path('app/products.json');
    $products = json_decode(file_get_contents($file), true) ?: [];

    foreach ($products as $product) {
        if ($product['id'] == $id) return response()->json($product);
    }
    return response()->json(['error' => 'Product not found'], 404);
});

// GET /products/ → get all product 

Route::get('products',function(){
    $file= storage_path('app/products.json');
    $products= json_decode(file_get_contents($file),true);
    return response()->json($products);
});


// PUT /products/{id} → update product
Route::put('/products/{id}', function (Request $request, $id) {
    $file = storage_path('app/products.json');
    $products = json_decode(file_get_contents($file), true) ?: [];

    foreach ($products as &$p) {
        if ($p['id'] == $id) {
            $p = array_merge($p, $request->all());
            file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT));
            return response()->json(['success'=>true]);
        }
    }

    return response()->json(['error'=>'Product not found'], 404);
});

