<script>
    $(document).ready(function() {
        $("#submituserbutton").prop("disabled", true);
        var selectedform = [];
        for (var option of document.getElementById('userform').options) {
            if (option.selected) {
                selectedform.push(option.value);
            }
        }
        if (selectedform.length > 0) {
            userdata(selectedform);
        }
    });

    function userdata() {
        var selected = [];
        for (var option of document.getElementById('userform').options) {
            if (option.selected) {
                selected.push(option.value);
            }
        }
        // console.log(selected);
        // console.log("23 line usermodal")
        $("#submituserbutton").removeAttr('disabled');
        $.ajax({
            url: '/getuserdata/' + selected,
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

                    $("#userformdetails").empty();

                    output="<div class=col-md-12><table id=table class=table table-bordered table-striped table-hover><thead><tr><th>S.No.</th><th>Name</th><th>Username</th><th>User Role</th><th>Email</th><th>Phone Number</th><th>State</th><th>District</th><th>Taluk</th></tr></thead><tbody>";

                    for (var i = 0; i < len; i++) {
                        output=output+"<tr>";
                        output=output+"<td>";
                        output=output+(parseInt(i)+parseInt(1));
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['first_name']+" "+response[i]['last_name'];
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['username'];
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['userrole'];
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['email'];
                        output=output+"</td>";
                        output=output+"<td>";
                        output=output+response[i]['phone_number'];
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
                        output=output+"</tr>";
                    }
                    output=output+"</tbody></table></div>";
                    $("#userformdetails").append(output);
                }

            }
        });
    }
</script>