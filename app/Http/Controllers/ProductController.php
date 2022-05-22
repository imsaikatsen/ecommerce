<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return response()->json(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
            'name' => 'required',
            'description' => 'required',
            'brand' => 'required',
            'image' => 'required',
            'weight' => 'required',
            'color' => 'required',
        );
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()) {
            return $validator->errors();
        }else{
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('upload/product_images');
            $image->move($destinationPath, $input['imagename']);


            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->brand = $request->brand;
            $product->image = $input['imagename'];
            $product->weight = $request->weight;
            $product->color = $request->color;
            $product->save();
            return response()->json(['message'=> 'Product Stored','product'=> $product]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json(['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $product = Product::find($id);
        $product->name=$request->name;
        $product->brand=$request->brand;
        $product->weight=$request->weight;
        $product->color=$request->color;
        $product->save();

        return response()->json(['message'=> 'Product Updated','product'=> $product]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json(['message'=> 'Product Deleted','product'=> $product]);
    }
}
