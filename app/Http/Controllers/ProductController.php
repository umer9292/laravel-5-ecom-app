<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Category;
use App\Product;
use App\Http\Requests\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Nullable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('categories')
                            ->orderByDesc('id')
                            ->paginate(5);
        return  view('admin.products.index', compact('products'));
    }

    public function trash()
    {
        $products = Product::with('categories')
                            ->orderByDesc('id')
                            ->onlyTrashed()
                            ->paginate(5);
        return  view('admin.products.trash', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('subCategories')->get();
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
                $path = $request->thumbnail->storeAs('images', $fileName);
            }
            $newProduct = [
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'thumbnail' => $path,
                'featured' => $request->featured ? 1 : 0,
                'status' => $request->status,
                'options' =>  isset($request->extras) ? json_encode($request->extras) : Null,
                'price' => $request->price,
                'discount' => ($request->discount) ? $request->discount : 0,
                'discount_price' => ($request->discount_price) ? $request->discount_price : 0,
            ];

            $product = Product::create($newProduct);
            if  ( $product ) {
                $product->categories()->attach($request->category_id);
                return back()->with('success', 'Product Added Successfully!');
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
//        dd(Session::get('cart'));
        $categories = Category::with('subCategories')
                                ->get();
        $products = Product::with('categories')
                            ->orderByDesc('created_at')
                            ->paginate(9);
        return view('products.all', compact('categories', 'products'));
    }

    public function single(Product $product)
    {
        return view('products.single', compact('product'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null ;
        $qty = $request->qty ? $request->qty : 1 ;
        $cart = new  Cart($oldCart);
        $cart->addProduct($product, $qty);
        Session::put('cart', $cart);
        return back()->with('success', "Product $product->title has been successfully added to Cart");
    }

    public function cart()
    {
        if (!Session::has('cart')) {
            return view('products.cart');
        }

        $cart = Session::get('cart');
        return view('products.cart', compact('cart'));
    }

    public function removeProduct(Product $product)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null ;
        $cart = new  Cart($oldCart);
        $cart->removeProduct($product);
        Session::put('cart', $cart);
        return back()->with('success', "Product $product->title has been successfully remove from the Cart");
    }

    public function updateProduct(Request $request ,Product $product)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null ;
        $cart = new  Cart($oldCart);
        if ($request->qty > 0 )
            $cart->updateProduct($product, $request->qty);
        else
            $cart->removeProduct($product);
        Session::put('cart', $cart);
        return back()->with('success', "Product $product->title has been successfully Updated in the Cart");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::with('subCategories')->get();
        return  view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
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
        try {
            if ($request->hasFile('thumbnail')){
                $fileName =  time().$request->thumbnail->getClientOriginalName();
                $path = $request->thumbnail->storeAs('images', $fileName);
                $product->thumbnail = $path;
            }


            $product->title = $request->title;
//            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->featured =  $request->featured ? 1 : 0;
            $product->status = $request->status;
            $product->price = $request->price;
            $product->discount = ($request->discount) ? $request->discount : 0;
            $product->discount_price = ($request->discount_price) ? $request->discount_price : 0;

            $product->categories()->detach();
            if  ( $product->save() ) {
                $product->categories()->attach($request->category_id);
                return back()->with('success', 'Product Updated Successfully!');
            } else {
                return back()->with('error', 'Error Updating Product');
            }
        } catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    public function recoverProduct($slug)
    {
        $product = Product::withTrashed()->where(['slug' => $slug]);
        if ($product->restore()) {
            $product->update(['restore_at' => now()->toDateTimeString()]);
            return back()->with('success', 'Product Successfully Restored!');
        }
        else
            return back()->with('error', 'Error Restoring Product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->categories()->detach() && $product->forceDelete()) {
            Storage::delete($product->thumbnail);
            return back()->with('success', 'Product Deleted Successfully!');
        } else {
            return back()->with('error', 'Error Deleting Record!');
        }
    }

    public function remove(Product $product)
    {
        if ($product->delete()) {
            return back()->with('success', 'Product Trashed Successfully!');
        } else {
            return back()->with('error', 'Error Trashing Record!');
        }
    }
}
