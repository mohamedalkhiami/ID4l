<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\FileItemModel;

class ArrayAPI extends Controller
{

    public function item(Request $request)
    {



        $products = $request->input('products');



        // loop through all products
        foreach ($products as $product) {

            print_r($product['product_id']);
            echo $product['product_amount'];
        }





        // return [
        //     'id' => $request->id,
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'created_at' => $request->created_at,
        //     'updated_at' => $request->updated_at,
        //     'link' => $data



        // ];
    }
}
