@extends('layouts.app')
@section('third_party_stylesheets')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
{{-- <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}"> --}}
<div class="container-fluid">

    <!-- Content Header (Page header) -->
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Survey Types</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Survey Types</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">List of Survey Types</h5>

                    <div class="card-tools">
                        <a class="btn btn-primary" href="{{route('surveytypes.create')}}" style="margin-right: 20px;">Add New Types</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    
                    <table id="table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Survey Type</th>
                                <th>Description</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($survey as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->surveytype}}</td>
                                <td>{{$data->description}}</td>
                                <td><a href="{{ route('surveytypes.edit', $data->id)}}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> Edit</a></td>
                                <td>
                                   
                                        <button class="btn btn-danger delete_record" data-route="{{ route('surveytypes.destroy', $data->id)}}"><i class="fas fa-trash"></i> Delete</button>
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