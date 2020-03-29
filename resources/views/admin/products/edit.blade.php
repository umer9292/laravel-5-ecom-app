@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Products</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
@endsection
@section('content')
    <h2 class="modal-title">Edit Product</h2>
    <div class="row">
        <div class="col-sm-12">
            @include('admin.partials.message')
        </div>
    </div>
    <form action="{{ route('admin.product.update', $product->slug) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-9">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label for="textUrl" class="form-control-label">Title: </label>
                        <input type="text" name="title" id="textUrl" class="form-control" value="{{ @$product->title }}">
                        <p class="small"> {{ config('app.url') }} <span id="url">{{ @$product->slug }}</span></p>
                        <input type="hidden" name="slug" id="slug" value="{{ @$product->slug }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label for="editor" class="form-control-label">Description: </label>
                        <textarea name="description" id="editor" class="form-control">
                            {!! @$product->description !!}
                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="" class="form-control-label">Price: </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="price">PKR.</span>
                            </div>
                            <input type="text" class="form-control" name="price" placeholder="0.00" aria-label="price" aria-describedby="price" value="{{ @$product->price }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-control-label">Discount: </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="discount">PKR.</span>
                            </div>
                            <input type="text" class="form-control" name="discount_price" placeholder="0.00" aria-label="discount_price" aria-describedby="discount" value="{{ @$product->discount_price }}">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="card col-sm-12 p-0 mb-2">
                        <div class="card-header align-items-center">
                            <h5 class="card-title float-left">Extra Options</h5>
                            <div class="float-right">
                                <button type="button" id="btn-add" class="btn btn-primary btn-sm">+</button>
                                <button type="button" id="btn-remove" class="btn btn-danger btn-sm">-</button>
                            </div>
                        </div>
                        <div class="card-body" id="extras">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <ul class="list-group row">
                    <li class="list-group-item active"><h5>Status</h5></li>
                    <li class="list-group-item">
                        <div class="form-group row">
                            <select name="status" class="form-control" id="status">
                                <option value="1" @if($product->status == 0) {{ 'selected' }} @endif >
                                    Pending
                                </option>
                                <option value="2" @if($product->status == 1) {{ 'selected' }} @endif >
                                    Publish
                                </option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Update Product">
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item active"><h5>Featured Image</h5></li>
                    <li class="list-group-item">
                        <div class="input-group">
                            <div>
                                <input type="file" name="thumbnail" id="thumbnail" class="custom-file-input">
                                <label for="thumbnail" class="custom-file-label">Choose file</label>
                            </div>
                            <div class="img-thumbnail text-center mt-2">
                                <img src="@if(isset($product)) {{ asset('storage/'. $product->thumbnail) }} @else {{ asset('storage/images/no-thumbnail.jpeg') }} @endif" id="imgthumbnail" class="img-fluid" alt="">
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="col-12">
                            <div class="input-group">
                                <div class="form-check-inline">
                                    <input
                                        class="form-check-input" type="checkbox" name="featured"
                                        value="{{$product->featured}}"
                                        {{ $product->featured ? 'checked' :  '' }}
                                    >
                                    <label class="form-check-label ml-2" for="featured">
                                        Featured Product
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                    @php
                        $ids = (isset($product) && $product->categories->count() > 0) ? array_pluck($product->categories->toArray(), 'id') : null;
                    @endphp
                    <li class="list-group-item active"><h5>Select Category</h5></li>
                    <li class="list-group-item">
                        <select name="category_id[]" id="select2" class="form-control" multiple>
                            @if(count($categories) > 0)
                                @foreach($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        @if(!is_null($ids) && in_array($category->id, $ids))
                                            {{ 'selected' }}
                                        @endif
                                    >
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </li>
                </ul>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            ClassicEditor.create( document.querySelector( '#editor' ), {
                toolbar: [ 'Heading', 'Link', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ],
            }).then( editor => {
                console.log( editor );
            }).catch( error => {
                console.error( error );
            });

            $('#select2').select2({
                placeholder: "Select a Status",
                allowClear : true,
                minimumResultsForSearch: Infinity
            });

            $('#thumbnail').on('change', function () {
                var file = $(this).get(0).files;
                var reader = new FileReader();
                reader.readAsDataURL(file[0]);
                reader.addEventListener("load", function (e) {
                    var image = e.target.result;
                    $('#imgthumbnail').attr('src', image);
                })
            });

            $('#btn-add').on('click', function () {
                $.get("{{ route('admin.product.extras') }}").done(function (data) {
                    $('#extras').append(data);
                });
            });

            $('#btn-remove').on('click', function (e) {
                if ($('.options').length > 0) {
                    $('.options:last').remove();
                }
            });
        })
    </script>
@endsection
