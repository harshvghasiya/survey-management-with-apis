<form method="post" action="{{ route('project.updatelocation',$projects->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Select location</label>
                <div class="input-group">
                    <select id="locationform" name="locationform[]" class="form-control select2 @error('locationform') is-invalid @enderror" onchange="locationdata()" multiple="multiple" data-placeholder="Select a Location" data-dropdown-css-class="select2-red">
                        <option value="" disabled>Select locations</option>
                        @foreach($locations as $data)
                        @php
                        $flagvalue=0;
                        @endphp
                        @foreach($projectlocations as $projectlocationdata)
                        @if($data->id==$projectlocationdata->location_id)
                        @php
                        $flagvalue=1;
                        @endphp
                        @endif
                        @endforeach
                        @if($flagvalue==1)
                        <option value='{{$data->id}}' selected>{{$data->locationname}}</option>
                        @else
                        <option value='{{$data->id}}'>{{$data->locationname}}</option>
                        @endif
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-clipboard-list"></span></div>
                    </div>
                    @error('locationform')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <br />
    <div id="locationformdetails">

    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <button type="submit" id="submitlocationbutton" class="btn btn-primary form-control">Update Location</button>
            </div>
        </div>
    </div>
</form>
@include('scripts.locationmodal')
@include('scripts.multiple')