@extends('layouts.app')
@section('title')
 @if($title != null && $title!= "")  {{$title}} |  @endif  {{trans('message.app_name')}}
@endsection
@section('third_party_stylesheets')

    <link href="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

@endsection
@section('content')

<div class="container">
    <div class="main-body">
         <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Profile</li>
            </ol>
          </nav>
      
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{UPLOAD_AND_DOWNLOAD_URL()}}/img/noimg.png" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4>{{\Auth::user()->first_name}} {{\Auth::user()->last_name}}</h4>
                      <p class="text-secondary mb-1">@if(isset(\Auth::user()->admin_right) && \Auth::user()->admin_right != null) {{\Auth::user()->admin_right->name}} @endif</p>
                      <p class="text-muted font-size-sm">{{\Auth::user()->address}}</p>
                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{\Auth::user()->first_name}} {{\Auth::user()->last_name}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{\Auth::user()->email}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{\Auth::user()->phone_number}}
                    </div>
                  </div>
                  <hr>
                  
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{\Auth::user()->address}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">District/State</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{\Auth::user()->district}}/{{\Auth::user()->state}}
                    </div>
                  </div>
                  <hr>
                  {{-- <div class="row">
                    <div class="col-sm-12">
                      <a class="btn btn-info " href="{{route('admin_user.profile_edit')}}">Edit Profile</a>
                    </div>
                  </div> --}}
                </div>
              </div>

              <div class="row gutters-sm">
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2"></i>Projects</h6>
                      @if(isset(\Auth::user()->user_projects) && \Auth::user()->user_projects != null )
                      @foreach(\Auth::user()->user_projects as $pro=>$project)
                      <small>{{$project->projects->projectname}}</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      @endforeach
                      @endif
                    
                    </div>
                  </div>
                </div>

              </div>



            </div>
          </div>

        </div>
    </div>

@endsection