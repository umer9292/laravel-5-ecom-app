<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Http\Requests\StoreProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return  view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return  view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct  $request)
    {
        try {
            if ($request->hasFile('thumbnail')){
                $fileName =  time().$request->thumbnail->getClientOriginalName();
                $path = $request->thumbnail->storeAs('storage/images', $fileName);
            }
            $newProduct = [
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'thumbnail' => $path,
                'featured' => ($request->featured) ? $request->featured : 0 ,
                'status' => $request->status,
                'price' => $request->price,
                'discount' => ($request->discount) ? $request->discount : 0,
                'discount_price' => ($request->discount_price) ? $request->discount_price : 0,
            ];

            $product = Product::create($newProduct);
            $product->categories()->attach($request->category_id);
            if  ( $product) {
                return back()->with('message', 'Product Added Successfully!');
            } else {
                return back()->with('error', 'Error Inserting Product');
            }
        } catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
