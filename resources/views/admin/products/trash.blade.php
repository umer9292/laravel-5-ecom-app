@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Products</a></li>
    <li class="breadcrumb-item active" aria-current="page">Trash Products</li>
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2">Trashed List</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.product.create') }}" class="btn btn-sm btn-outline-secondary">
                Add Product
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
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
                <th>Deleted At</th>
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
                            <img src="{{ asset('storage/'. $product->thumbnail) }}" class="img-responsive" alt="{{ $product->title }}" height="50">
                        </td>
                        <td>{{ $product->deleted_at }}</td>
                        <td>
                            <a href="{{ route('admin.product.recover', $product) }}" class="btn btn-sm btn-primary"> Restore </a>
                            |
                            <a href="javascript:;" onclick="confirmDelete('{{ $product->slug }}')" class="btn btn-sm btn-danger">
                                Delete
                            </a>

                            <form
                                id="delete-product-{{ $product->slug }}"
                                action="{{ route('admin.product.destroy', $product->slug) }}"
                                method="POST"
                                style="display: none;"
                            >
                                @method('DELETE')
                                @csrf
                            </form>
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
