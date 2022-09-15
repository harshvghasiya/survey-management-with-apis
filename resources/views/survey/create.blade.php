@extends('layouts.app')
@section('third_party_stylesheets')
<link rel="stylesheet" href="{{asset('css/icheck-bootstrap.min.css')}}" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Survey</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">New Survey</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">User Details</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form method="post" class="FromSubmit" action="{{ route('survey.store') }}" id="survey-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Survey Name</label><span class="text-danger">*</span>
                                    <div class="input-group mb-6">
                                        <input type="text" name="survey" value="{{ old('survey') }}" class="form-control @error('survey') is-invalid @enderror" placeholder="Survey Name">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-question"></span></div>
                                        </div>
                                        @error('survey')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Survey Type</label><span class="text-danger">*</span>
                                    <div class="input-group mb-6">
                                        <select id="surveytype" name="surveytype" class="form-control @error('surveytype') is-invalid @enderror">
                                            <option value="" selected disabled>Select Survey Type</option>
                                            @foreach($surveytype as $surveytypedata)
                                            <option value='{{$surveytypedata->id}}'>{{$surveytypedata->surveytype}}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-question"></span></div>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description (optional)</label>
                                    <div class="input-group mb-6">
                                        <textarea class="form-control" rows="2" placeholder="Enter Description" name="description"></textarea>
                                        @error('taluk')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                        </div>
                        <br />
                        <hr>
                        <h4>Questions</h4>
                        <br />
                        <div id=dynamic>
                            <div class="row">
                                <div class="col-md-7">
                                    <label>Question</label>
                                </div>
                                <div class="col-md-3">
                                    <label>Question Type</label>
                                </div>
                                <div class="col-md-2" style="text-align:center;">
                                    <label>Mandatory</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">

                                        <div class="input-group mb-6">
                                            <input type="text" id="question0" name="multipleinput[0][question]" value="{{ old('ques1') }}" class="form-control @error('ques1') is-invalid @enderror" placeholder="Question">
                                            @error('ques1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <!-- <label>Email-Id</label> -->
                                        <div class="input-group mb-6">
                                            <select id="questiontype0" name="multipleinput[0][questiontype]" class="form-control @error('questiontype') is-invalid @enderror" onchange="showhideoptions(this.value,0)">
                                                <option value="" selected disabled>Choose Question Type</option>
                                                <option value="text">Text</option>
                                                <option value="number">Number</option>
                                                <option value="trueorfalse">True or False</option>
                                                <option value="multichoiceoneans">Mutliple choice with one answer</option>
                                                <option value="multichoicemultians">Mutliple choice with Multiple answer</option>
                                            </select>

                                            @error('questiontype')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2" style="text-align:center;">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="checkboxPrimary0" name="multipleinput[0][mandatory]">
                                        <label for="checkboxPrimary0">
                                        </label>
                                    </div>
                                </div>
                                <label style="padding-left: 10px;">Answers</label>
                                <div id="dynamicquestions0" class="col-md-12">

                                </div>
                            </div>
                        </div>
                        <br />
                        <br />
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <input type="button" id="addItem" class="btn btn-primary form-control" onclick="switchmethod()" value="Add New Question" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                {{-- <div class="form-group"> --}}
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                                {{-- </div> --}}
                            </div>
                            <div class="col-md-1">
                                {{-- <div class="form-group"> --}}
                                    <a class="btn btn-default " href="{{route('survey.index')}}" style="margin-right: 20px;">Cancel</a>
                                {{-- </div> --}}
                            </div>
                            <div class="col-md-10"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@include('scripts.dynamicsurvey')
@endsection