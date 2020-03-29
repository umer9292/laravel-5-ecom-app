@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Categories</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
@endsection
@section('content')
    <div class="col-sm-12">
        @include('admin.partials.message')
    </div>
    <form action="{{ route('admin.category.update', $category->slug) }}" method="post" accept-charset="utf-8">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <div class="col-sm-12">
                <label for="textUrl" class="form-control-label">Title: </label>
                <input type="text" name="title" id="textUrl" class="form-control" value="{{ @$category->title }}">
                <p class="small"> {{ config('app.url') }} <span id="url">{{ @$category->slug }}</span></p>
                <input type="hidden" name="slug" id="slug" value="{{ @$category->slug }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label for="editor" class="form-control-label">Description: </label>
                <textarea name="description" id="editor" class="form-control" role="80" rows="80">
                    {!! @$category->description !!}
                </textarea>
            </div>
        </div>
        <div class="form-group row">
            @php
                $ids = (isset($category->subCategories) && $category->subCategories->count() > 0) ? array_pluck($category->subCategories, 'id') : null;
            @endphp
            <div class="col-sm-12">
                <label for="parent_id" class="form-control-label">Select Category: </label>
                <select name="parent_id[]" id="parent_id" class="form-control" multiple>
                    @if(isset($categories))
                        <option value="0">Top Level</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @if(!is_null($ids) && in_array($cat->id, $ids)) {{ 'selected' }} @endif>
                                {{ $cat->title }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <input type="submit" name="submit" class="btn btn-primary" value="Update">
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

            $('#parent_id').select2({
                placeholder: "Select a Parent Category",
                allowClear : true,
                minimumResultsForSearch: Infinity
            });
        })
    </script>
@endsection
