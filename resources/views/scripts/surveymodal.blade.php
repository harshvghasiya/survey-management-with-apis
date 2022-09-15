{{-- @author Harsh V. --}}
<script>
    $(document).ready(function(){
        $('.survey_project_store').change(function(event) {
            var survey_id = $(".survey_project_store :selected").map((_, e) => e.value).get();
            $.ajax({
                url: "{{route('project.get_survey_data')}}",
                type: 'post',
                data:{survey_id:survey_id},
                success: function(response) {
                    $('#surveyformdetails').html(response);
                }
            });
        });
    });
  
</script>