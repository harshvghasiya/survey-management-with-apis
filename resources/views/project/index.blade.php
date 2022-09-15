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
                <h1 class="m-0 text-dark">Project Management</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Project Management</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">List of Project</h5>

                    <div class="card-tools">
                        <a class="btn btn-primary" href="{{route('project.create')}}" style="margin-right: 20px;">Add New Project</a>
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
                                <th style="width: 27%;">Project Name</th>
                                <th>Timeline</th>
                                 <th style="width: 10%;">Survey</th>
                                <th style="width: 12%;">Location</th>
                                <th style="width: 12%;">Users</th>
                                <th style="width: 12%;">View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->projectname}}</td>
                                <td>{!! date('d M Y',strtotime($data->startdate)) !!} <br><b>-</b><br> {!! date('d M Y',strtotime($data->enddate)) !!}</td>

                                <td>
                                    <a data-toggle="modal" id="mediumButton" data-target="#modal-lg" data-attr="{{ route('project.survey', $data->id) }}" title="show" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Survey
                                    </a>
                                </td>
                                <td>
                                    <a data-toggle="modal" id="mediumButton" data-target="#modal-lg" data-attr="{{ route('project.location', $data->id) }}" title="show" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Location
                                    </a>
                                </td>
                                <td>
                                    <a data-toggle="modal" id="mediumButton" data-target="#modal-lg" data-attr="{{ route('project.users', $data->id) }}" title="show" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Users
                                    </a>
                                </td>

                                    <td>
                                        <a data-toggle="modal" id="mediumButton" data-target="#modal-lg" data-attr="{{ route('project.show', $data->id) }}" title="show" class="btn btn-sm btn-success">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('project.edit', $data->id)}}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i> </a>
                                    </td>
                                    <td>
                                        
                                        <a href="javascript:void(0)" class="btn btn-danger delete_record" data-route="{{ route('project.destroy',$data->id)}}" ><i class="fas fa-trash"></i> </a>
                                    </td>
                                    <td>
                                        
                                        <a href="{{route('project.survey_order',$data->id)}}" class="btn btn-info" data-route="{{ route('project.destroy',$data->id)}}" ><i class="fas  fa-arrows-alt"></i> </a>
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" id="modal-lg" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"></h4>
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
@section('third_party_scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.sidebar-mini').addClass('sidebar-collapse');
    });
</script>
@endsection