<?php

namespace App\Http\Controllers;
use App\Models\master_barang;
use Illuminate\Http\Request;

class ProductController extends Controller {


public function findProductId(Request $request){
	
    //it will get price if its id match with product id
    $data=master_barang::firstWhere('id', $request->id);
    
    return response()->json($data);
}
}