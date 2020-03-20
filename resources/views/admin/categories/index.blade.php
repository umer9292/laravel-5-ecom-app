@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2">Categories List</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.category.create') }}" class="btn btn-sm btn-outline-secondary">
                Add Category
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
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(count($categories) > 0)
                                @php $count = null  @endphp
                @foreach($categories as $category)
                                @php $count++  @endphp
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{!! $category->description !!}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            @if($category->subCategories()->count() > 0)
                                @foreach($category->subCategories as $subCategory)
                                    {{ $subCategory->title }},
                                @endforeach
                             @else
                                <strong>{{ 'Parent Category' }}</strong>
                            @endif
                        </td>
                        <td>{{ $category->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm btn-info"> Edit </a>
                            |
                            <a href="javascript:;" onclick="confirmDelete('{{ $category->id }}')" class="btn btn-sm btn-danger">
                                Delete
                            </a>

                            <form
                                id="delete-category-{{ $category->id }}"
                                action="{{ route('admin.category.destroy', $category->id) }}"
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
                    <td colspan="7">
                        <div class="alert alert-info" role="alert">
                            No Categories Found..
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $categories->links() }}.
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function confirmDelete(id) {
            let choice = confirm("Are You Sure, You want to Delete this record ?");
            if(choice) {
                document.getElementById('delete-category-'+id).submit();
            }
        }
    </script>
@endsection
