@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.profile.index') }}">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add User</li>
@endsection
@section('content')
    <h2 class="modal-title">Add User</h2>
    @include('admin.partials.message')
    <form action="{{ route('admin.profile.store') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <div class="row">
            @csrf
            <div class="col-lg-9">
                <div class="form-group row">
                    <div class="col-sm-12 col-md-6">
                        <label for="name" class="form-control-label">Name: </label>
                        <input type="text" name="name" id="textUrl" class="form-control">
                        <p class="small"> {{ config('app.url') }} <span id="url"></span></p>
                        <input type="hidden" name="slug" id="slug" value="">
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="email" class="form-control-label">Email: </label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-6">
                        <label for="password" class="form-control-label">Password: </label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="passwordConfirm" class="form-control-label">Re-Type Password: </label>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-6">
                        <label for="" class="form-control-label">Status: </label>
                        <div class="input-group mb-3">
                            <select name="status" id="status" class="form-control">
                                <option value="" selected>Select Status</option>
                                <option value="0" >Blocked</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="" class="form-control-label">Select Role: </label>
                        <div class="input-group mb-3">
                            <select name="role" class="form-control">
                                <option value="0">Select Role</option>
                                @if($roles->count() > 0)
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 col-md-3">
                        <label for="" class="form-control-label">Country: </label>
                        <div class="input-group mb-3">
                            <select name="country_id" class="form-control" id="countries">
                                <option selected hidden>Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"> {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label for="" class="form-control-label">State: </label>
                        <div class="input-group mb-3">
                            <select name="state_id" class="form-control" id="states">
                                <option selected hidden>Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label for="" class="form-control-label">City: </label>
                        <div class="input-group mb-3">
                            <select name="city_id" class="form-control" id="cities">
                                <option selected hidden>Select City</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label for="" class="form-control-label">Phone: </label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="phone" placeholder="Phone" value="">
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
                                src="@if(isset($users))
                                        {{ asset('storage/profile/'. $users->profile->thumbnail) }}
                                    @else
                                        {{ asset('storage/images/profile/no-thumbnail.jpeg') }}
                                    @endif"
                                id="imgthumbnail" class="img-fluid" alt="" height="100" width="150"
                            >
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Add User">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            const  stateSelector = $('#states');
            const  countrySelector =  $('#countries');
            const  citySelector =  $('#cities');

            $('.role').select2();
            countrySelector.select2();
            citySelector.select2();
            stateSelector.select2();

            $('#textUrl').on('keyup', function () {
               var pretty_url = slugify($(this).val());
               $('#url').html(slugify(pretty_url));
               $('#slug').val(pretty_url);
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

            // On Country Change
            countrySelector.on('change', function () {
                const  id = $(this).select2('data')[0].id;
                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.profile.states') }}/" + id
                }).then(function (data) {
                    let options = '<option selected hidden>Select State</option>';
                    for (i=0; i<data.length; i++) {
                        const { name, id } =  data[i];
                        options += `<option value="${id}" >${name}</option>`;
                    }
                    stateSelector.html(options)
                });
            });

            // On State Change
            stateSelector.on('change', function () {
                const  id = $(this).select2('data')[0].id;
                $.ajax({
                    type: 'GET',
                    url: "{{ route('admin.profile.cities') }}/" + id
                }).then(function (data) {
                    let options = '<option selected hidden>Select City</option>';
                    for (i=0; i<data.length; i++) {
                        const { name, id } =  data[i];
                        options += `<option value="${id}" >${name}</option>`;
                    }
                    citySelector.html(options)
                });
            });
        })
    </script>
@endsection
