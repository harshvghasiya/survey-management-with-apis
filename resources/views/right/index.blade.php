@extends('layouts.app')
@section('title')
 @if($title != null && $title!= "")  {{$title}} |  @endif  {{trans('message.app_name')}}
@endsection
@section('third_party_stylesheets')

    <link href="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@endsection
@section('content')
<div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                 <div class="content-header">
                      <div class="row mb-2">
                          <div class="col-sm-6">
                              <h1 class="m-0 text-dark">Rights Managment</h1>
                          </div><!-- /.col -->
                          <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                  <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                  <li class="breadcrumb-item active">Rights</li>
                              </ol>
                          </div><!-- /.col -->
                      </div><!-- /.row -->
                  </div>
                <!--end breadcrumb-->
                <div class="card">
                    
                    <div class="card-body">
                        <div class="card-title">
                          
                        </div>    
                        <div class="card-body">
                            <form method="POST" id="search-form" class="form" role="form">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-3">
                                         <input type="text" class="form-control" name="name" id="name" placeholder="{{trans('message.search_name_placeholder')}}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="status" class="form-control">
                                            <option value="">{{trans('message.select_status_label')}}</option>
                                            <option value="1">{{trans('message.active_label')}}</option>
                                            <option value="0">{{trans('message.inactive_label')}}</option>
                                        </select>
                                    </div>
                                     <div class="col-md-3">
                                         <button type="button" class="btn btn-primary search_text">{{trans('message.search_label')}}</button>
                                         <a href="javascript:void(0);" onclick="RESET_FORM();" class="btn btn-danger  btn-flat" id="reset_data_table">{{trans('message.reset_label')}}</a>
                                    </div>
                                    
                                </div>
                        </div>
                    </div>
                    
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row m-4">
                            <div class="col-md-6">
                              @if(env('IS_MASTER_ADMIN') == true)
                              <div class="btn-group">
                                <a href="{{route('right.create')}}" id="sample_editable_1_new" class="btn btn-primary">
                                {{trans('message.add_new')}} 
                                </a>
                              </div>
                              
                                <div class="btn-group">
                                  <a class="btn btn-danger " onclick="deleteAll('select_checkbox_value','{{route('right.delete_all')}}')">{{trans('message.delete_all_label')}}
                                  </a>
                                </div>
                              @endif
                              <div class="btn-group">
                                <a class="btn btn-warning " style="color: white;" onclick="statusAll('select_checkbox_value','{{route('right.status_all')}}')">{{trans('message.status_all_label')}}
                                </a>
                              </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                             {{ Form::open([
                                  'id'=>'table_form',
                                  'class'=>'table_form',
                                  'name'=> 'form_data'
                                ])
                              }}
                            <table id="users-table" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkbox[]"  class="select_checkbox_value" value="1" id="select_all" /></th>
                                        <th>{{trans('message.name')}}</th>
                                        <th>{{trans('message.status')}}</th>
                                        <th>{{trans('message.action')}}</th>
                                    </tr>
                                </thead>
                            </table>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
@endsection
@section('third_party_scripts')
    <script src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script>
  var oTable = $('#users-table').DataTable({
      processing: true,
      serverSide: true,
      searching:false,
      responsive: true,
      ajax: {
            url:'{!! route('right.any_data') !!}',
            data: function (d) {
                d.name = $('input[name=name]').val();
                d.status = $('select[name=status]').val();
              }
          },
      columns: [
          { data: 'id',orderable: false,searchable: false},
          { data: 'name'},
          { data: 'status'},
          { data: 'action',name:'action', orderable: false, searchable: false}
      ]
  });
  
  $(document).on("click",".search_text",function(){
      oTable.draw();
      return false;
  });

  function RESET_FORM(){

    $("#search-form").trigger('reset'); 
        oTable.draw();
        return false;
  }
  $(document).ready(function(){
      
    $(document).on("click","#active_inactive",function(){
        
      swal({
        title: "{{trans('message.are_you_sure_want_change_status_label')}}",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
              var status = $(this).attr('status');
              var id = $(this).attr('data-id');
              var cur =$(this);
              $.ajax({
                type:"POST",
                url:"{{route('right.single_status_change')}}",
                data:{"status":status,"id":id,"_token": "{{ csrf_token() }}"},
                success:function(data){
                         if (data.status == 0) {
                            cur.removeClass('btn-success');
                            cur.addClass('btn-danger');
                            cur.text('{{trans('message.inactive_label')}}');
                         }else{
                            cur.removeClass('btn-danger');
                            cur.addClass('btn-success');
                            cur.text('{{trans('message.active_label')}}');
                         }
                  }
              })
          swal("{{trans('message.status_has_been_successfully_changed_label')}}", {
                      icon: "success",
          });
        } 
      });
    })
  });

  
</script>
  
@endsection
