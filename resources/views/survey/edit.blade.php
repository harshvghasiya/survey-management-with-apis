@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Survey</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Survey</li>
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
                    <form method="post" class="FromSubmit" id="editsurevyform" action="{{ route('survey.update', $survey->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Survey Name</label><span class="text-danger">*</span>
                                    <div class="input-group mb-6">
                                        <input type="text" name="survey" value="{{ $survey->surveyname }}" class="form-control @error('survey') is-invalid @enderror" placeholder="Survey Name">
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
                                            <option value="" selected >Select Survey Type</option>
                                            @foreach($surveytype as $surveytypedata)
                                            <option value='{{$surveytypedata->id}}' {{ $surveytypedata->id==$survey->surveytype_id ? 'selected' : '' }}>{{$surveytypedata->surveytype}}</option>
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
                                        <textarea class="form-control" rows="2" name="description" placeholder="Enter Description">{{$survey->description}}</textarea>
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
                            @php
                            $i = 0
                            @endphp
                            @foreach($surveydata as $old)
                            @if($i==0)
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
                                            <input type="text" id="question0" name="multipleinput[{{$i}}][question]" value="{{ $old->question }}" class="form-control @error('ques1') is-invalid @enderror" placeholder="Question">
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
                                            <select id="questiontype0" name="multipleinput[{{$i}}][questiontype]" class="form-control @error('questiontype') is-invalid @enderror" onchange="showhideoptions(this.value,'{{$i}}')">
                                                <option value="" >Choose Question Type</option>
                                                <option value="text" {{ $old->question_type=='text' ? 'selected' : '' }}>Text</option>
                                                <option value="number" {{ $old->question_type=='number' ? 'selected' : '' }}>Number</option>
                                                <option value="trueorfalse" {{ $old->question_type=='trueorfalse' ? 'selected' : '' }}>True or False</option>
                                                <option value="multichoiceoneans" {{ $old->question_type=='multichoiceoneans' ? 'selected' : '' }}>Mutliple choice with one answer</option>
                                                <option value="multichoicemultians" {{ $old->question_type=='multichoicemultians' ? 'selected' : '' }}>Mutliple choice with Multiple answer</option>
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
                                        <input type="checkbox" id="checkboxPrimary{{$i}}" name="multipleinput[{{$i}}][mandatory]" @if($old->required) checked @endif>
                                        <label for="checkboxPrimary{{$i}}">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <label style="padding-left: 10px;">Database column</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="dbcolumn" class="form-control" name="multipleinput[{{$i}}][dbcolumn]" value="{{$old->column}}" placeholder="Database column" />
                                </div>
                                <div class="col-md-12">
                                <br/>
                                <label style="padding-left: 10px;">Answers</label>
                                </div>
                                
                                <div id="dynamicquestions{{$i}}" class="col-md-12">
                                    {{-- {{dd($old)}} --}}
                                    @if($old->question_type=='text')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input class="form-control" id="{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][{{$old->question_type}}]" placeholder="Textbox" value="{{$old->text}}" />
                                        </div>
                                    </div>
                                    
                                    @elseif($old->question_type=='number')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input class="form-control" type="number" id="{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][{{$old->question_type}}]" value="{{$old->size}}" placeholder="Total Size (i.e. Max numbers allowed)" />
                                        </div>
                                    </div>
                                    
                                    @elseif($old->question_type=='trueorfalse')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control" id="{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][{{$old->question_type}}]">
                                                <option selected >The Following are the options</option>
                                                <option value="No" @if($old->true_false==0) selected="true" @endif>No</option>
                                                <option value="Yes" @if($old->true_false==1) selected="true" @endif>Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    @elseif($old->question_type=='multichoiceoneans')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control" id="option0{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option0{{$old->question_type}}]" value="{{$old->option1}}" placeholder="option 1" />
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" id="option1{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option1{{$old->question_type}}]" value="{{$old->option2}}" placeholder="option 2" />
                                        </div>
                                        <br /><br /><br />
                                        <div class="col-md-6">
                                            <input class="form-control" id="option2{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option2{{$old->question_type}}]" value="{{$old->option3}}" placeholder="option 3" />
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" id="option3{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option3{{$old->question_type}}]" value="{{$old->option4}}" />
                                        </div>
                                    </div>
                                    
                                    @elseif($old->question_type=='multichoicemultians')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control" id="option0{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option0{{$old->question_type}}]" value="{{$old->option1}}" placeholder="option 1" />
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" id="option1{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option1{{$old->question_type}}]" value="{{$old->option2}}" placeholder="option 2" />
                                        </div>
                                        <br /><br /><br />
                                        <div class="col-md-6">
                                            <input class="form-control" id="option2{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option2{{$old->question_type}}]" value="{{$old->option3}}" placeholder="option 3" />
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" id="option3{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option3{{$old->question_type}}]" value="{{$old->option4}}" />
                                        </div>
                                    </div>
                                    
                                    @endif
                                    <br/>
                                </div>
                            </div>
                            @php
                            $i++
                            @endphp
                            @else
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
                                            <input type="text" id="question0" name="multipleinput[{{$i}}][question]" value="{{ $old->question }}" class="form-control @error('ques1') is-invalid @enderror" placeholder="Question">
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
                                            <select id="questiontype0" name="multipleinput[{{$i}}][questiontype]" class="form-control @error('questiontype') is-invalid @enderror" onchange="showhideoptions(this.value,'{{$i}}')">
                                                <option value="" >Choose Question Type</option>
                                                <option value="text" {{ $old->question_type=='text' ? 'selected' : '' }}>Text</option>
                                                <option value="number" {{ $old->question_type=='number' ? 'selected' : '' }}>Number</option>
                                                <option value="trueorfalse" {{ $old->question_type=='trueorfalse' ? 'selected' : '' }}>True or False</option>
                                                <option value="multichoiceoneans" {{ $old->question_type=='multichoiceoneans' ? 'selected' : '' }}>Mutliple choice with one answer</option>
                                                <option value="multichoicemultians" {{ $old->question_type=='multichoicemultians' ? 'selected' : '' }}>Mutliple choice with Multiple answer</option>
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
                                        <input type="checkbox" id="checkboxPrimary{{$i}}" name="multipleinput[{{$i}}][mandatory]" @if($old->required) checked @endif>
                                        <label for="checkboxPrimary{{$i}}">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label style="padding-left: 10px;">Database column</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" id="dbcolumn" class="form-control" name="multipleinput[{{$i}}][dbcolumn]" value="{{$old->column}}" placeholder="Database column" />
                                </div>
                                <div class="col-md-12">
                                    <br/>
                                <label style="padding-left: 10px;">Answers</label>
                                </div>
                                
                                <div id="dynamicquestions{{$i}}" class="col-md-12">
                                    @if($old->question_type=='text')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input class="form-control" id="{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][{{$old->question_type}}]" placeholder="Textbox" value={{$old->text}} />
                                        </div>
                                    </div>
                                    
                                    @elseif($old->question_type=='number')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input class="form-control" type="number" id="{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][{{$old->question_type}}]" value="{{$old->size}}" placeholder="Total Size (i.e. Max numbers allowed)" />
                                        </div>
                                    </div>
                                    
                                    @elseif($old->question_type=='trueorfalse')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control" id="{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][{{$old->question_type}}]">
                                                <option selected >The Following are the options</option>
                                                <option value="0" @if($old->true_false==0) selected="true" @endif >No</option>
                                                <option value="1" @if($old->true_false==1) selected="true" @endif >Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    @elseif($old->question_type=='multichoiceoneans')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control" id="option0{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option0{{$old->question_type}}]" value="{{$old->option1}}" placeholder="option 1" />
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" id="option1{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option1{{$old->question_type}}]" value="{{$old->option2}}" placeholder="option 2" />
                                        </div>
                                        <br /><br /><br />
                                        <div class="col-md-6">
                                            <input class="form-control" id="option2{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option2{{$old->question_type}}]" value="{{$old->option3}}" placeholder="option 3" />
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" id="option3{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option3{{$old->question_type}}]" value="{{$old->option4}}" />
                                        </div>
                                    </div>
                                    
                                    @elseif($old->question_type=='multichoicemultians')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input class="form-control" id="option0{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option0{{$old->question_type}}]" value="{{$old->option1}}" placeholder="option 1" />
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" id="option1{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option1{{$old->question_type}}]" value="{{$old->option2}}" placeholder="option 2" />
                                        </div>
                                        <br /><br /><br />
                                        <div class="col-md-6">
                                            <input class="form-control" id="option2{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option2{{$old->question_type}}]" value="{{$old->option3}}" placeholder="option 3" />
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" id="option3{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option3{{$old->question_type}}]" value="{{$old->option4}}" />
                                        </div>
                                    </div>
                                    @endif
                                    <br/>
                                </div>
                            </div>
                            @php
                            $i++
                            @endphp
                            @endif
                            @endforeach
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
@include('scripts.switch')
@include('scripts.editdynamicsurvey')
@endsection