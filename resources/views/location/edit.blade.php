@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="content-header">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Location</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Location</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Location</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form method="post" action="{{ route('location.update', $location->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location Name</label>
                                    <div class="input-group mb-6">
                                        <input type="text" name="location" value="{{ $location->locationname }}" class="form-control @error('location') is-invalid @enderror" placeholder="Location Name">
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
                                        <option value="" disabled>Select Zone</option>
                                        <option value="North Zone" {{ $location->zone=="North Zone" ? 'selected' : '' }}>North Zone</option>
                                        <option value="East Zone" {{ $location->zone=="East Zone" ? 'selected' : '' }}>East Zone</option>
                                        <option value="West Zone" {{ $location->zone=="West Zone" ? 'selected' : '' }}>West Zone</option>
                                        <option value="South Zone" {{ $location->zone=="South Zone" ? 'selected' : '' }}>South Zone</option>
                                        <option value="Central Zone" {{ $location->zone=="Central Zone" ? 'selected' : '' }}>Central Zone</option>
                                        <option value="North East Zone" {{ $location->zone=="North East Zone" ? 'selected' : '' }}>North East Zone</option>
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
                            @php
                            $i = 0
                            @endphp
                            @foreach($locationdata as $old)
                            @if($i==0)
                            <br />
                            <h4>Location Details</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>State</label>
                                        <div class="input-group mb-6">
                                            <select id='state{{$i}}' name="multipleinput[{{$i}}][state]" onchange="getdistrict(this.id, 0)" class="form-control @error('state') is-invalid @enderror">
                                                <option value="" disabled>Select State</option>
                                                @foreach($state as $statedata)
                                                <option value='{{$statedata->state}}' {{ $old->state==$statedata->state ? 'selected' : '' }}>{{$statedata->state}}</option>
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
                                            <select id="district{{$i}}" name="multipleinput[{{$i}}][district]" onchange="getblock(this.id, 0)" class="form-control @error('district') is-invalid @enderror">
                                                <option value="" disabled>Select District</option>
                                                @foreach($district as $districtdata)
                                                <option value='{{ $districtdata->district }}' {{ $old->district==$districtdata->district ? 'selected' : '' }}>{{$districtdata->district}}</option>
                                                @endforeach
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
                                            <select id="taluk{{$i}}" name="multipleinput[{{$i}}][taluk]" onchange="getvillage(this.id, 0)" class="form-control @error('taluk') is-invalid @enderror">
                                                <option value="" disabled>Select Block</option>
                                                <option value='{{$old->taluk}}' selected>{{$old->taluk}}</option>
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
                                            <select id="village{{$i}}" name="multipleinput[{{$i}}][village]" onchange="setgeo(this.id,0)" class="form-control @error('village') is-invalid @enderror">
                                                <option value="" disabled>Select Village</option>
                                                <option value='{{$old->village}}' selected>{{$old->village}}</option>
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
                                <input type="hidden" value='{{$old->id}}' name="multipleinput[{{$i}}][id]" />
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Ward</label>
                                        <div class="input-group mb-6">
                                            <input id="ward{{$i}}" name="multipleinput[{{$i}}][ward]" onchange="setward(this.id,0)" class="form-control @error('ward') is-invalid @enderror" value="{{$old->ward}}" placeholder="Enter Ward" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>City</label>
                                        <div class="input-group mb-6">
                                            <input id="city{{$i}}" name="multipleinput[{{$i}}][city]" onchange="setcity(this.id,0)" class="form-control @error('city') is-invalid @enderror" value="{{$old->city}}" placeholder="Enter City" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <div class="input-group mb-6">
                                            <textarea class="form-control @error('address') is-invalid @enderror" id="address{{$i}}" name="multipleinput[{{$i}}][address]" rows="2" placeholder="Enter Address" onchange="getaddress(this.id,0)">{{$old->address}}</textarea>
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
                                        <input type="text" class="form-control" name="multipleinput[{{$i}}][lat]" id="lat{{$i}}" value="{{$old->lat}}" readonly />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Longitude</label>
                                        <input type="text" class="form-control" name="multipleinput[{{$i}}][long]" id="long{{$i}}" value="{{$old->long}}" readonly />
                                    </div>
                                </div>
                                <input type="hidden" value='{{$old->id}}' name="multipleinput[{{$i}}][id]" />
                            </div>
                            @php
                            $i++
                            @endphp
                            @else
                            <div id="location{{$i}}" class="locationname">
                                <br />
                                <h4>Next Location</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>State</label>
                                            <div class="input-group mb-6">
                                                <select id='state{{$i}}' name="multipleinput[{{$i}}][state]" onchange="getdistrict(this.id, '{{$i}}')" class="form-control @error('state') is-invalid @enderror">
                                                    <option value="" disabled>Select State</option>
                                                    @foreach($state as $statedata)
                                                    <option value='{{$statedata->state}}' {{ $old->state==$statedata->state ? 'selected' : '' }}>{{$statedata->state}}</option>
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
                                                <select id="district{{$i}}" name="multipleinput[{{$i}}][district]" onchange="getblock(this.id,'{{$i}}' )" class="form-control @error('district') is-invalid @enderror">
                                                    <option value="" disabled>Select District</option>
                                                    @foreach($district as $districtdata)
                                                    <option value='{{ $districtdata->district }}' {{ $old->district==$districtdata->district ? 'selected' : '' }}>{{$districtdata->district}}</option>
                                                    @endforeach
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
                                                <select id="taluk{{$i}}" name="multipleinput[{{$i}}][taluk]" onchange="getvillage(this.id, '{{$i}}')" class="form-control @error('taluk') is-invalid @enderror">
                                                    <option value="" disabled>Select Block</option>
                                                    <option value='{{$old->taluk}}' selected>{{$old->taluk}}</option>
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
                                                <select id="village{{$i}}" name="multipleinput[{{$i}}][village]" onchange="setgeo(this.id,'{{$i}}')" class="form-control @error('village') is-invalid @enderror">
                                                    <option value="" disabled>Select Village</option>
                                                    <option value='{{$old->village}}' selected>{{$old->village}}</option>
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
                                    <input type="hidden" value='{{$old->id}}' name="multipleinput[{{$i}}][id]" />
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <div class="input-group mb-6">
                                                <textarea class="form-control @error('address') is-invalid @enderror" id="address{{$i}}" name="multipleinput[{{$i}}][address]" rows="2" placeholder="Enter Address" onchange="getaddress(this.id,'{{$i}}')">{{$old->address}}</textarea>
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
                                            <input type="text" class="form-control" name="multipleinput[{{$i}}][lat]" id="lat{{$i}}" value="{{$old->lat}}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Longitude</label>
                                            <input type="text" class="form-control" name="multipleinput[{{$i}}][long]" id="long{{$i}}" value="{{$old->long}}" readonly />
                                        </div>
                                    </div>
                                    <input type="hidden" value='{{$old->id}}' name="multipleinput[{{$i}}][id]" />
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="deletediv" style="text-align:right;padding:10px;">
                                        <span class="text-danger" id="removeitem"><i class="far fa-trash-alt"></i> Delete this location</span>
                                    </div>
                                </div>
                            </div>
                            @php
                            $i++
                            @endphp
                            @endif
                            @endforeach
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
@include('scripts.editdynamiclocation')
@include('scripts.map')
@endsection