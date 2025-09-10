<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class uiApiController extends Controller
{
    function get(){
        $file=storage_path('app/products.json');
        $data=json_decode(file_get_contents($file));
        return response()->json($data);
    }

    function post( Request $request){
          $validated = $request->validate([
        'id'          => 'required|numeric',
        'name'        => 'required|string|max:100',
        'description' => 'nullable|string|max:255',
        'price'       => 'required',
        'quantity'    => 'required',
    ]);
         $file=storage_path('app/products.json');
        $data=json_decode(file_get_contents($file));
        $data[] =$validated;
        file_put_contents($file,json_encode($data));
       return response()->json(['success' => true]);
    }

    function put(Request $request ,$id){
 $file =storage_path('app/products.json');
 $products = json_decode(file_get_contents($file), true) ?: [];
 foreach ($products as &$p) {
        if ($p['id'] == $id) {
            $p = array_merge($p, $request->all());
            file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT));
            return response()->json(['success'=>true]);
        }
    }
    }

function delete($id){
 $file = storage_path('app/products.json');
    $products = json_decode(file_get_contents($file), true) ?: [];
    foreach ($products as $index => $product) {
        if ($product['id'] == $id) {
            array_splice($products, $index, 1); 
            file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT));

            return ["result"=>"Product deleted"];
        }
    }
    return response()->json("Product not found", 404);

}}
