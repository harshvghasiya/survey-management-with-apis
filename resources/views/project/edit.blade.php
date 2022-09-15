@extends('layouts.app')
@section('third_party_stylesheets')
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection
@section('content')
{{-- <link rel="stylesheet" href="{{asset('css/select2.min.css')}}"> --}}
<div class="container-fluid">
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Project</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Project</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Project</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form method="POST" class="FromSubmit" id="editproject" action="{{ route('project.update',$projects->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                                        <input type="hidden" name="id" value="{{\Crypt::encrypt($projects->id)}}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Project Name</label><span class="text-danger">*</span>
                                    <div class="input-group mb-6">
                                        <input type="text" name="projectname" value="{{ $projects->projectname }}" class="form-control @error('projectname') is-invalid @enderror" placeholder="Project Name">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-map-marker-alt"></span></div>
                                        </div>
                                        @error('projectname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Project Category</label><span class="text-danger">*</span>
                                    <div class="input-group mb-6">
                                        <select id="category" name="category" class="form-control @error('category') is-invalid @enderror">
                                            <option value="" selected disabled>Select category</option>
                                            @foreach($categories as $data)
                                            <option value='{{$data->id}}' {{$data->id == $projects->category_id ? 'selected': ''}}>{{$data->category}}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-sitemap"></span></div>
                                        </div>
                                        @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label><span class="text-danger">*</span>
                                    <div class="input-group mb-6">
                                        <input type="date" name="startdate" value="{{ $projects->startdate }}" class="form-control @error('startdate') is-invalid @enderror" placeholder="DD/MM/YYYY">
                                        @error('startdate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label><span class="text-danger">*</span>
                                    <div class="input-group mb-6">
                                        <input type="date" name="enddate" value="{{ $projects->enddate }}" class="form-control @error('enddate') is-invalid @enderror" placeholder="DD/MM/YYYY">
                                        @error('enddate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Project Estimation (INR)</label><span class="text-danger">*</span>
                                <div class="input-group mb-6">
                                    <input type="number" name="estimation" value="{{ $projects->projectestimation }}" class="form-control @error('estimation') is-invalid @enderror" placeholder="Project Estimation">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span class="fas fa-rupee-sign"></span></div>
                                    </div>
                                    @error('estimation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Target Number of Beneficeries</label>
                                    <div class="input-group mb-6">
                                        <input type="number" name="target" value="{{ $projects->targetbeneficiaries }}" class="form-control @error('target') is-invalid @enderror" placeholder="Target count">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-users"></span></div>
                                        </div>
                                        @error('target')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description (optional)</label>
                                    <div class="input-group mb-6">
                                        <textarea class="form-control" name="description" rows="2" placeholder="Enter Description">
                                            {{ $projects->description }}
                                        </textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <br />
                        <div class="row">
                            <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                            </div>
                            <div class="col-md-1">
                                    <a class="btn btn-default " href="{{route('project.index')}}" style="margin-right: 20px;">Cancel</a>
                            </div>
                            <div class="col-md-10"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@include('scripts.multiple')
@endsection