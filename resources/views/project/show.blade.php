<div class="row">
    <div class="col-md-12">
        <h4>Project Details</h4>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-md-4">
        <h6>Project Name</h6>
        <lable>{{$project->projectname}}</lable>
    </div>
    <div class="col-md-4">
        <h6>Timeline</h6>
        <lable>{{$project->startdate}} - {{$project->enddate}}</lable>
    </div>

    <div class="col-md-4">
        <h6>Project Category</h6>
        <lable>@if(isset($project->project_categories) && $project->project_categories != null) {{$project->project_categories->category}} @endif</lable>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-4">
        <h6>Project Estimation</h6>
        <lable>{{$project->projectestimation}}</lable>
    </div>
    <div class="col-md-4">
        <h6>Project Target Benificiaries</h6>
        <lable>{{$project->targetbeneficiaries}}</lable>
    </div>
    <div class="col-md-4">
        <h6>Project Description</h6>
        <lable>{{$project->description}}</lable>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-md-12">
        <h4>Survey Details</h4>
    </div>
</div>
<hr />

@if(isset($project->project_surveys) && $project->project_surveys != null )
@foreach($project->project_surveys as $ke=>$val)
@if(isset($val->survey) && $val->survey != null && isset($val->survey->survey_form) && $val->survey->survey_form != null)
@foreach($val->survey->survey_form as $form)
<div class="row">
    <div class="col-md-7">
        <h6>Question</h6>
        <label>{{$form->question}}</label>
    </div>
    <div class="col-md-3">
        <h6>Question Type</h6>
        @if($form->question_type=='text')
        <label>Text Field</label>
        @elseif($form->question_type=='number')
        <label>Number Field</label>
        @elseif($form->question_type=='trueorfalse')
        <label>True or False</label>
        @elseif($form->question_type=='multichoiceoneans')
        <label>Single Select Dropdown</label>
        @elseif($form->question_type=='multichoicemultians')
        <label>Multi Select Dropdown</label>
        @endif
    </div>
    <div class=col-md-2>
        <h6>Required</h6>
        <label>{{$form->required}}</label>
    </div>
</div>
<br />
<div class="row">

    @if($form->question_type=='text')

    @elseif($form->question_type=='number')
    <div class="col-md-12">
        <h6>Options</h6>
    </div>
    <div class="col-md-4">
        <label>Maximum size : {{$form->size}}</label>
    </div>

    @elseif($form->question_type=='trueorfalse')
    <div class="col-md-12">
        <h6>Options</h6>
    </div>
    <div class="col-md-2">
        <label>Yes</label>
    </div>
    <div class="col-md-2">
        <label>No</label>
    </div>

    @elseif($form->question_type=='multichoiceoneans')
    <div class="col-md-12">
        <h6>Options</h6>
    </div>
    <div class=col-md-3>
        <label>{{$form->option1}}</label>
    </div>
    <div class=col-md-3>
        <label>{{$form->option2}}</label>
    </div>
    <div class="col-md-6"></div>
    <div class=col-md-3>
        <label>{{$form->option3}}</label>
    </div>
    <div class=col-md-3>
        <label>{{$form->option4}}</label>
    </div>
    <div class="col-md-6"></div>

    @elseif($form->question_type=='multichoicemultians')
    <div class="col-md-12">
        <h6>Options</h6>
    </div>
    <div class=col-md-3>
        <label>{{$form->option1}}</label>
    </div>
    <div class=col-md-3>
        <label>{{$form->option2}}</label>
    </div>
    <div class="col-md-6"></div>
    <div class=col-md-3>
        <label>{{$form->option3}}</label>
    </div>
    <div class=col-md-3>
        <label>{{$form->option4}}</label>
    </div>
    <div class="col-md-6"></div>

    @endif

</div>

<br /><hr>
@endforeach
@endif
@endforeach
@endif
<hr />
<div class="row">
    <div class="col-md-12">
        <h4>Project Location Details</h4>
    </div>
</div>
<hr />
<div class="row">
    <div class=col-md-12>
        <table id="table" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Location Name</th>
                    <th>State</th>
                    <th>District</th>
                    <th>Taluk</th>
                    <th>Village</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($project->project_locations) && $project->project_locations != null)
                @foreach($project->project_locations as $locationdata)
                @if(isset($locationdata->locations) && $locationdata->locations != null)
                @if(isset($locationdata->locations->location_single) && $locationdata->locations->location_single != null)
                @foreach($locationdata->locations->location_single as $key=>$val)
                <tr>
                    <td>{{$locationdata->locations->locationname}}</td>
                    <td>{{$val->state}}</td>
                    <td>{{$val->district}}</td>
                    <td>{{$val->taluk}}</td>
                    <td>{{$val->village}}</td>
                    <td>{{$val->address}}</td>
                </tr>
                @endforeach
                @endif
                @endif
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-md-12">
        <h4>User Details</h4>
    </div>
</div>
<hr />
<div class="row">
    <div class=col-md-12>
        <table id=table class=table table-bordered table-striped table-hover>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>User Role</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>State</th>
                    <th>District</th>
                    <th>Taluk</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($project->project_users) && $project->project_users != null)
                @foreach($project->project_users as $userdata)
                @if(isset($userdata->users) && $userdata->users != null)
                <tr>
                    <td>{{$userdata->users->first_name}} {{$userdata->users->last_name}}</td>
                    <td>{{$userdata->users->username}}</td>
                    <td>@if(isset($userdata->users->admin_right) && $userdata->users->admin_right != null) {{$userdata->users->admin_right->name}} @endif</td>
                    <td>{{$userdata->users->email}}</td>
                    <td>{{$userdata->users->phone_number}}</td>
                    <td>{{$userdata->users->state}}</td>
                    <td>{{$userdata->users->district}}</td>
                    <td>{{$userdata->users->taluk}}</td>
                </tr>
                @endif
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>