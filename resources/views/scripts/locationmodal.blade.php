<script>
    $(document).ready(function() {
        $("#submitlocationbutton").prop("disabled", true);
        var selectedform = [];
        for (var option of document.getElementById('locationform').options) {
            if (option.selected) {
                selectedform.push(option.value);
            }
        }
        if (selectedform.length > 0) {
            locationdata(selectedform);
        }
    });

    function locationdata() {
        var selected = [];
        for (var option of document.getElementById('locationform').options) {
            if (option.selected) {
                selected.push(option.value);
            }
        }
        // console.log(selected);
        $("#submitlocationbutton").removeAttr('disabled');
        $.ajax({
            url: '/getlocationdata/' + selected,
            type: 'get',
            dataType: 'json',
            success: function(response) {

                var len = 0;
                if (response != null) {
                    len = response.length;
                }
                // console.log(response);
                // console.log("24 line");

                if (len > 0) {
                    // Read data and create <option >
                    var output = "";
                    var type = "";
                    var options = "";

                    $("#locationformdetails").empty();

                    output="<div class=col-md-12><table id=table class=table table-bordered table-striped table-hover><thead><tr><th>S.No.</th><th>Location Name</th><th>State</th><th>District</th><th>Taluk</th><th>Village</th><th>Address</th></tr></thead><tbody>";

                    for (var i = 0; i < len; i++) {
                        output=output+"<tr>";
                        output=output+"<td>";
                        output=output+(parseInt(i)+parseInt(1));
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['locationname'];
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['state'];
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['district'];
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['taluk'];
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['village'];
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['address'];
                        output=output+"</td>";
                        output=output+"</tr>";
                    }
                    output=output+"</tbody></table></div>";
                    $("#locationformdetails").append(output);
                }

            }
        });
    }
</script>