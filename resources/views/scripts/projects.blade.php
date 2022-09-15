<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<script src="https://unpkg.com/esri-leaflet@3.0.2/dist/esri-leaflet.js" integrity="sha512-myckXhaJsP7Q7MZva03Tfme/MSF5a6HC2xryjAM4FxPLHGqlh5VALCbywHnzs2uPoF/4G/QVXyYDDSkp5nPfig==" crossorigin=""></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="{{asset('css/easy-button.css')}}">
<script src="{{asset('js/easy-button.js')}}"></script>

<link rel="stylesheet" href="{{asset('css/L.Control.Locate.min.css')}}" />
<script src="{{asset('js/L.Control.Locate.js')}}"></script>

<script src="https://unpkg.com/esri-leaflet-vector/dist/esri-leaflet-vector-debug.js"></script>

<link rel="stylesheet" href="{{asset('css/leaflet-sidebar.css')}}" />

<script src="{{asset('js/leaflet-sidebar.js')}}"></script>

<script src="{{asset('js/1.4.1leaflet.markercluster.js')}}"></script>

<script type='text/javascript'>
    $(document).ready(function() {


        var project = document.getElementById('username').value;

        var marker = [];
        var mappoints = [];
        var maplines = [];
        var mappolygon = [];

        var markersnew = L.markerClusterGroup();
        var mappointsnew = L.markerClusterGroup();
        var maplinesnew = L.markerClusterGroup();
        var mappolygonnew = L.markerClusterGroup();

        var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });
        var map = L.map('projectmap').setView([23.4022766, 84.8113008], 5);
        // var layer = L.esri.basemapLayer('Topographic').addTo(map);
        // var layer = L.esri.basemapLayer('Topographic').addTo(map);
        googleStreets.addTo(map);

        L.easyButton('fa fa-home', function(btn, map) {
            map.setView([23.4022766, 84.8113008], 9 / 2);
        }).addTo(map);

        L.control.locate({
            icon: 'fa fa-location-arrow',
            drawCircle: false,
            follow: true,
            setView: true,
            initialZoomLevel: 15
        }).addTo(map);

        L.control.scale({
            position: 'bottomleft'
        }).addTo(map);

        markerClusters = L.markerClusterGroup({
            maxClusterRadius: 40
        });

        function dragElement(elmnt) {
            var pos1 = 0,
                pos2 = 0,
                pos3 = 0,
                pos4 = 0;
            // console.log(elmnt);
            // console.log(document.getElementById(elmnt.id + "header"));
            if (document.getElementById(elmnt.id + "header")) {
                /* if present, the header is where you move the DIV from:*/
                document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
            } else {
                /* otherwise, move the DIV from anywhere inside the DIV:*/
                elmnt.onmousedown = dragMouseDown;
            }

            function dragMouseDown(e) {
                e = e || window.event;
                //e.preventDefault();
                // get the mouse cursor position at startup:
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // call a function whenever the cursor moves:
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                e = e || window.event;
                e.preventDefault();
                // calculate the new cursor position:
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // set the element's new position:
                elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
                elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            }

            function closeDragElement() {
                /* stop moving when mouse button is released:*/
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }

        var selector = L.control({
            position: 'topright'
        });

        selector.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'mySelector');
            L.DomEvent.disableClickPropagation(div);
            div.innerHTML = '<div class="row" id="abs1" style="width:250px;margin: 0;background-color:white;position: absolute;z-index: 9;right:80px;"><div class="col-md-12" id="abs1header" style="padding:unset;cursor: move;z-index: 10;"><h5 style="font-size: 15px;padding:10px;background-color: #0d77b5;color: white;"><b>Plot Map Data</b><a  style="font-size:20px;padding:10px 0px;" class="closebtn" id="tabs1" href="javascript:void(0)" onclick="closeNaved(this.id)">&times;</a></h5><div style="padding-left:20px"><input type="checkbox" class="cb" onclick="" onchange="" value="projectlocation" id="projectlocation" checked><label style="font-size:15px;padding: 5px;" for="projectlocation">Project Locations</label><br><input type="checkbox" id="points" class="cb" onclick="" onchange="" value="points"><label style="font-size:15px;padding: 5px;" for="Points">Point Data</label><br><input type="checkbox" class="cb" onclick="" onchange="" value="line" id="line"><label style="font-size:15px;padding: 5px;" for="Line">Line Data</label><br><input type="checkbox" class="cb" onclick="" onchange="" value="polygon" id="polygon"><label style="font-size:15px;padding: 5px;" for="Polygon">Polygon Data</label><br></div></div></div>';
            return div;
        };
        selector.addTo(map);

        dragElement(document.getElementById("abs1"));

        var toggle = L.easyButton({
            states: [{
                stateName: 'add-markers',
                icon: 'fa-map-marker',
                title: 'add markers',
                onClick: function(control) {
                    $('#abs1').show();
                    $('#abs2').hide();
                    $('#abs3').hide();
                     toggle1.state('add-Basemap');
                     toggle2.state('add-layer');
                    control.state('remove-markers');
                }
            }, {
                icon: 'fa-undo',
                stateName: 'remove-markers',
                onClick: function(control) {
                    $('#abs1').hide();
                    control.state('add-markers');
                }
            }],
            position: 'topright'
        });
        toggle.addTo(map);


        var selector1 = L.control({
            position: 'topright'
        });

        selector1.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'mySelector');
            L.DomEvent.disableClickPropagation(div);
            div.innerHTML = '<div class="row" id="abs2" style="width:375px;margin: 0;background-color:white;position: absolute;z-index: 9;right:80px;"><div class="col-md-12" id="abs2header" style="padding:unset;cursor: move;z-index: 10;"><h5 style="font-size: 15px;padding:10px;background-color: #0d77b5;color: white;"><b>Basemap</b><a  style="font-size:20px;padding:10px 0px;" class="closebtn" id="tabs2" href="javascript:void(0)" onclick="closeNaved(this.id)">&times;</a></h5><div style="padding:5%;"><select id="basemaps" class="form-control"><option value="Topographic">Topographic</option><option value="Streets">Streets</option><option value="NationalGeographic">National Geographic</option><option value="Oceans">Oceans</option><option value="Gray">Gray</option><option value="DarkGray">Dark Gray</option><option value="Imagery">Imagery</option><option value="ImageryClarity">Imagery (Clarity)</option><option value="ImageryFirefly">Imagery (Firefly)</option><option value="ShadedRelief">Shaded Relief</option><option value="Physical">Physical</option><option value="googleStreets" selected>Google Streets</option></select></div></div></div>';
            return div;
        };

        selector1.addTo(map);
        dragElement(document.getElementById("abs2"));
        var toggle1 = L.easyButton({
            states: [{
                stateName: 'add-Basemap',
                icon: 'fa-th-large',
                title: 'Change Basemap',
                onClick: function(control) {
                    $('#abs2').show();
                    $('#abs1').hide();
                    $('#abs3').hide();
                    toggle.state('add-markers')
                    toggle2.state('add-layer')
                    control.state('remove-Basemap');
                }
            }, {
                icon: 'fa-undo',
                stateName: 'remove-Basemap',
                onClick: function(control) {
                    $('#abs2').hide();
                    control.state('add-Basemap');
                }
            }],
            position: 'topright'
        });
        toggle1.addTo(map);

        var selector2 = L.control({
            position: 'topright'
        });

        selector2.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'mySelector');
            L.DomEvent.disableClickPropagation(div);
            div.innerHTML = '<div class="row" id="abs3" style="width:225px;margin: 0;background-color:white;position: absolute;z-index: 9;right:80px;"><div class="col-md-12" id="abs3header" style="padding:unset;cursor: move;z-index: 10;"><h5 style="font-size: 15px;padding:10px;background-color: #0d77b5;color: white;"><b>Layer List</b><a  style="font-size:20px;padding:10px 0px;" class="closebtn" id="tabs3" href="javascript:void(0)" onclick="closeNaved(this.id)">&times;</a></h5><div style="padding-left: 20px;"><input type="checkbox" id="StateBoundary" value="StateBoundary"><label style="font-size:15px;padding: 5px;" for="StateBoundary">State Boundary</label><br><input type="checkbox" id="DistrictBoundary" value="DistrictBoundary"><label style="font-size:15px; padding: 5px;" for="DistrictBoundary">District Boundary</label><br><input type="checkbox" id="Boundaries2" value="Boundaries2"><label style="font-size:15px;padding: 5px;" for="Boundaries2">Sub Districts</label><br><input type="checkbox" id="Rails" value="Rails"><label style="font-size:15px;padding: 5px;" for="Rails">Rails</label><br><input type="checkbox" id="Roads" value="Roads"><label style="font-size:15px;padding: 5px;" for="Roads">Roads</label><br><input type="checkbox" id="WaterAreas" value="WaterAreas"><label style="font-size:15px;padding: 5px;" for="WaterAreas">Water Areas</label><br></div></div></div>';
            return div;
        };
        selector2.addTo(map);

        dragElement(document.getElementById("abs3"));

        var toggle2 = L.easyButton({
            states: [{
                stateName: 'add-layer',
                icon: 'fa-list-ul',
                title: 'Layer List',
                onClick: function(control) {
                    $('#abs3').show();
                    $('#abs1').hide();
                    $('#abs2').hide();

                    toggle.state('add-markers');
                    toggle1.state('add-Basemap');
                    control.state('remove-layer');
                }
            }, {
                icon: 'fa-undo',
                stateName: 'remove-layer',
                onClick: function(control) {
                    $('#abs3').hide();
                    control.state('add-layer');
                }
            }],
            position: 'topright'
        });
        toggle2.addTo(map);

        function setBasemap(basemap) {
            if (layer) {
                map.removeLayer(layer);
            }
            if (googleStreets) {
                map.removeLayer(googleStreets);
            }
            if (basemap === 'googleStreets') {
                googleStreets.addTo(map);
            } else {
                layer = L.esri.basemapLayer(basemap);

                map.addLayer(layer);

                if (layerLabels) {
                    map.removeLayer(layerLabels);
                }

                if (
                    basemap === 'ShadedRelief' ||
                    basemap === 'Oceans' ||
                    basemap === 'Gray' ||
                    basemap === 'DarkGray' ||
                    basemap === 'Terrain'
                ) {
                    layerLabels = L.esri.basemapLayer(basemap + 'Labels');
                    map.addLayer(layerLabels);
                } else if (basemap.includes('Imagery')) {
                    layerLabels = L.esri.basemapLayer('ImageryLabels');
                    map.addLayer(layerLabels);
                }
            }
        }

        document.querySelector('#basemaps').addEventListener('change', function(e) {
            var basemap = e.target.value;
            setBasemap(basemap);
        });

        $('#abs1').hide();
        $('#abs2').hide();
        $('#abs3').hide();
        $('#abs4').hide();

        $.ajax({
            url: '/getprojectlocations/' + project,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response['data']);
                for (var r = 0; r < response['data'].length; r++) {
                    var table = '<table class="table-responsive table-hover" style="width:100%;"><thead><tr><th class="pop_th">Data Type</th><th class="pop_th">Value</th></tr></thead><tbody><tr><td>Project Name: </td><td>' + response['data'][r]['project'] + '</td><tr><tr><td>Location Name: </td><td>' + response['data'][r]['location'] + '</td><tr><tbody></table>';
                    marker[r] = L.marker([response['data'][r]['lat'], response['data'][r]['long']]).bindPopup(table, {
                        maxWidth: 580
                    });

                    markersnew.addLayer(marker[r]);

                    marker[r].on('mouseover', function() {
                        this.openPopup();
                    });
                    marker[r].on('click', function() {
                        this.openPopup();
                    });
                    marker[r].on('mouseout', function() {
                        this.closePopup();
                    });
                }
                map.addLayer(markersnew);
            }
        });

        $.ajax({
            url: '/getprojectpoints/' + project,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response['data']);
                for (var r = 0; r < response['data'].length; r++) {

                    var split = response['data'][r]['latlong'].split(" ");

                    console.log(split);
                    var greenIcon = L.icon({
                        iconUrl: '../../img/pin.png',

                        iconSize: [55, 55], // size of the icon

                    });

                    mappoints[r] = L.marker([split[1], split[0]], {
                        icon: greenIcon
                    });

                    mappointsnew.addLayer(mappoints[r]);

                    mappoints[r].on('mouseover', function() {
                        this.openPopup();
                    });
                    mappoints[r].on('click', function() {
                        this.openPopup();
                    });
                    mappoints[r].on('mouseout', function() {
                        this.closePopup();
                    });
                }
            }
        });

        $.ajax({
            url: '/getprojectlines/' + project,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response['data']);
                for (var r = 0; r < response['data'].length; r++) {

                    var split = response['data'][r]['latlong'].split(",");

                    console.log(split);

                    var latlngs = [];

                    for (var g = 0; g < split.length; g++) {
                        var split2 = split[g].split(" ");

                        var newarry = [split2[1], split2[0]];

                        latlngs.push(newarry);
                    }

                    maplines[r] = L.polyline(latlngs, {
                        color: 'red'
                    });

                    maplinesnew.addLayer(maplines[r]);

                    maplines[r].on('mouseover', function() {
                        this.openPopup();
                    });
                    maplines[r].on('click', function() {
                        this.openPopup();
                    });
                    maplines[r].on('mouseout', function() {
                        this.closePopup();
                    });
                }
            }
        });

        $.ajax({
            url: '/getprojectpolygon/' + project,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response['data']);
                for (var r = 0; r < response['data'].length; r++) {

                    var split = response['data'][r]['latlong'].split(",");

                    console.log(split);

                    var latlngs = [];

                    for (var g = 0; g < split.length; g++) {
                        var split2 = split[g].split(" ");

                        var newarry = [split2[1], split2[0]];

                        latlngs.push(newarry);
                    }

                    mappolygon[r] = L.polygon(latlngs, {
                        color: 'blue'
                    });

                    mappolygonnew.addLayer(mappolygon[r]);

                    mappolygon[r].on('mouseover', function() {
                        this.openPopup();
                    });
                    mappolygon[r].on('click', function() {
                        this.openPopup();
                    });
                    mappolygon[r].on('mouseout', function() {
                        this.closePopup();
                    });
                }
            }
        });

        $('#projectlocation').click(function() {
            var checked = $(this).is(':checked');
            if (checked) {
                // map.removeLayer(mappointsnew);
                // map.removeLayer(maplinesnew);
                // map.removeLayer(mappolygonnew);

                map.addLayer(markersnew);

            } else {

                map.removeLayer(markersnew);

            }
        });

        $('#points').click(function() {
            var checked = $(this).is(':checked');
            if (checked) {
                // map.removeLayer(markersnew);
                // map.removeLayer(maplinesnew);
                // map.removeLayer(mappolygonnew);

                map.addLayer(mappointsnew);
            } else {
                map.removeLayer(mappointsnew);
            }
        });

        $('#line').click(function() {
            var checked = $(this).is(':checked');
            if (checked) {
                // map.removeLayer(markersnew);
                // map.removeLayer(mappointsnew);
                // map.removeLayer(mappolygonnew);

                map.addLayer(maplinesnew);
            } else {
                map.removeLayer(maplinesnew);
            }
        });

        $('#polygon').click(function() {
            var checked = $(this).is(':checked');
            if (checked) {
                // map.removeLayer(markersnew);
                // map.removeLayer(mappointsnew);
                // map.removeLayer(maplinesnew);

                map.addLayer(mappolygonnew);
            } else {
                map.removeLayer(mappolygonnew);
            }
        });

        $("#projectdropdown").change(function() {

            var marker = [];
            var mappoints = [];
            var maplines = [];
            var mappolygon = [];

            var markersnew = L.markerClusterGroup();
            var mappointsnew = L.markerClusterGroup();
            var maplinesnew = L.markerClusterGroup();
            var mappolygonnew = L.markerClusterGroup();

            var selected = [];
            for (var option of document.getElementById('projectdropdown').options) {
                if (option.selected) {
                    selected.push(option.value);
                }
            }

            var user = document.getElementById('username').value;

            $.ajax({
                url: '/getprojectlocationsbyproject/' + user + '/' + selected,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    console.log(response['data']);
                    for (var r = 0; r < response['data'].length; r++) {
                        var table = '<table class="table-responsive table-hover" style="width:100%;"><thead><tr><th class="pop_th">Data Type</th><th class="pop_th">Value</th></tr></thead><tbody><tr><td>Project Name: </td><td>' + response['data'][r]['project'] + '</td><tr><tr><td>Location Name: </td><td>' + response['data'][r]['location'] + '</td><tr><tbody></table>';
                        marker[r] = L.marker([response['data'][r]['lat'], response['data'][r]['long']]).bindPopup(table, {
                            maxWidth: 580
                        });

                        markersnew.addLayer(marker[r]);

                        marker[r].on('mouseover', function() {
                            this.openPopup();
                        });
                        marker[r].on('click', function() {
                            this.openPopup();
                        });
                        marker[r].on('mouseout', function() {
                            this.closePopup();
                        });
                    }
                    map.addLayer(markersnew);
                }
            });

            $.ajax({
                url: '/getprojectpointsbyproject/' + user + '/' + selected,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    console.log(response['data']);
                    for (var r = 0; r < response['data'].length; r++) {

                        var split = response['data'][r]['latlong'].split(" ");

                        console.log(split);
                        var greenIcon = L.icon({
                            iconUrl: '../../img/pin.png',

                            iconSize: [55, 55], // size of the icon

                        });

                        mappoints[r] = L.marker([split[1], split[0]], {
                            icon: greenIcon
                        });

                        mappointsnew.addLayer(mappoints[r]);

                        mappoints[r].on('mouseover', function() {
                            this.openPopup();
                        });
                        mappoints[r].on('click', function() {
                            this.openPopup();
                        });
                        mappoints[r].on('mouseout', function() {
                            this.closePopup();
                        });
                    }
                }
            });

            $.ajax({
                url: '/getprojectlinesbyproject/' + user + '/' + selected,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    console.log(response['data']);
                    for (var r = 0; r < response['data'].length; r++) {

                        var split = response['data'][r]['latlong'].split(",");

                        console.log(split);

                        var latlngs = [];

                        for (var g = 0; g < split.length; g++) {
                            var split2 = split[g].split(" ");

                            var newarry = [split2[1], split2[0]];

                            latlngs.push(newarry);
                        }

                        maplines[r] = L.polyline(latlngs, {
                            color: 'red'
                        });

                        maplinesnew.addLayer(maplines[r]);

                        maplines[r].on('mouseover', function() {
                            this.openPopup();
                        });
                        maplines[r].on('click', function() {
                            this.openPopup();
                        });
                        maplines[r].on('mouseout', function() {
                            this.closePopup();
                        });
                    }
                }
            });

            $.ajax({
                url: '/getprojectpolygonbyproject/' + user + '/' + selected,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    console.log(response['data']);
                    for (var r = 0; r < response['data'].length; r++) {

                        var split = response['data'][r]['latlong'].split(",");

                        console.log(split);

                        var latlngs = [];

                        for (var g = 0; g < split.length; g++) {
                            var split2 = split[g].split(" ");

                            var newarry = [split2[1], split2[0]];

                            latlngs.push(newarry);
                        }

                        mappolygon[r] = L.polygon(latlngs, {
                            color: 'blue'
                        });

                        mappolygonnew.addLayer(mappolygon[r]);

                        mappolygon[r].on('mouseover', function() {
                            this.openPopup();
                        });
                        mappolygon[r].on('click', function() {
                            this.openPopup();
                        });
                        mappolygon[r].on('mouseout', function() {
                            this.closePopup();
                        });
                    }
                }
            });

            $.ajax({
                url: '/getprojectsbyuserbyproject/' + user + '/' + selected,
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
                url: '/getsurveysbyuserbyproject/' + user + '/' + selected,
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
                url: '/gettotalprojectsusersbyproject/' + user + '/' + selected,
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
    });
</script>