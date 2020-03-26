@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">Trash Categories</li>
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2">Trashed List</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.category.create') }}" class="btn btn-sm btn-outline-secondary">
                Add Category
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
                <th>S.No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Slug</th>
                <th>Categories</th>
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($categories) > 0)
                @foreach($categories as $category)
                    <tr>
                        <td> {{ $loop->iteration }} </td>
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
                        <td>{{ diff4Human($category->deleted_at) }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="example">
                                <a href="{{ route('admin.category.recover', $category) }}" class="btn btn-sm btn-primary mr-1">
                                    <i class="fas fa-trash-restore"></i>
                                    Recover
                                </a>
                                |
                                {!! Form::open(['route' =>  ['admin.category.destroy', $category], 'method' => 'POST']) !!}
                                    @csrf
                                    @method('DELETE')
                                    {{ Form::button('<i class="fas fa-trash-alt"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm ml-1']) }}
                                {!! Form::close() !!}
                            </div>
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
            {{ $categories->links() }}
        </div>
    </div>
@endsection

