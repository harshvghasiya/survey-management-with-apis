@if(isset($survey_forms) && $survey_forms != null )

@foreach($survey_forms as $form)
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