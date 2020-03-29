@extends('layouts.app')
@section('content')
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <img class="img-thumbnail" src="{{ asset('storage/'.$product->thumbnail ) }}">
                        </div>
                        <div class="col-md-8">
                            <h2 class="card-title font-weight-bolder"> {{ $product->title }} </h2>
                            <p class="card-text">
                                {!! $product->description !!}
                            </p>
                            <div class="d-block justify-content-between align-items-center">
                                <a href="button" class="btn btn-sm btn-outline-secondary">Add to Cart</a>
                                <p class="text-muted">9 mins</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
