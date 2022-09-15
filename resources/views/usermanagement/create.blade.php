@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">New User</li>
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
                    <form method="post" action="{{ route('usermanagement.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>User Role</label>
                                    <div class="input-group mb-6">
                                        <select id="role" name="role" class="form-control  @error('role') is-invalid @enderror" required>
                                            <option value="" selected disabled>Select User Role</option>
                                            @foreach($userrole as $data)    
                                                <option value='{{$data->id}}'>{{$data->userrole}}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-user-cog"></span></div>
                                        </div>
                                        @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Username</label>
                                    <div class="input-group mb-6">
                                        <input type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Username">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-user-alt"></span></div>
                                        </div>
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Password</label>
                                <div class="input-group mb-6">
                                    <input type="password" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span class="fas fa-user-alt"></span></div>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <div class="input-group mb-6">
                                        <input type="text" name="firstname" value="{{ old('firstname') }}" class="form-control @error('firstname') is-invalid @enderror" placeholder="First Name">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-user-alt"></span></div>
                                        </div>
                                        @error('firstname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last name</label>
                                    <div class="input-group mb-6">
                                        <input type="text" name="lastname" value="{{ old('lastname') }}" class="form-control @error('lastname') is-invalid @enderror" placeholder="Last Name">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-user-alt"></span></div>
                                        </div>
                                        @error('lastname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <div class="input-group mb-6">
                                        <input type="tel"  pattern="[0-9]{2}" name="phonenumber" value="{{ old('phonenumber') }}" class="form-control @error('phonenumber') is-invalid @enderror" min="1"  placeholder="Phone Number">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-phone-alt"></span></div>
                                        </div>
                                        @error('phonenumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email-Id</label>
                                    <div class="input-group mb-6">
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email-Id">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>State</label>
                                    <div class="input-group mb-6">
                                        <select id="state" name="state" class="form-control @error('state') is-invalid @enderror">
                                            <option value="" selected disabled>Select State</option>
                                            @foreach($state as $statedata)    
                                                <option value='{{$statedata->state}}'>{{$statedata->state}}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-map-marked-alt"></span></div>
                                        </div>
                                        @error('state')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>District</label>
                                    <div class="input-group mb-6">
                                        <select id="district" name="district" class="form-control @error('district') is-invalid @enderror">
                                            <option value="" selected disabled>Select District</option>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-map-marked-alt"></span></div>
                                        </div>
                                        @error('district')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Taluk</label>
                                    <div class="input-group mb-6">
                                        <select id="taluk" name="taluk" class="form-control @error('taluk') is-invalid @enderror">
                                            <option value="" selected disabled>Select Taluk</option>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-map-marked-alt"></span></div>
                                        </div>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <div class="input-group mb-6">
                                        <textarea class="form-control" rows="2" name="address" placeholder="Enter Address"></textarea>
                                        @error('taluk')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <br />
                        <div class="row">
                            <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                            </div>
                            <div class="col-md-1">
                                    <a class="btn btn-default " href="{{route('usermanagement.index')}}" style="margin-right: 20px;">Cancel</a>
                            </div>
                            <div class="col-md-10"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@include('scripts.autofill')
@endsection
