<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\StoreOrder;
use App\Order;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Session::has('cart') || empty(Session::get('cart')->getContents())) {
            return redirect('products')->with('success', 'No Products in the Cart');
        }
        $cart = Session::get('cart');
        return view('products.checkout', compact('cart'));
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
    public function store(StoreOrder $request)
    {
//        dd($request->all());
        try{
            $cart = [];
            $order = [];
            if (Session::has('cart')) {
                $cart = Session::get('cart');
            }

            if ($request->shipping_address) {
                $customer = [
                    'billing_first_name' => $request->billing_first_name,
                    'billing_last_name' => $request->billing_last_name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'billing_address1' => $request->billing_address1,
                    'billing_address2' => $request->billing_address2,
                    'billing_country' => $request->billing_country,
                    'billing_state' => $request->billing_state,
                    'billing_zip' => $request->billing_zip,

                    'shipping_first_name' => $request->shipping_first_name,
                    'shipping_last_name' => $request->shipping_last_name,
                    'shipping_address1' => $request->shipping_address1,
                    'shipping_address2' => $request->shipping_address2,
                    'shipping_country' => $request->shipping_country,
                    'shipping_state' => $request->shipping_state,
                    'shipping_zip' => $request->shipping_zip,
                ];
            } else {
                $customer = [
                    'billing_first_name' => $request->billing_first_name,
                    'billing_last_name' => $request->billing_last_name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'billing_address1' => $request->billing_address1,
                    'billing_address2' => $request->billing_address2,
                    'billing_country' => $request->billing_country,
                    'billing_state' => $request->billing_state,
                    'billing_zip' => $request->billing_zip,
                ];
            }

            DB::beginTransaction();
            $checkout = Customer::create($customer);
            foreach ($cart->getContents as $slug => $product) {
                $products = [
                    'user_id' => $checkout->id,
                    'product_id' => $product['product']->id,
                    'qty' => $product['qty'],
                    'status' => 'pending',
                    'price' => $product['price'],
                    'payment_id' => 0,
                ];

                $order = Order::create($products);
            }

            if ($checkout && $order){
                DB::commit();
                return view('products.payments');
            } else {
                DB::rollBack();
                return redirect('checkout')->with('error', 'Invalid Activity');
            }
        } catch (\Exception $e){
            dd($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
