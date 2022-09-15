<form method="post" action="{{ route('project.updateusers',$projects->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Select User</label>
                <div class="input-group">
                    <select id="userform" name="userform[]" class="form-control select2 @error('userform') is-invalid @enderror" onchange="userdata()" multiple="multiple" data-placeholder="Select a User" data-dropdown-css-class="select2-red">
                        <option value="" disabled>Select Users</option>
                        @foreach($userdata as $data)
                        @php
                        $flaguser=0;
                        @endphp
                        @foreach($projectusers as $projectusersdata)
                        @if($data->id==$projectusersdata->user_id)
                        @php
                        $flaguser=1;
                        @endphp
                        @endif
                        @endforeach
                        @if($flaguser==1)
                        <option value='{{$data->id}}' selected>{{$data->first_name}} {{$data->last_name}}</option>
                        @else
                        <option value='{{$data->id}}'>{{$data->first_name}} {{$data->last_name}}</option>
                        @endif
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-clipboard-list"></span></div>
                    </div>
                    @error('userform')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <br />
    <div id="userformdetails">

    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <button type="submit" id="submituserbutton" class="btn btn-primary form-control">Update users</button>
            </div>
        </div>
    </div>
</form>
@include('scripts.usermodal')
@include('scripts.multiple')