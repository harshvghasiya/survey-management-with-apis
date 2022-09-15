@extends('layouts.app')
@section('title')
 @if($title != null && $title!= "") {{$title}} @else {{trans('message.module_title')}} @endif | {{trans('message.app_name')}}
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
                              <h1 class="m-0 text-dark">@if(!isset($module)) Create Module @else Edit Module @endif</h1>
                          </div><!-- /.col -->
                          <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                  <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                  <li class="breadcrumb-item active">@if(!isset($module)) Create Module @else Edit Module @endif</li>
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
                                    <h5 class="card-title">@if(!isset($module)) New Module @else Edit Module @endif</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-5">
                                     @if(isset($module))
                                        {{ Form::model($module,
                                          array(
                                          'id'                => 'AddEditCompanyCategory',
                                          'class'             => 'FromSubmit row g-3',
                                          'url'               => route('module.update', $encryptedId),
                                          'method'            => 'PUT',
                                          'enctype'           =>"multipart/form-data"
                                          ))
                                        }}
                                        <input type="hidden" name="id" value="{{$encryptedId}}">
                                      @else
                                        {{
                                          Form::open([
                                          'id'=>'AddEditCompanyCategory',
                                          'class'=>'FromSubmit row g-3',
                                          'url'=>route('module.store'),
                                          'name'=>'socialMedia',
                                          'enctype' =>"multipart/form-data"
                                          ])
                                        }}
                                      @endif

                                        <div class="col-md-6">
                                          <div class="form-group">

                                            <label for="name" class="form-label">{{trans('message.module_name_label')}}</label>
                                            {{ Form::text('name',null,['placeholder'=>trans('message.name_placeholder'),'id'=>'name','class'=>'form-control'])}}
                                          </div>

                                        </div>
                                        <div class="col-md-8">
                                          <div class="form-group">

                                          <label for="email" class="form-label">{{trans('message.status_label')}}</label><br>

                                          <div class="form-check form-check-inline">
                                              <input class="form-check-input" {{ isset($module)?($module->status == 1)?'checked':'':'checked' }} type="radio" name="status" id="inlineRadio1" value="1">
                                              <label class="form-check-label" for="inlineRadio1">{{trans('message.active_label')}}</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="0" {{ isset($module)?($module->status == 0)?'checked':'':'' }}>
                                              <label class="form-check-label" for="inlineRadio1">{{trans('message.inactive_label')}}</label>
                                          </div>
                                        </div>
                                        </div>
                                       
                                        
                                        <hr>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary px-4">{{trans('message.save')}}</button>
                                            <a href="{{route('module.index')}}" class="btn btn-secondary">{{trans('message.cancle')}}</a>
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

@endsection
