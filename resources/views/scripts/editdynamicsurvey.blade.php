<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function showhideoptions(value, number){
        debugger;
        if(value=="text"){
            $("#dynamicquestions"+number).empty();
            $("#dynamicquestions"+number).append('<div class="row"><div class="col-md-4"><input class="form-control" id="'+value+number+'" name="multipleinput['+number+']['+value+']" placeholder="Textbox" /></div></div>');
        }
        if(value=="number"){
            $("#dynamicquestions"+number).empty();
            $("#dynamicquestions"+number).append('<div class="row"><div class="col-md-4"><input class="form-control" type="number" id="'+value+number+'" name="multipleinput['+number+']['+value+']" placeholder="Total Size (i.e. Max numbers allowed)"/></div></div>');
        }
        if(value=="trueorfalse"){
            $("#dynamicquestions"+number).empty();
            $("#dynamicquestions"+number).append('<div class="row"><div class="col-md-4"><select class="form-control" id="'+value+number+'" name="multipleinput['+number+']['+value+']"><option selected >The Following are the options</option><option value="No" >No</option><option value="Yes" >Yes</option></select></div></div>');
        }
        if(value=="multichoiceoneans"){
            $("#dynamicquestions"+number).empty();
            $("#dynamicquestions"+number).append('<div class="row"><div class="col-md-6"><input class="form-control" id="option0'+value+number+'" name="multipleinput['+number+'][option0'+value+']" placeholder="option 1"/></div><div class="col-md-6"><input class="form-control" id="option1'+value+number+'" name="multipleinput['+number+'][option1'+value+']" placeholder="option 2"/></div><br/><br/><br/><div class="col-md-6"><input class="form-control" id="option2'+value+number+'" name="multipleinput['+number+'][option2'+value+']" placeholder="option 3"/></div><div class="col-md-6"><input class="form-control" id="option3'+value+number+'" name="multipleinput['+number+'][option3'+value+']" placeholder="option 4"/></div></div>');
        }
        if(value=="multichoicemultians"){
            $("#dynamicquestions"+number).empty();
            $("#dynamicquestions"+number).append('<div class="row"><div class="col-md-6"><input class="form-control" id="option0'+value+number+'" name="multipleinput['+number+'][option0'+value+']" placeholder="option 1"/></div><div class="col-md-6"><input class="form-control" id="option1'+value+number+'" name="multipleinput['+number+'][option1'+value+']" placeholder="option 2"/></div><br/><br/><br/><div class="col-md-6"><input class="form-control" id="option2'+value+number+'" name="multipleinput['+number+'][option2'+value+']" placeholder="option 3"/></div><div class="col-md-6"><input class="form-control" id="option3'+value+number+'" name="multipleinput['+number+'][option3'+value+']" placeholder="option 4"/></div></div>');
        }
    }

    function databasecolumn(value,number){
        debugger;
        var outvalue=value.replace(/ /g,"_");
        $("#dbcolumn"+number).val(outvalue);
    }
    var s = 1000;
    $("#addItem").click(function () {
        debugger;
        ++s;
        var add=s+1;
        $("#dynamic").append('<div id="survey'+s+'" class="surveyname"><br /><h4>Next Question</h4><hr><div class="row"><div class="col-md-7"><label>Question</label></div><div class="col-md-3"><label>Question Type</label></div><div class="col-md-2" style="text-align:center;"><label>Mandatory</label></div></div><div class="row"><div class="col-md-7"><div class="form-group"><div class="input-group mb-6"><input type="text" id="question'+s+'" name="multipleinput['+s+'][question]" class="form-control" placeholder="Question" onchange="databasecolumn(this.value,'+s+')"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group mb-6"><select id="questiontype'+s+'" name="multipleinput['+s+'][questiontype]" class="form-control" onchange="showhideoptions(this.value,'+s+')"><option value="" selected >Choose Question Type</option><option value="text">Text</option><option value="number">Number</option><option value="trueorfalse">True or False</option><option value="multichoiceoneans">Mutliple choice with one answer</option><option value="multichoicemultians">Mutliple choice with Multiple answer</option></select></div></div></div><div class="col-md-2" style="text-align:center;"><div class="icheck-primary d-inline"><input type="checkbox" id="checkboxPrimary'+s+'" name="multipleinput['+s+'][mandatory]"><label for="checkboxPrimary'+s+'"></label></div></div><div class="col-md-12"><label style="padding-left: 10px;">Database column</label></div><div class="col-md-4"><input type="text" id="dbcolumn'+s+'" class="form-control" name="multipleinput['+s+'][dbcolumn]" placeholder="Database column" /></div><div class="col-md-12"><br/><label style="padding-left: 10px;">Answers</label> </div><div id="dynamicquestions'+s+'" class="col-md-12"><br/></div></div><div class="col-md-12" id="deletediv" style="text-align:right;padding:10px;"><span class="text-danger" id="removeitem"><i class="far fa-trash-alt"></i> Delete this Question</span></div></div>');
        switchmethod();
    });
    $(document).on('click', '#removeitem', function () {
        $(this).closest('.surveyname').remove();
    });
</script>