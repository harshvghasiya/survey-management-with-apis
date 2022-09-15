@extends('layouts.app')
@section('third_party_stylesheets')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="container-fluid">

    <!-- Content Header (Page header) -->
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Project Category</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Project Category</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">List of Project Categories</h5>

                    <div class="card-tools">
                        <a class="btn btn-primary" href="{{route('projectcategory.create')}}" style="margin-right: 20px;">Add New Category</a>
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
                                <th>Category</th>
                                <th>Description</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->category}}</td>
                                <td>{{$data->description}}</td>
                                <td><a href="{{ route('projectcategory.edit', $data->id)}}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Edit</a></td>
                                <td>
                                    
                                        <button class="btn btn-danger delete_record" data-route="{{ route('projectcategory.destroy', $data->id) }}"><i class="fas fa-trash"></i> Delete</button>
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