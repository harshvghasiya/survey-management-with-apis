@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<div class="container-fluid">

    <!-- Content Header (Page header) -->
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Management</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">User Management</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">List of Users</h5>

                    <div class="card-tools">
                        <a class="btn btn-primary" href="{{route('usermanagement.create')}}" style="margin-right: 20px;">Add New User</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <h6>{{ $message }}</h6>
                    </div>
                    @endif
                    @if ($message = Session::get('danger'))
                    <div class="alert alert-danger">
                        <h6>{{ $message }}</h6>
                    </div>
                    @endif
                    <table id="table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Username</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->first_name}} {{$data->last_name}}</td>
                                <td>{{$data->userrole}}</td>
                                <td>{{$data->username}}</td>
                                <td>{{$data->phone_number}}</td>
                                <td>{{$data->email}}</td>
                                <td>{{$data->state}}</td>
                                <td>{{$data->district}}</td>
                                <td><a href="{{ route('usermanagement.edit', $data->id)}}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a></td>
                                <td>
                                    <form action="{{ route('usermanagement.destroy', $data->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@include('scripts.table')
@endsection