@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Location</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Add Location</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Create Location</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form method="post" action="{{ route('location.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location Name</label>
                                    <div class="input-group mb-6">
                                        <input type="text" name="location" value="{{ old('location') }}" class="form-control @error('location') is-invalid @enderror" placeholder="Location Name">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><span class="fas fa-map-marker-alt"></span></div>
                                        </div>
                                        @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Zone</label>
                                <div class="input-group mb-6">
                                    <select id="zone" name="zone" class="form-control @error('zone') is-invalid @enderror">
                                        <option value="" selected disabled>Select Zone</option>
                                        <option value="North Zone">North Zone</option>
                                        <option value="East Zone">East Zone</option>
                                        <option value="West Zone">West Zone</option>
                                        <option value="South Zone">South Zone</option>
                                        <option value="Central Zone">Central Zone</option>
                                        <option value="North East Zone">North East Zone</option>
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span class="fas fa-map-pin"></span></div>
                                    </div>
                                    @error('zone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="dynamic" id="dynamic">
                            <br />
                            <h4>Location Details</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>State</label>
                                        <div class="input-group mb-6">
                                            <select id='state0' name="multipleinput[0][state]" onchange="getdistrict(this.id, 0)" class="form-control @error('state') is-invalid @enderror">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>District</label>
                                        <div class="input-group mb-6">
                                            <select id="district0" name="multipleinput[0][district]" onchange="getblock(this.id, 0)" class="form-control @error('district') is-invalid @enderror">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Block</label>
                                        <div class="input-group mb-6">
                                            <select id="taluk0" name="multipleinput[0][taluk]" onchange="getvillage(this.id, 0)" class="form-control @error('taluk') is-invalid @enderror">
                                                <option value="" selected disabled>Select Block</option>
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Village</label>
                                        <div class="input-group mb-6">
                                            <select id="village0" name="multipleinput[0][village]" onchange="setgeo(this.id,0)" class="form-control @error('village') is-invalid @enderror">
                                                <option value="" selected disabled>Select Village</option>
                                            </select>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="fas fa-map-marked-alt"></span></div>
                                            </div>
                                            @error('village')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Ward</label>
                                        <div class="input-group mb-6">
                                            <input id="ward0" name="multipleinput[0][ward]" onchange="setward(this.id,0)" class="form-control @error('ward') is-invalid @enderror" placeholder="Enter Ward" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>City</label>
                                        <div class="input-group mb-6">
                                            <input id="city0" name="multipleinput[0][city]" onchange="setcity(this.id,0)" class="form-control @error('city') is-invalid @enderror" placeholder="Enter City" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <div class="input-group mb-6">
                                            <textarea class="form-control @error('address') is-invalid @enderror" id="address0" name="multipleinput[0][address]" rows="2" placeholder="Enter Address" onchange="getaddress(this.id,0)"></textarea>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Laititude</label>
                                        <input type="text" class="form-control" name="multipleinput[0][lat]" id="lat0" readonly />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Longitude</label>
                                        <input type="text" class="form-control" name="multipleinput[0][long]" id="long0" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <input type="button" id="addItem" class="btn btn-primary form-control" value="Add New location" />
                            </div>
                        </div>

                        <br />
                        <div class="row">
                            <div class="col-md-12">
                                <div id="map" style="height:90vh;"></div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                            </div>
                            <div class="col-md-1">
                                    <a class="btn btn-default " href="{{route('location.index')}}" style="margin-right: 20px;">Cancel</a>
                            </div>
                            <div class="col-md-10"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@include('scripts.dynamiclocation')
@include('scripts.map')
@endsection