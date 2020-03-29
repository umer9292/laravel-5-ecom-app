@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Products</li>
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2">Products List</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.product.create') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-plus"></i>
                Add Product
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @include('admin.partials.message')
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Slug</th>
                <th>Categories</th>
                <th>Price</th>
                <th>Thumbnail</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($products) > 0)
                @php $count = null  @endphp
                @foreach($products as $product)
                    @php $count++  @endphp
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{!! $product->description !!}</td>
                        <td>{{ $product->slug }}</td>
                        <td>
                            @if($product->categories()->count() > 0)
                                @foreach($product->categories as $children)
                                    {{ $children->title }}
                                @endforeach
                            @else
                                <strong>{{ "Product" }}</strong>
                            @endif
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <img src="{{ asset('storage/'. $product->thumbnail) }}" class="img-responsive" alt="{{ $product->title }}" width="70" height="50">
                        </td>
                        <td>
                            {{ diff4Human( $product->created_at ) }}
                            @if($product->restore_at)  (Restore: {{ diff4Human($product->restore_at) }}) @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a
                                    href="{{ route('admin.product.edit', $product) }}"
                                    class="btn btn-sm btn-success tool-tip"
                                    data-toggle="tooltip" data-placement="top" title="Edit Product"
                                >
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                </a>

                                <a href="{{ route('admin.product.remove', $product) }}"
                                   class="btn btn-sm btn-secondary mx-1 tool-tip"
                                    data-toggle="tooltip" data-placement="top" title="Trash Product">
                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                </a>

                                {!! Form::open(['route' =>  ['admin.product.destroy', $product], 'method' => 'POST']) !!}
                                    @method('DELETE')
                                    {{ Form::button('<i class="fas fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm']) }}
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9">
                        <div class="alert alert-info" role="alert">
                            No Products Found..
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $products->links() }}.
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('.tool-tip').tooltip();
    </script>
@endsection
