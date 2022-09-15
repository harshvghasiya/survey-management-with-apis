@extends('layouts.app')
@section('title')
 @if($title != null && $title!= "") {{$title}} @else {{trans('message.basic_setting_logo_head_title')}} @endif | {{trans('message.app_name')}}
@endsection
@section('third_party_stylesheets')
  <link href="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
  <link href="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
<style type="text/css">
    
</style>
@endsection
@section('content')

<div class="container-fluid">
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@if(!isset($admin_user)) Create Admin User @else Edit Admin User @endif</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">@if(!isset($admin_user)) Create Admin User @else Edit Admin User @endif</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@if(!isset($admin_user)) New Admin User @else Edit Admin User @endif</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                     @if(isset($admin_user))
                                        {{ Form::model($admin_user,
                                          array(
                                          'id'                => 'AddEditAdmin',
                                          'class'             => 'FromSubmit row g-3',
                                          'url'               => route('admin_user.update', $encryptedId),
                                          'method'            => 'PUT',
                                          'enctype'           =>"multipart/form-data"
                                          ))
                                        }}
                                        <input type="hidden" name="id" value="{{$encryptedId}}">
                                      @else
                                        {{
                                          Form::open([
                                          'id'=>'AddEditAdmin',
                                          'class'=>'FromSubmit row g-3',
                                          'url'=>route('admin_user.store'),
                                          'name'=>'socialMedia',
                                          'enctype' =>"multipart/form-data"
                                          ])
                                        }}
                                      @endif
                        @csrf
                        
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">

                                  <label for="name" class="form-label">First Name</label>
                                  <div class="input-group mb-6">
                                      {{ Form::text('first_name',null,['placeholder'=>'First Name','id'=>'first_name','class'=>'form-control'])}}
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">

                                  <label for="name" class="form-label">Last Name</label>
                                  <div class="input-group mb-6">
                                      {{ Form::text('last_name',null,['placeholder'=>'Last Name','id'=>'last_name','class'=>'form-control'])}}
                                  </div>
                              </div>
                          </div> 
                          <div class="col-md-6">
                              <div class="form-group">

                                  <label for="name" class="form-label">Phone Number</label>
                                  <div class="input-group mb-6">
                                      {{ Form::text('phone_number',null,['placeholder'=>'Phone Number','id'=>'phone_number','class'=>'form-control'])}}
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-6">
                              <div class="form-group">

                                  <label for="name" class="form-label">{{trans('message.admin_name_label')}}</label>
                                  <div class="input-group mb-6">
                                      {{ Form::text('username',null,['placeholder'=>trans('message.name_placeholder'),'id'=>'name','class'=>'form-control'])}}
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                    <label for="email" class="form-label">{{trans('message.email_address_label')}}</label>
                                    {{ Form::text('email',null,['placeholder'=>trans('message.email_placeholder'),'id'=>'email','class'=>'form-control'])}}
                               </div>
                          </div>
                                        
                                        @if(!isset($admin_user))
                                        <div class="col-md-6">
                                           <div class="form-group">
                                            <label for="password" class="form-label">{{trans('message.password_label')}}</label>
                                           {{ Form::text('password',null,['placeholder'=>trans('message.password_placeholder'),'id'=>'password','class'=>'form-control'])}}
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-md-6">
                                           <div class="form-group">
                                            <label for="inputState" class="form-label">{{trans('message.right_label')}}</label>
                                            {{ Form::select('right_id',\App\Models\Right::getRightDropDown(),null,['placeholder'=>trans('message.select_right_label'),'id'=>'inputState',"class"=>"form-select select2"])
                                            }}
                                          </div>
                                        </div>

                                        <div class="col-md-6">
                                           <div class="form-group">
                                            <label for="inputState" class="form-label">State</label>
                                            {{ Form::select('state',\App\Models\Right::getRightDropDown(),null,['placeholder'=>'State','id'=>'inputState1',"class"=>"form-select select2"])
                                            }}
                                          </div>
                                        </div>

                                        <div class="col-md-6">
                                           <div class="form-group">
                                            <label for="inputState" class="form-label">District</label>
                                            {{ Form::select('district',\App\Models\Right::getRightDropDown(),null,['placeholder'=>'District','id'=>'inputState2',"class"=>"form-select select2"])
                                            }}
                                          </div>
                                        </div>

                                        <div class="col-md-6">
                                           <div class="form-group">
                                            <label for="inputState" class="form-label">Taluk</label>
                                            {{ Form::select('taluk',\App\Models\Right::getRightDropDown(),null,['placeholder'=>'Taluk','id'=>'inputState3',"class"=>"form-select select2"])
                                            }}
                                          </div>
                                        </div>

                                        <div class="col-md-6">
                                           <div class="form-group">
                                            <label for="password" class="form-label">Address</label>
                                           {{ Form::textarea('address',null,['id'=>'address','class'=>'form-control'])}}
                                            </div>
                                        </div>
                                        
                                        
                                       @if(isset($admin_user))
                                        <div class="form-check">
                                                  {{ Form::checkbox('change_password',1,null,["class"=>"change_password form-check-input",'id'=>"flexCheckDefault"]) }}
                                                  <label class="form-check-label" for="flexCheckDefault">{{trans('message.change_password')}}</label>
                                        </div>
                                        <div class="col-md-6" style="display: none;" id="show_hide_password">
                                           <div class="form-group">
                                            <label for="password" class="form-label">{{trans('message.password_label')}}</label>
                                           {{ Form::password('password',['placeholder'=>trans('message.password_placeholder'),'id'=>'password','class'=>'form-control'])}}
                                         </div>
                                        </div>
                                        @endif

                               <hr>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary px-4">{{trans('message.save')}}</button>
                                            <a href="{{route('admin_user.index')}}" class="btn btn-secondary">{{trans('message.cancle')}}</a>
                                        </div>
                        </div>
                        
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('third_party_scripts')
  <script src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/plugins/select2/js/select2.min.js"></script>
  <script type="text/javascript">
    $('.select2').select2({
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
    });
  </script>
   <script>
     var loadFile = function(event) {
                            var output = document.getElementById('output');
                            output.src = URL.createObjectURL(event.target.files[0]);
                            console.log(output.src);
                            output.onload = function() {
                                URL.revokeObjectURL(output.src) // free memory
                            }
                        };
                        </script>
      <script type="text/javascript">
        $(document).on("click",".change_password",function(){

          if ($(".change_password").prop("checked")) {

             $("#show_hide_password").show();

          }else{

            $("#show_hide_password").hide();

          }
    });
      </script>
@endsection
