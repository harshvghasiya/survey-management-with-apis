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
              <li class="breadcrumb-item active" aria-current="page">Edit User Profile</li>
            </ol>
          </nav>
      <div class="row">
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                <div class="mt-3">
                  <h4>{{\Auth::user()->first_name}} {{\Auth::user()->last_name}}</h4>
                  <p class="text-secondary mb-1">@if(isset(\Auth::user()->admin_right) && \Auth::user()->admin_right != null) {{\Auth::user()->admin_right->name}} @endif</p>
                  <p class="text-muted font-size-sm">{{\Auth::user()->address}}</p>
                 
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-sm-3">
                  <h6 class="mb-0">First Name</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input type="text" name="first_name" class="form-control" value="{{\Auth::user()->first_name}}">
                </div>
              </div> 
              <div class="row mb-3">
                <div class="col-sm-3">
                  <h6 class="mb-0">Last Name</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input type="text" name="last_name" class="form-control" value="{{\Auth::user()->last_name}}">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3">
                  <h6 class="mb-0">Email</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input type="text" name="email" class="form-control" value="{{\Auth::user()->email}}">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3">
                  <h6 class="mb-0">Phone</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input type="text" name="phone_number" class="form-control" value="{{\Auth::user()->phone_number}}">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3">
                  <h6 class="mb-0">Address</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input type="text" name="address" class="form-control" value="{{\Auth::user()->address}}">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9 text-secondary">
                  <input type="button" class="btn btn-primary px-4" value="Save Changes">
                </div>
              </div>
            </div>
          </div>
         
        </div>
      </div>
    </div>
  </div>

@endsection