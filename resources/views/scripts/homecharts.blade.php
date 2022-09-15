<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<link rel="stylesheet" href="{{asset('css/custom.css')}}" />

<script type='text/javascript'>
    $(document).ready(function() {
        var project = document.getElementById('username').value;
        $.ajax({
            url: '/getprojects/' + project,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var len = 0;
                if (response['data'] != null) {
                    len = response['data'].length;
                }

                if (len > 0) {
                    // Read data and create <option >
                    for (var i = 0; i < len; i++) {

                        var name = response['data'][i].projectname;
                        var id = response['data'][i].id;

                        var option = "<option value='" + id + "'>" + name + "</option>";

                        $("#projectdropdown").append(option);
                    }
                }

            }
        });

        $.ajax({
            url: '/getprojectsbyuser/' + project,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response['data']);
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable(response['data']);

                    var options = {
                        title: "",
                        pieHole: 0.7,
                        pieSliceBorderColor: "none",
                        legend: {
                            position: "bottom"
                        }
                    };

                    document.getElementById('totalcountprojects').innerHTML = response['count'];

                    var chart = new google.visualization.PieChart(document.getElementById('projectpie'));

                    chart.draw(data, options);
                }
            }
        });

        $.ajax({
            url: '/getsurveysbyuser/' + project,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response['data']);
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable(response['data']);

                    var options = {
                        title: "",
                        pieHole: 0.7,
                        pieSliceBorderColor: "none",
                        legend: {
                            position: "bottom"
                        }
                    };

                    document.getElementById('totalprojectsurveycount').innerHTML = response['count'];

                    var chart = new google.visualization.PieChart(document.getElementById('projectsurveypie'));

                    chart.draw(data, options);
                }
            }
        });

        $.ajax({
            url: '/gettotalprojectsusers/' + project,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable(response['data']);

                    var options = {
                        title: "",
                        pieHole: 0.7,
                        pieSliceBorderColor: "none",
                        legend: {
                            position: "bottom"
                        }
                    };

                    document.getElementById('totalusers').innerHTML = response['count'];

                    var chart = new google.visualization.PieChart(document.getElementById('projectuserspie'));

                    chart.draw(data, options);
                }
            }
        });
    });
</script>