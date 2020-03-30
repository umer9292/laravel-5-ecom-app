<div class="album py-3 bg-dark">
    <div class="container">
        <div class="row mb-4">
            <a href="{{ route('cart.all') }}" class="btn btn-outline-primary btn-sm ml-3">
                <i class="fas fa-shopping-cart"></i> My Cart
            </a>
        </div>
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top img-thumbnail" src="{{ asset('storage/'.$product->thumbnail ) }}"
                             alt="Card image cap" style="width: 100%; height: 250px">
                        <div class="card-body">
                            <h4 class="card-title"> {{ substr($product->title, 0, 15) }} </h4>
                            <p class="card-text">
                                {!! substr($product->description, 0, 20) !!}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="{{ route('products.single', $product) }}"
                                       data-toggle="tooltip" data-placement="top" title="View Product"
                                       class="btn btn-sm btn-outline-secondary tool-tip"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.addToCart', $product) }}"
                                       data-toggle="tooltip" data-placement="top" title="Add to Cart"
                                       class="btn btn-sm btn-outline-secondary tool-tip"
                                    >
                                        <i class="fas fa-cart-plus"></i>
                                    </a>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
