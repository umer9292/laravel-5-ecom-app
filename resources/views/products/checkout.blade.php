@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">{{ $cart->getTotalQty() }}</span>
            </h4>
            <ul class="list-group mb-3">
                @foreach($cart->getContents() as $slug => $product)
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">{{ $product['product']->title }}</h6>
                            <small class="text-muted">Quantity:{{ $product['qty'] }}</small>
                        </div>
                        <span class="text-muted font-weight-bold">${{ $product['price'] }}</span>
                    </li>
                @endforeach
{{--                <li class="list-group-item d-flex justify-content-between bg-light">--}}
{{--                    <div class="text-success">--}}
{{--                        <h6 class="my-0">Promo code</h6>--}}
{{--                        <small>EXAMPLECODE</small>--}}
{{--                    </div>--}}
{{--                    <span class="text-success">-$5</span>--}}
{{--                </li>--}}
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>${{ $cart->getTotalPrice() }}</strong>
                </li>
            </ul>

{{--            <form class="card p-2">--}}
{{--                <div class="input-group">--}}
{{--                    <input type="text" class="form-control" placeholder="Promo code">--}}
{{--                    <div class="input-group-append">--}}
{{--                        <button type="submit" class="btn btn-secondary">Redeem</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}

        </div>

        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            @include('layouts.partials.message')
            <form class="needs-validation" action="{{ route('checkout.store') }}" method="post" novalidate="">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" name="billing_first_name" class="form-control" id="firstName" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" name="billing_last_name" class="form-control" id="lastName" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                            Valid last name is required.
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Username" required="">
                        <div class="invalid-feedback" style="width: 100%;">
                            Your username is required.
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email">Email <span class="text-muted">(Optional)</span></label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
                    <div class="invalid-feedback">
                        Please enter a valid email address for shipping updates.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" name="billing_address1" class="form-control" id="address" placeholder="1234 Main St" required="">
                    <div class="invalid-feedback">
                        Please enter your shipping address.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                    <input type="text" name="billing_address2" class="form-control" id="address2" placeholder="Apartment or suite">
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">Country</label>
                        <select name="billing_country" class="custom-select d-block w-100" id="country" required="">
                            <option value="">Choose...</option>
                            <option>United States</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">State</label>
                        <select name="billing_state" class="custom-select d-block w-100" id="state" required="">
                            <option value="">Choose...</option>
                            <option>California</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip">Zip</label>
                        <input type="text" name="billing_zip" class="form-control" id="zip" placeholder="" required="">
                        <div class="invalid-feedback">
                            Zip code required.
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="shipping_address" class="custom-control-input" id="same-address">
                    <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info">
                    <label class="custom-control-label" for="save-info">Checkout as Guest</label>
                </div>

                <div class="col-md-12 order-md-1" id="shipping-address">
                    <hr class="mb-4">
                    <h4 class="mb-3">Shipping Address</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">First name</label>
                            <input type="text" name="shipping_first_name" class="form-control" id="firstName" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Last name</label>
                            <input type="text" name="shipping_last_name" class="form-control" id="lastName" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" name="shipping_address1" class="form-control" id="address" placeholder="1234 Main St" required="">
                    </div>

                    <div class="mb-3">
                        <label for="address2">Address Line 2 <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="shipping_address2" class="form-control" id="address2" placeholder="Apartment or suite">
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="country">Country</label>
                            <select name="shipping_country" class="custom-select d-block w-100" id="country" required="">
                                <option value="">Choose...</option>
                                <option>United States</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="state">State</label>
                            <select name="shipping_state" class="custom-select d-block w-100" id="state" required="">
                                <option value="">Choose...</option>
                                <option>California</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="zip">Zip</label>
                            <input type="text" name="shipping_zip" class="form-control" id="zip" placeholder="" required="">
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Continue to checkout</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#same-address').on('change', function () {
                $('#shipping-address').slideToggle(!this.checked)
            })
        })
    </script>
@endsection
