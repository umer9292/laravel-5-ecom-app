@extends('admin.app')
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profiles</li>
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2">Profiles List</h2>
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Slug</th>
                    <th>Role</th>
                    <th>Address</th>
                    <th>Thumbnail</th>
                    <th>Created At</th>
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
                        <td>{{ $profile->address }}</td>
                        <td>
                            <img
                            src="{{ asset('storage/'.$profile->thumbnail ) }}"
                            class="img-responsive"
                            alt="No Profile Image"
                            height="50" width="50"
                            >
                        </td>
                        <td>
                            {{ diff4Human($profile->created_at) }}
                            @if($profile->restore_at)
                                (Restore At {{ diff4Human($profile->restore_at) }})
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.profile.edit', $profile->slug) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="{{ route('admin.profile.remove', $profile) }}" class="btn btn-sm btn-outline-secondary mx-1">
                                    <i class="fas fa-trash"></i>
                                </a>

                                {!! Form::open(['route' =>  ['admin.profile.destroy', $profile], 'method' => 'POST']) !!}
                                    @method('DELETE')
                                    {{ Form::button('<i class="fas fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm']) }}
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9">
                        <div class="alert alert-info" role="alert">
                            No Profiles Found..
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
