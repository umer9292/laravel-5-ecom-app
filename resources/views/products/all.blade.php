@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    @include('layouts.partials.message')
    @include('layouts.partials.products')
@endsection
