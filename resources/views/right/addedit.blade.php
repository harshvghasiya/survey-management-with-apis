@extends('layouts.app')
@section('title')
 @if($title != null && $title!= "") {{$title}} @else {{trans('message.right_title')}} @endif | {{trans('message.app_name')}}
@endsection
@section('third_party_stylesheets')
<style type="text/css">
    
</style>
@endsection
@section('content')

<div class="page-wrapper">
                <div class="page-content">
                    <!--breadcrumb-->
                <div class="content-header">

                  <div class="row mb-2">
                      <div class="col-sm-6">
                          <h1 class="m-0 text-dark">@if(!isset($right)) Create Right @else Edit Right @endif</h1>
                      </div><!-- /.col -->
                      <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-right">
                              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                              <li class="breadcrumb-item active">@if(!isset($right)) Create Right @else Edit Right @endif</li>
                          </ol>
                      </div><!-- /.col -->
                  </div><!-- /.row -->
                </div>

                    <!--end breadcrumb-->
                    <div class="row">
                        <div class="col-xl-11 mx-auto">
                            <hr/>
                            <div class="card border-top border-0 border-4 border-primary">
                                <div class="card-header">
                                    <h5 class="card-title">@if(!isset($right)) New Right @else Edit Right @endif</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                    

                                <div class="card-body p-5">
                                     @if(isset($right))
                                        {{ Form::model($right,
                                          array(
                                          'id'                => 'AddEditright',
                                          'class'             => 'FromSubmit row g-3',
                                          'url'               => route('right.update', $encryptedId),
                                          'method'            => 'PUT',
                                          'enctype'           =>"multipart/form-data"
                                          ))
                                        }}
                                        <input type="hidden" name="id" value="{{$encryptedId}}">
                                      @else
                                        {{
                                          Form::open([
                                          'id'=>'AddEditright',
                                          'class'=>'FromSubmit row g-3',
                                          'url'=>route('right.store'),
                                          'name'=>'socialMedia',
                                          'enctype' =>"multipart/form-data"
                                          ])
                                        }}
                                      @endif
                                      <div class="row">
                                        <div class="col-md-8">
                                          <div class="form-group">

                                            <label for="name" class="form-label">{{trans('message.right_name_label')}}</label>
                                            {{ Form::text('name',null,['placeholder'=>trans('message.name_placeholder'),'id'=>'name','class'=>'form-control'])}}
                                          </div>
                                        </div>
                                        <div class="col-md-8">
                                          <div class="form-group">

                                          <label for="email" class="form-label">{{trans('message.status_label')}}</label><br>

                                          <div class="form-check form-check-inline">
                                              <input class="form-check-input" {{ isset($right)?($right->status == 1)?'checked':'':'checked' }} type="radio" name="status" id="inlineRadio1" value="1">
                                              <label class="form-check-label" for="inlineRadio1">{{trans('message.active_label')}}</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="0" {{ isset($right)?($right->status == 0)?'checked':'':'' }}>
                                              <label class="form-check-label" for="inlineRadio1">{{trans('message.inactive_label')}}</label>
                                          </div>
                                        </div>
                                        </div>
                                       </div>

                                        

                                        <div class="card-body">
                                          <div class="card-header">
                                            <h5 class="card-title">@if(!isset($right)) Add Modules @else Edit Modules @endif</h5>
                                            <div class="card-tools">
                                                <input type="checkbox" name="checke_all" id="checked_all" class="form-check-input">
                                                  <label class="form-check-label" for="checked_all">{{trans('message.check_all')}}</label>
                                            </div>
                                        </div>
                                              
                                        <div class="row mt-4">

                                          @if(\App\Models\Module::getModuleDropDown() != null)
                                         
                                          @foreach(\App\Models\Module::getModuleDropDown() as $key=>$value)
                                            <div class="col-md-4">
                                              @php
                                              $checked=""; 
                                              @endphp
                                              @if(isset($right) && $right->right_module !=null ) 
                                              
                                              @foreach($right->right_module as $k=>$val)
                                               @php 
                                                        $pages=null;
                                                
                                                if($val->module_id==$key) {
                                                  if (isset($val->module_data->module_page_access) && $val->module_data->module_page_access != null) {
                                                    $pages=$val->module_data->module_page_access->page_access;
                                                    if ($pages != null) {
                                                      $pages=json_decode($pages);
                                                    }else{
                                                      $pages=null;
                                                    }
                                                  }
                                                  $checked='checked';
                                                  break;
                                                }
                                               @endphp
                                              @endforeach
                                              <div class="form-check">
                                                  {{ Form::checkbox('module_id[]',$key,$checked,["class"=>"right_data form-check-input",'id'=>"flexCheckDefault$key"]) }}
                                                  <label class="form-check-label" for="flexCheckDefault{{$key}}">{{$value}}</label>
                                                @if( pageAccess() != null)
                                                  @foreach(pageAccess() as $pa=>$page)
                                                    @php
                                                    $page_exist=false;

                                                    if (isset($pages) && $pages != null) {
                                                      if (in_array($pa,$pages)) {
                                                        $page_exist=true;
                                                      }
                                                    }
                                                    @endphp
                                                  <div class="form-check">
                                                    {{ Form::checkbox('page_id['.$key.'][]',$pa,$page_exist,["class"=>"right_data form-check-input",'id'=>"page$key$pa"]) }}
                                                  <label class="form-check-label" for="page{{$key}}{{$pa}}">{{$page}}</label>
                                                  </div>
                                                  @endforeach
                                                  @endif
                                              </div>
                                              @else
                                              <div class="form-check">
                                                  {{ Form::checkbox('module_id[]',$key,null,["class"=>"right_data form-check-input",'id'=>"flexCheckDefault$key"]) }}
                                                  <label class="form-check-label" for="flexCheckDefault{{$key}}">{{$value}}</label>
                                                  @if( pageAccess() != null)
                                                  @foreach(pageAccess() as $pa=>$page)
                                                  <div class="form-check">
                                                    {{ Form::checkbox('page_id['.$key.'][]',$pa,null,["class"=>"right_data form-check-input",'id'=>"page$key$pa"]) }}
                                                  <label class="form-check-label" for="page{{$key}}{{$pa}}">{{$page}}</label>
                                                  </div>
                                                  @endforeach
                                                  @endif
                                              </div>
                                              @endif
                                            </div>
                                          @endforeach

                                          @endif
                                          </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary px-4">{{trans('message.save')}}</button>
                                            <a href="{{route('right.index')}}" class="btn btn-secondary">{{trans('message.cancle')}}</a>
                                        </div>
                                    {{Form::close()}}
                                </div>
                            </div>
                            <hr/>
                            
                        </div>
                    </div>
                   
                </div>
            </div>
@endsection
@section('third_party_scripts')
<script type="text/javascript">
  $(document).ready(function() {
     if($("#checked_all").length>0)
    {
      $(document).on("click","#checked_all",function(){
        select_all_right();
      });
    }
    function select_all_right()
    {
      console.log("in");
      if($("#checked_all").prop("checked"))
      {
        $(".right_data").each(function(){
            $(this).prop("checked",true);

        });
      }
      else
      {
        $(".right_data").prop("checked",false);
      }
    }

    
    $(document).on('click', '.right_data', function(event) {
      
      /* Act on the event */
    if ($(this).prop('checked')) {
          $(this).closest('div').find('[type=checkbox]').prop('checked', true);
    } else{
          $(this).closest('div').find('[type=checkbox]').prop('checked', false);
    }
    });

    



  });
</script>
@endsection
