@php
$i = 0
@endphp
@foreach($surveydata as $old)
<div class="row">
    <div class="col-md-7">
        <label>Question</label>
    </div>
    <div class="col-md-3">
        <label>Question Type</label>
    </div>
    <div class="col-md-2" style="text-align:center;">
        <label>Mandatory</label>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="form-group">

            <div class="input-group mb-6">
                <input type="text" id="question0" name="multipleinput[{{$i}}][question]" value="{{ $old->question }}" class="form-control @error('ques1') is-invalid @enderror" placeholder="Question" readonly>
                @error('ques1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <!-- <label>Email-Id</label> -->
            <div class="input-group mb-6">
                <select id="questiontype0" name="multipleinput[{{$i}}][questiontype]" class="form-control @error('questiontype') is-invalid @enderror" onchange="showhideoptions(this.value,'{{$i}}')" readonly>
                    <option value="" disabled>Choose Question Type</option>
                    <option value="text" {{ $old->question_type=='text' ? 'selected' : '' }}>Text</option>
                    <option value="number" {{ $old->question_type=='number' ? 'selected' : '' }}>Number</option>
                    <option value="trueorfalse" {{ $old->question_type=='trueorfalse' ? 'selected' : '' }}>True or False</option>
                    <option value="multichoiceoneans" {{ $old->question_type=='multichoiceoneans' ? 'selected' : '' }}>Mutliple choice with one answer</option>
                    <option value="multichoicemultians" {{ $old->question_type=='multichoicemultians' ? 'selected' : '' }}>Mutliple choice with Multiple answer</option>
                </select>

                @error('questiontype')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-2" style="text-align:center;">
        <div class="icheck-primary d-inline">
            <label>
                @if($old->required==1)
                Yes
                @elseif($old->required==0)
                No
                @endif
            </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label>Answers</label>
    </div>
</div>

<div class="row">
    <div id="dynamicquestions{{$i}}" class="col-md-12">
        @if($old->question_type=='text')
        <div class="row">
            <div class="col-md-4">
                <input class="form-control" id="{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][{{$old->question_type}}]" placeholder="Textbox" readonly value="{{$old->text}}" />
            </div>
        </div>

        @elseif($old->question_type=='number')
        <div class="row">
            <div class="col-md-4">
                <input class="form-control" type="number" id="{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][{{$old->question_type}}]" value="{{$old->size}}" placeholder="Total Size (i.e. Max numbers allowed)" readonly />
            </div>
        </div>

        @elseif($old->question_type=='trueorfalse')
        <div class="row">
            <div class="col-md-4">
                <select class="form-control" id="{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][{{$old->question_type}}]" readonly>
                    <option selected disabled>The Following are the options</option>
                    <option value="0" disabled="true" @if($old->true_false==0) selected="true" @endif>No</option>
                    <option value="1" disabled="true" @if($old->true_false==1) selected="true" @endif>Yes</option>
                </select>
            </div>
        </div>

        @elseif($old->question_type=='multichoiceoneans')
        <div class="row">
            <div class="col-md-6">
                <input class="form-control" id="option0{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option0{{$old->question_type}}]" value="{{$old->option1}}" placeholder="option 1" readonly />
            </div>
            <div class="col-md-6">
                <input class="form-control" id="option1{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option1{{$old->question_type}}]" value="{{$old->option2}}" placeholder="option 2" readonly />
            </div>
            <br /><br /><br />
            <div class="col-md-6">
                <input class="form-control" id="option2{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option2{{$old->question_type}}]" value="{{$old->option3}}" placeholder="option 3" readonly />
            </div>
            <div class="col-md-6">
                <input class="form-control" id="option3{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option3{{$old->question_type}}]" value="{{$old->option4}}" readonly />
            </div>
        </div>

        @elseif($old->question_type=='multichoicemultians')
        <div class="row">
            <div class="col-md-6">
                <input class="form-control" id="option0{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option0{{$old->question_type}}]" value="{{$old->option1}}" placeholder="option 1" readonly />
            </div>
            <div class="col-md-6">
                <input class="form-control" id="option1{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option1{{$old->question_type}}]" value="{{$old->option2}}" placeholder="option 2" readonly />
            </div>
            <br /><br /><br />
            <div class="col-md-6">
                <input class="form-control" id="option2{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option2{{$old->question_type}}]" value="{{$old->option3}}" placeholder="option 3" readonly />
            </div>
            <div class="col-md-6">
                <input class="form-control" id="option3{{$old->question_type}}{{$i}}" name="multipleinput[{{$i}}][option3{{$old->question_type}}]" value="{{$old->option4}}" readonly />
            </div>
        </div>
        @endif
        <br />
    </div>
</div>
</div>
@php
$i++
@endphp
@endforeach
@include('scripts.switch')