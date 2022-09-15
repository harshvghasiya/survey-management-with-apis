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
                <h1 class="m-0 text-dark">Survey Order</h1>
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
                    <h5 class="card-title">List of Surveys</h5>

                    <div class="card-tools">
                        <a class="btn btn-primary survey_order_update" href="javascript:void()" style="margin-right: 20px;">Update Survey Order</a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        
                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    <table id="table" class="table ">
                        <thead id="sortable">
                            @if(isset($all_survey) && $all_survey != null)
                            @foreach($all_survey as $key=>$value)

                                <tr>
                                    <th class="survey_order" data-survey_id="{{$value->id}}" data-order="{{$key}}">{{$value->surveyname}}</th>
                                </tr>
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
              var survey_id = [];
               $('.survey_order').each(function(index,el){
                     survey_id[index]=$(this).data('survey_id');   
                });
              
              console.log(survey_id);
             $.ajax({
                url: '{{route('survey_order.survey_order_update')}}',
                type: 'POST',
                data: {survey_id:survey_id}, // stringyfy before passing
                 success:function (response) {
                     if (response.msg != null && response.status==1) {
                        location.reload();
                     }
                 }
             });
             
             
          });
    });
</script>
@endsection
