<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
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

    public  function  getBrand(){
        return Brand::all();
    }

    public  function getCategory(){
        return Category::all();
    }

    public function  getProductByBrandAndCategory(Request $request){
        $this->validate($request,[
            'category_id'=>'required',
            'brand_id'=>'required'
        ]);

        return Product::where([['brand_id',$request->brand_id],['category_id',$request->category_id]])->get();
    }
}
