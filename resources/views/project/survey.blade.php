<form method="post" action="{{ route('project.updatesurvey',$id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Survey Form</label>
                <div class="input-group mb-6">
                    <select id="surveyform" name="surveyform[]" multiple="true" placeholder="Select Survey Form" class="survey_project_store select2survey form-control @error('surveyform') is-invalid @enderror" >
                        @foreach($survey as $data)
                            @php

                                if (isset($survey_selected) && $survey_selected != null && in_array($data->id, $survey_selected)) {
                                    $checked='selected';
                                }else{
                                    $checked="";
                                }
                            @endphp
                        <option value='{{$data->id}}' {{$checked}}>{{$data->surveyname}}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-clipboard-list"></span></div>
                    </div>
                    @error('surveyform')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <br />
    <div id="surveyformdetails">
          
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <button type="submit" id="submitbutton" class="btn btn-primary form-control">Update Survey</button>
            </div>
        </div>
    </div>
</form>
@include('scripts.surveymodal')
@include('scripts.multiple')
@if(isset($survey_selected) && $survey_selected != null)
<script type="text/javascript">
    $(document).ready(function() {
        $('#surveyform').trigger("change");
    });

</script>
@endif
