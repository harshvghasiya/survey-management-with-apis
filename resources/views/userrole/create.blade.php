@extends('layouts.app')

@section('content')
<!-- <link rel="stylesheet" href="{{asset('css/icheck-bootstrap.min.css')}}"> -->
<div class="container-fluid">
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New User Role</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">New User Role</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">User Role</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form method="post" action="{{ route('userrole.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>User Role</label>
                                    <div class="input-group mb-6">
                                        <input type="text" name="userrole" value="{{ old('userrole') }}" class="form-control @error('userrole') is-invalid @enderror" placeholder="User Role Name">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-user-cog"></span></div>
                                        </div>
                                        @error('userrole')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Admin Rights</label>
                                    <div class="input-group mb-6">
                                        <select id="adminrights" name="adminrights" class="form-control role_edit @error('adminrights') is-invalid @enderror">
                                            <option value="No"selected >No</option>
                                            <option value="Yes" >Yes</option>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-user-alt"></span></div>
                                        </div>
                                        @error('adminrights')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                        @foreach($pages as $pagedata)
                            <div class="row">
                                <div class="col-md-3">
                                    <span style="position: absolute;top: 25%;">
                                        {{$pagedata->pagename}}
                                    </span>
                                    <input type="hidden" id="pagename[]" name="pagename[]" value="{{$pagedata->new}}"/>
                                </div>
                                <div class="col-md-2" style="text-align: center;">
                                    <label for="checkboxPrimary2">
                                        Read
                                    </label>
                                    <br />
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="select_checkbox_value" id="checkboxPrimary2  read{{$pagedata->new}}" name="read{{$pagedata->new}}"  data-bootstrap-switch>
                                    </div>
                                </div>
                                <div class="col-md-2" style="text-align: center;">
                                    <label for="checkboxPrimary2 ">
                                        Write
                                    </label>
                                    <br />
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="select_checkbox_value" id="checkboxPrimary2 write{{$pagedata->new}}" name="write{{$pagedata->new}}"   data-bootstrap-switch >
                                    </div>
                                </div>
                                <div class="col-md-2" style="text-align: center;">
                                    <label for="checkboxPrimary2">
                                        Edit
                                    </label>
                                    <br />
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="select_checkbox_value" id="checkboxPrimary2 edit{{$pagedata->new}}" name="edit{{$pagedata->new}}"  data-bootstrap-switch>
                                    </div>
                                </div>
                                <div class="col-md-2" style="text-align: center;">
                                    <label for="checkboxPrimary2">
                                        Delete
                                    </label>
                                    <br />
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" class="select_checkbox_value" id="checkboxPrimary2 delete{{$pagedata->new}}" name="delete{{$pagedata->new}}"  data-bootstrap-switch>
                                    </div>
                                </div>

                            </div>
                            <br/>
                        @endforeach

                        <br />
                        <div class="row">
                            <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                            </div>
                            <div class="col-md-1">
                                    <a class="btn btn-default " href="{{route('userrole.index')}}" style="margin-right: 20px;">Cancel</a>
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
@endsection
@section('third_party_scripts')

<script>
    $(document).ready(function() {
         $('.role_edit').change(function(){
            check_uncheck_data($(this).val())
        });

        function check_uncheck_data(rol_val){
            if (rol_val== 'Yes') {
                $(".bootstrap-switch-undefined").removeClass('bootstrap-switch-off bootstrap-switch-on');
                $('.bootstrap-switch-container').attr('style', 'width: 132px; margin-left: 0px;');
                $('.select_checkbox_value').prop('checked',true);
            }
            else{
            $(".bootstrap-switch-undefined").addClass("bootstrap-switch-off bootstrap-switch-on");
                $('.bootstrap-switch-container').attr('style', 'width: 132px; margin-left: -44px;');
                $('.select_checkbox_value').prop('checked',false);


          }
        }
    });
</script>
@endsection