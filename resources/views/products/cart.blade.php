@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between mb-3 mt-2">
    <h2>Shopping Cart Page</h2>
        <a href="{{ route('products.all') }}" class="btn btn-outline-secondary">
            <i class="fas fa-backward"></i> Go Back
        </a>
    </div>
    @if(isset($cart) && $cart->getContents())
        <div class="card table-responsive">
            <table class="table table-hover shopping-cart-wrap">
                <thead class="text-muted">
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col" width="120">Quantity</th>
                    <th scope="col" width="120">Price</th>
                    <th scope="col" width="200" class="text-right">Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($cart->getContents() as $slug => $product)
                    <tr>
                        <td>
                            <figure class="media">
                                <div class="img-wrap">
                                    <img src="{{asset('storage/'.$product['product']->thumbnail)}}"
                                         style="width: 90px; height: 115px"
                                         class="img-thumbnail img-sm">
                                </div>
                                <figcaption class="media-body ml-2">
                                    <h6 class="title text-truncate">{{$product['product']->title}}</h6>
                                    <dl class="param param-inline small">
                                        <dt>Size: </dt>
                                        <dd>XXL</dd>
                                    </dl>
                                    <dl class="param param-inline small">
                                        <dt>Color: </dt>
                                        <dd>Orange color</dd>
                                    </dl>
                                </figcaption>
                            </figure>
                        </td>
                        <td>
                            <form method="POST" action="{{route('cart.update', $slug)}}" >
                                @csrf
                                <input type="number" name="qty" id="qty" class="form-control text-center" min="0" max="99" value="{{$product['qty']}}">
                                <input type="submit" name="update" value="Update" class="btn btn-block btn-outline-success btn-round">
                            </form>
                        </td>
                        <td>
                            <div class="price-wrap">
                                <span class="price">USD {{$product['price']}}</span>
                                <small class="text-muted">(USD{{$product['product']->price}} each)</small>
                            </div> <!-- price-wrap .// -->
                        </td>
                        <td class="text-right">
                            <form action="{{route('cart.remove', $slug)}}" method="POST" accept-charset="utf-8">
                                @csrf
                                <input type="submit" name="remove" value="x Remove" class="btn btn-outline-danger"/>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2">Total Qty: </th>
                    <td>{{$cart->getTotalQty()}}</td>
                </tr>
                <tr>
                    <th colspan="2">Total Price: </th>
                    <td>{{$cart->getTotalPrice()}}.00</td>
                </tr>
                </tbody>
            </table>
        </div> <!-- card.// -->
    @else
        <p class="alert alert-danger">
            No Products in the Cart
            <a href="{{route('products.all')}}">
                Buy Some Products
            </a>
        </p>
    @endif
@endsection
