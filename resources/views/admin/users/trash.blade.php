@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.profile.index') }}">Profiles</a></li>
    <li class="breadcrumb-item active" aria-current="page">Trashed Profiles</li>
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2">Trashed Profiles List</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.profile.create') }}" class="btn btn-sm btn-outline-secondary">
                Add User
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
                <th>Name</th>
                <th>Email</th>
                <th>Slug</th>
                <th>Role</th>
                <th>Address</th>
                <th>Thumbnail</th>
                <th>Trashed At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($profiles) && $profiles->count() > 0)
                @foreach($profiles as $profile)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $profile->name }}</td>
                        <td>{{ $profile->user->email }}</td>
                        <td>{{ $profile->slug }}</td>
                        <td>{{ $profile->user->role->name }}</td>
                        <td>{{ $profile->name }}</td>
                        <td>
                            <img src="{{ asset('storage/'.$profile->thumbnail ) }}" class="img-responsive" alt="No Profile Image" height="50" width="50">
                        </td>
                        <td>{{\Carbon\Carbon::parse($profile->deleted_at)->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.profile.recover', $profile->slug) }}" class="btn btn-sm btn-primary"> Recover </a>
                            |
                            <a href="javascript:;" onclick="confirmDelete('{{ $profile->slug }}')" class="btn btn-sm btn-danger">
                                Delete
                            </a>

                            <form
                                id="delete-product-{{ $profile->slug }}"
                                action="{{ route('admin.profile.destroy', $profile->slug) }}"
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
                            No Trashed Profiles Found..
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $profiles->links() }}.
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function confirmDelete(id) {
            let choice = confirm("Are You Sure, You want to Delete this User ?");
            if(choice) {
                document.getElementById('delete-profile-'+id).submit();
            }
        }
    </script>
@endsection
