@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Survey Types</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">New Survey Types</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Survey Types</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form method="post" action="{{ route('surveytypes.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Survey Type Name</label>
                                    <div class="input-group mb-6">
                                        <input type="text" name="surveytype" value="{{ old('surveytype') }}" class="form-control @error('surveytype') is-invalid @enderror" placeholder="Location Name">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-sitemap"></span></div>
                                        </div>
                                        @error('surveytype')
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
                                    <label>Description</label>
                                    <div class="input-group mb-6">
                                        <textarea class="form-control" name="description" rows="2" placeholder="Enter Description"></textarea>
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
                                    <a class="btn btn-default " href="{{route('surveytypes.index')}}" style="margin-right: 20px;">Cancel</a>
                            </div>
                            <div class="col-md-10"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection