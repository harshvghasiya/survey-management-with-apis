@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<div class="container-fluid">

    <!-- Content Header (Page header) -->
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Role</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">User Roles</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">List of User Roles</h5>

                    <div class="card-tools">
                        <a class="btn btn-primary" href="{{route('userrole.create')}}" style="margin-right: 20px;">Add New User Role</a>
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
                                <th>S.No.</th>
                                <th>User Role</th>
                                <th>Admin Role</th>
                                <th>Description</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userrole as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->userrole}}</td>
                                <td>
                                    @if($data->adminrole==1)
                                    Yes
                                    @elseif($data->adminrole==0)
                                    No
                                    @endif
                                </td>
                                <td>{{$data->description}}</td>
                                {{-- <form action="{{ route('userrole.destroy', $data->id)}}" method="POST"> --}}
                                    <td>
                                        <a data-toggle="modal" id="mediumButton" data-target="#modal-lg" data-attr="{{ route('userrole.show', $data->id) }}" title="show" class="btn btn-success">
                                            <i class="fas fa-eye"></i> View Role Rights
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('userrole.edit', $data->id)}}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Edit</a>
                                    </td>
                                    <td>
                                        {{-- @csrf
                                        @method('DELETE') --}}
                                        <button class="btn btn-danger delete_record" data-route="{{ route('userrole.destroy', $data->id)}}" type="submit"><i class="fas fa-trash"></i> Delete</button>
                                    </td>
                                {{-- </form> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" id="modal-lg" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">User role pages</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="mediumBody">
                                    <div>
                                        <!-- the result to be displayed apply here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</div>
@include('scripts.table')
@include('scripts.modal')
@endsection