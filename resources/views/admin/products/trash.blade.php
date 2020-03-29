@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Products</a></li>
    <li class="breadcrumb-item active" aria-current="page">Trash Products</li>
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2">Trashed List</h2>
        <h4>Total Trashed: {{ count($products) }}</h4>
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
                <th>S.No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Slug</th>
                <th>Categories</th>
                <th>Price</th>
                <th>Thumbnail</th>
                <th>Trashed At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($products) > 0)
                @foreach($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
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
                            <img src="{{ asset('storage/'. $product->thumbnail) }}" class="img-responsive" alt="{{ $product->title }}" height="50">
                        </td>
                        <td>{{ diff4Human($product->deleted_at) }}</td>
                        <td>
                            <a
                                href="{{ route('admin.product.recover', $product) }}"
                               class="btn btn-sm btn-outline-primary"
                            >
                                <i class="fas fa-trash-restore-alt"></i>
                                Restore
                            </a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9">
                        <div class="alert alert-info" role="alert">
                            No Trashed Products Found..
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
        function confirmDelete(id) {
            let choice = confirm("Are You Sure, You want to Delete this record ?");
            if(choice) {
                document.getElementById('delete-product-'+id).submit();
            }
        }
    </script>
@endsection
