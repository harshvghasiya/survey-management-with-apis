@extends('layouts.app')
@section('third_party_stylesheets')
<style type="text/css" media="screen">
#sortable:hover{
    cursor:  all-scroll;
}    
</style>
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
<div class="container-fluid">

    <!-- Content Header (Page header) -->
    <div class="content-header">
  
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Survey Dependency Order</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Survey Order</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add New Survey</h5>

                    <div class="card-tools">
                       
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        
                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    <form method="post" action="{{ route('project.updatesurvey',$project->id) }}" enctype="multipart/form-data">
                          @csrf
                          @method('PUT')
                          <input type="text" hidden value="2" name="is_order">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Select Surveys</label>
                                      <div class="input-group mb-6">
                                          <select id="surveyform" name="surveyform[]" multiple="true" placeholder="Select Survey Form" class="survey_project_store select2survey form-control @error('surveyform') is-invalid @enderror" >
                                              @foreach($survey as $data)
                                                  @php

                                                      if (isset($survey_selected) && $survey_selected != null && in_array($data->id, $survey_selected)) {
                                                          $checked='selected';
                                                      }else{
                                                          $checked="";
                                                      }
                                                  @endphp
                                              <option value='{{$data->id}}' {{$checked}}>{{$data->surveyname}}</option>
                                              @endforeach
                                          </select>
                                          
                                          @error('surveyform')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <br />
                          <div id="surveyformdetails">
                                
                          </div>
                          <div class="row">
                              <div class="col-md-2">
                                  <div class="form-group">
                                      <button type="submit" id="submitbutton" class="btn btn-primary form-control">Update Survey List</button>
                                  </div>
                              </div>
                          </div>
                    </form>
                   
                </div>
            </div>
        </div>
    </section>


     <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">List of Surveys</h5>

                    <div class="card-tools">
                        <a class="btn btn-primary survey_order_update" data-project_id="{{$project->id}}" href="javascript:void()" style="margin-right: 20px;">Update Survey Order</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        
                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    <table id="table" class="table ">
                        <thead id="sortable">
                            @if(isset($project->project_surveys) && $project->project_surveys != null)
                            @foreach($project->project_surveys as $key=>$value)

                              @if(isset($value->survey) && $value->survey != null )
                                  <tr>
                                      <th class="survey_order" data-survey_id="{{$value->survey->id}}" data-order="{{$key}}">{{$value->survey->surveyname}}</th>
                                      <th>
                                        <a href="javascript:void" class="btn btn-danger delete_record" data-route={{route('project.survey_destory',[$project->id,$value->survey_id])}}>
                                            <i class="fas fa-trash"></i>
                                        </a>
                                      </th>
                                  </tr>
                              @endif
                            @endforeach
                            @endif
                        </thead>
                       
                        
                    </table>
                   
                </div>
            </div>
        </div>
    </section>
</div>
{{-- @include('scripts.table') --}}
{{-- @include('scripts.modal') --}}
@endsection
@section('third_party_scripts')
<script type="text/javascript">
    $(document).ready(function() {
          $( "#sortable" ).sortable();

          $(document).on('click', '.survey_order_update', function(event) {
              event.preventDefault();
              var project_id=$(this).data('project_id');
              var survey_id = [];
               $('.survey_order').each(function(index,el){
                     survey_id[index]=$(this).data('survey_id');   
                });
              
              console.log(survey_id);
             $.ajax({
                url: '{{route('project.survey_order_update')}}',
                type: 'POST',
                data: {survey_id:survey_id,project_id:project_id}, // stringyfy before passing
                 success:function (response) {
                     if (response.msg != null && response.status==1) {
                        location.reload();
                     }
                 }
             });
             
             
          });
    });
</script>
@include('scripts.multiple')

@if(isset($survey_selected) && $survey_selected != null)
<script type="text/javascript">
    $(document).ready(function() {
        $('#surveyform').trigger("change");
    });

</script>
@endif
@endsection
