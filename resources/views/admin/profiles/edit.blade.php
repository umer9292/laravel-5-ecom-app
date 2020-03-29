@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.profile.index') }}">Profiles</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
@endsection
@section('content')
    <h2 class="modal-title">Edit Profile</h2>
    <div class="row">
        <div class="col-sm-12">
            @include('admin.partials.message')
        </div>
    </div>
    <form action="{{ route('admin.profile.update', $profile) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <div class="row">
            @csrf
            @method('PUT')
            <div class="col-lg-9">
                <div class="form-group row">
                    <div class="col-sm-12 col-md-6">
                        <label for="name" class="form-control-label">Name: </label>
                        <input type="text" name="name" id="textUrl" class="form-control" value="{{ @$profile->name }}">
                        <p class="small"> {{ config('app.url') }} <span id="url">{{ @$profile->slug }}</span></p>
                        <input type="hidden" name="slug" id="slug" value="{{ @$profile->slug }}">
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="" class="form-control-label">Phone: </label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ @$profile->phone }}">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="" class="form-control-label">Status: </label>
                        <div class="input-group mb-3">
                            <select name="status" id="status" class="form-control">
                                <option value="" selected>Select Status</option>
                                <option value="0" @if(isset($profile) && $profile->user->status == 0) {{'selected'}} @endif>Blocked</option>
                                <option value="1" @if(isset($profile) && $profile->user->status == 1) {{'selected'}} @endif>Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="" class="form-control-label">Select Role: </label>
                        <div class="input-group mb-3">
                            <select name="role" class="form-control">
                                <option value="0">Select Role</option>
                                @if($roles->count() > 0)
                                    @foreach($roles as $role)
                                        <option
                                            value="{{ $role->id }}"
                                            {{$profile->getUserRoles() === $role->id ? 'selected' :  ''}}
                                        >
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-4">
                        <label for="" class="form-control-label">Country: </label>
                        <div class="input-group mb-3">
                            <select name="country_id" class="form-control" id="countries">
                                <option selected hidden >{{ $profile->country->name }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"> {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label for="" class="form-control-label">State: </label>
                        <div class="input-group mb-3">
                            <select name="state_id" class="form-control" id="states">
                                <option selected hidden>{{ $profile->state->name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <label for="" class="form-control-label">City: </label>
                        <div class="input-group mb-3">
                            <select name="city_id" class="form-control" id="cities">
                                <option selected hidden>{{ $profile->city->name }}</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-3">
                <ul class="list-group row">
                    <li class="list-group-item active"><h5>Profile Image</h5></li>
                    <li class="list-group-item">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" name="thumbnail" id="thumbnail" class="custom-file-input">
                                <label for="thumbnail" class="custom-file-label">Choose file</label>
                            </div>
                        </div>
                        <div class="img-thumbnail text-center mt-2">
                            <img
                                src="{{asset( $profile->thumbnail ?
                                'storage/'. $profile->thumbnail :
                                'storage/images/profile/no-thumbnail.jpeg')}}"
                                id="show-thumbnail" class="img-fluid" alt="" height="100" width="150"
                            >
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Update Profile">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"> </script>
@endsection
