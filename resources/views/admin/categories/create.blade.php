@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Category</li>
@endsection
@section('content')
<div class="col-sm-12">
    @include('admin.partials.message')
</div>
<form action="{{ route('admin.category.store') }}" method="post" accept-charset="utf-8">
    @csrf
    <div class="form-group row">
        <div class="col-sm-12">
            <label for="textUrl" class="form-control-label">Title: </label>
            <input type="text" name="title" id="textUrl" class="form-control">
            <p class="small"> {{ config('app.url') }} <span id="url"></span></p>
            <input type="hidden" name="slug" id="slug" value="">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <label for="editor" class="form-control-label">Description: </label>
            <textarea name="description" id="editor" class="form-control" role="80" rows="80"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <label for="parent_id" class="form-control-label">Select Category: </label>
            <select name="parent_id[]" id="parent_id" class="form-control" multiple>
                @if($categories)
                    <option value="0">Top Level</option>
                    option
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"> {{ $category->title }} </option>
                    @endforeach
                @endif
                option
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <input type="submit" name="submit" class="btn btn-primary" value="Add Category">
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

            $('#textUrl').on('keyup', function () {
               var url = slugify($(this).val());
               $('#url').html(url);
               $('#slug').val(url);
            });

            $('#parent_id').select2({
                placeholder: "Select a Parent Category",
                allowClear : true,
                minimumResultsForSearch: Infinity
            });
        })
    </script>
@endsection
