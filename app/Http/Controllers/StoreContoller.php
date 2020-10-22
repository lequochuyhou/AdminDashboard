<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StoreContoller extends Controller
{
    //
    public  function index(){
        return view('storeWelcome');
    }

    public function getProduct()
    {
        return Product::all();
    }

    public  function getProductById(Request $request){
        return Product::where('id',$request->id)->get();
    }
}
