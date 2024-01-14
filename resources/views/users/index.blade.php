@extends('layouts.app', [
'class' => '',
'elementActive' => 'user'
])

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8 user-font">
                            <h3 class="mb-0">{{ __('Users') }}</h3>
                        </div>
                        <div class="col-4 text-right add-user">
                            <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary" id="add-user">{{
                                __('Add user') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="col-12">
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table id="tblUser" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Role') }}</th>
                                    <th hidden scope="col">{{ __('Image ID') }}</th>
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->count())
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                    </td>
                                    <td>{{ $user->role_name ? $user->role_name : '' }}</td>
                                    <td hidden><img src="{{file_exists(public_path('profile_photo/' . $user->profile_photo)) ? public_path('profile_photo/' . $user->profile_photo) : 'https://media.istockphoto.com/id/1337144146/vector/default-avatar-profile-icon-vector.jpg?s=612x612&w=0&k=20&c=BIbFwuv7FxTWvh5S3vB6bkT0Qv8Vn8N5Ffseq84ClGI='}}" style="width:50px; height:50px; border-radius: 50%;" /></td>
                                    <td>{{ $user->created_at->format('M d, Y h:i a') }}</td>
                                    <td class="text-right">
                                        @if ($user->email_verified_at)
                                        <a style="pointer-events: none" class="{{Auth::user()->can('user-edit') ? 'btn btn-success btn-sm ' : 'btn btn-info btn-sm d-none'}}" title="Verified"><i class="fas fa-check-circle"></i></a>
                                        @else
                                        <button type="button" data-id="{{$user->id}}"
                                            value="{{$user->name}}"
                                            class="btnCanVerify {{Auth::user()->can('user-edit') ? 'btn btn-warning btn-sm' : 'btn btn-warning btn-sm d-none'}} " title="Click to verified"><i
                                                class="fas fa-exclamation-triangle"></i></button>
                                            </button>
                                        @endif
                                        <a href="{{ route('user.edit', $user) }}" class="{{Auth::user()->can('user-edit') ? 'btn btn-info btn-sm ' : 'btn btn-info btn-sm d-none'}}"><i class="fas fa-pen"></i></a>
                                        <button type="button" data-id="{{$user->id}}"
                                            value="{{$user->name}}"
                                            class="btnCanDestroy {{Auth::user()->can('user-delete') ? 'btn btn-danger btn-sm' : 'btn btn-danger btn-sm d-none'}} "><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr style=" text-align: center;font-size: large;vertical-align: middle;">
                                    <td colspan="6">{{ __('No Records found.') }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <table id="example" class="table table-responsive-sm table-striped table-bordered d-none"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011-07-25</td>
                                <td>$170,750</td>
                            </tr>
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                                <td>2009-01-12</td>
                                <td>$86,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    $('#tblUser').DataTable({
        order: [
            [0, 'asc']
        ]
    });


    $('#tblUser tbody').on('click','.btnCanDestroy',function() {
            Swal.fire({
                // title: 'Error!',
                text: 'Do you want to remove ' + $(this).val() + ' user?',
                icon: 'question',
                allowOutsideClick:false,
                confirmButtonText: 'Yes',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    window.location.href = base_url + "/users/delete/" + $(this).data('id');
                    Swal.fire({
                        title: $(this).val() + ' Deleted Successfully',
                        icon: 'success',
                        allowOutsideClick:false,
                        confirmButtonText: 'Close',
                    }).then(()=>{
                        $('#tblUser').DataTable().ajax.reload();
                    });
                }
            });
        });

        $('#tblUser tbody').on('click','.btnCanVerify',function() {
            Swal.fire({
                // title: 'Error!',
                text: 'Verify ' + $(this).val() + ' user?',
                icon: 'question',
                allowOutsideClick:false,
                confirmButtonText: 'Yes',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    window.location.href = base_url + "/users/verify/" + $(this).data('id');
                    Swal.fire({
                        title: $(this).val() + ' Verified Successfully',
                        icon: 'success',
                        allowOutsideClick:false,
                        confirmButtonText: 'Close',
                    }).then(()=>{
                        $('#tblUser').DataTable().ajax.reload();
                    });
                }
            });
        });

});
</script>
@endpush
