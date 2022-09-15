<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<script src="https://unpkg.com/esri-leaflet@3.0.2/dist/esri-leaflet.js" integrity="sha512-myckXhaJsP7Q7MZva03Tfme/MSF5a6HC2xryjAM4FxPLHGqlh5VALCbywHnzs2uPoF/4G/QVXyYDDSkp5nPfig==" crossorigin=""></script>

<script>
    var tempMarker = "";

    function getdistrict(stateid, l) {

        // Department id
        var state = document.getElementById(stateid).value;

        // Empty the dropdown
        $('#district' + l + '').find('option').not(':first').remove();
        $('#taluk' + l + '').find('option').not(':first').remove();

        var stateadd = state + ", India";
        document.getElementById('address' + l + '').value = stateadd;
        geo2(state, l);
        // AJAX request 
        $.ajax({
            url: '/getdistrict/' + state,
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

                        var name = response['data'][i].district;

                        var option = "<option value='" + name + "'>" + name + "</option>";

                        var dropdist = '#district' + l + '';
                        $(dropdist).append(option);
                    }
                }

            }
        });

        $.ajax({
            url: '/gettaluk/' + state,
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

                        var block = response['data'][i].block;

                        var option = "<option value='" + block + "'>" + block + "</option>";

                        $('#taluk' + l + '').append(option);
                    }
                }

            }
        });
    }

    function getblock(distid, l) {

        // Department id
        var state = $('#state' + l + '').val();
        var district = document.getElementById(distid).value;

        $('#taluk' + l + '').find('option').not(':first').remove();

        var search = '';

        if (state != '') {
            search = district + ", " + state + ", India";
        } else {
            search = district + ", India";
        }
        document.getElementById('address' + l + '').value = search;
        geo2(search, l);

        $.ajax({
            url: '/gettalukbydist/' + district + '/' + state,
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

                        var block = response['data'][i].block;

                        var option = "<option value='" + block + "'>" + block + "</option>";

                        $('#taluk' + l + '').append(option);
                    }
                }

            }
        });
    }

    function getvillage(talukid, l) {

        // Department id
        var state = $('#state' + l + '').val();
        var district = $('#district' + l + '').val();
        var taluk = document.getElementById(talukid).value;

        $('#village' + l + '').find('option').not(':first').remove();

        var search = '';
        if (state != '' && district != '') {
            search = taluk + ", " + district + ", " + state + ", India";
        } else if (state != '' && district == '') {
            search = taluk + ", " + state + ", India";
        } else if (state == '' && district != '') {
            search = taluk + ", " + district + ", India";
        } else {
            search = taluk + ", India";
        }
        document.getElementById('address' + l + '').value = search;
        geo2(search, l);

        $.ajax({
            url: '/getvillagebytaluk/' + taluk + '/' + district + '/' + state,
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

                        var block = response['data'][i].village;

                        var option = "<option value='" + block + "'>" + block + "</option>";

                        $('#village' + l + '').append(option);
                    }
                }

            }
        });
    }

    function setgeo(villageid, l) {
        var village = document.getElementById(villageid).value;
        var search = village + ", " + document.getElementById('address' + l + '').value;
        document.getElementById('address' + l + '').value = search;
        geo2(search, l);
    }

    function setward(wardid, l) {
        var ward = document.getElementById(wardid).value;
        var search = ward + ", " + document.getElementById('address' + l + '').value;
        document.getElementById('address' + l + '').value = search;
        geo2(search, l);
    }

    function setcity(cityid, l) {
        var city = document.getElementById(cityid).value;
        var search = city + ", " + document.getElementById('address' + l + '').value;
        document.getElementById('address' + l + '').value = search;
        geo2(search, l);
    }

    function getaddress(addressid, l) {
        var address = document.getElementById(addressid).value;
        geo2(address, l);
    }

    function onMapClick(e) {
        debugger;
        var elmId = $(".form-group input").last().attr("id");
        var m=elmId.replace("long","");
        var latlng = e.latlng;
        console.log(latlng)
        var latitude = latlng['lat'];
        var longitude = latlng['lng'];
        console.log(latitude);
        console.log(longitude);
        document.getElementById('lat'+m+'').value = latitude.toFixed(5);;
        document.getElementById('long'+m+'').value = longitude.toFixed(5);;
        if (tempMarker != "") {
            map.removeLayer(tempMarker);
        }
        var marker = L.marker([latitude, longitude]).addTo(map);
        tempMarker = marker;
    }

    var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    var map = L.map('map').setView([20.5937, 78.9629], 5);
    googleStreets.addTo(map);

    function geo(searchtext, l) {
        debugger;
        if (tempMarker != "") {
            map.removeLayer(tempMarker);
        }
        var settings = {
            "url": "https://www.mapquestapi.com/geocoding/v1/address?key=mU6zZwXY6x4YHsnfOywGdcl3gxWkqutx&inFormat=kvp&outFormat=json&location=" + searchtext + "&thumbMaps=false",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            "data": {
                "client_id": "DnlFgNLw0plsUlTJ",
                "client_secret": "a1ee763b4133491d964a38eb4b9bb157",
                "grant_type": "client_credentials"
            }
        };
        $.ajax(settings).done(function(response) {
            console.log(response);
            debugger
            var lat = response['results'][0]['locations'][0]['latLng']['lat'];
            var lng = response['results'][0]['locations'][0]['latLng']['lng'];

            document.getElementById('lat').value = lat;
            document.getElementById('long').value = lng;

            googleStreets.addTo(map);
            //var latLon = L.latLng(lat, lng);
            //var bounds = latLon.toBounds(500); // 500 = metres
            //map.panTo(latLon).fitBounds(bounds);

            map.setView(new L.LatLng(lat, lng), 15);
            //L.Marker.setLatLng(lat, lng).addTo(map);
            var marker = L.marker([lat, lng]).addTo(map);
            tempMarker = marker;

        });

    }

    function geo2(searchtext, l) {
        debugger;
        if (tempMarker != "") {
            map.removeLayer(tempMarker);
        }
        var settings = {
            "url": "https://www.mapquestapi.com/geocoding/v1/address?key=mU6zZwXY6x4YHsnfOywGdcl3gxWkqutx&inFormat=kvp&outFormat=json&location=" + searchtext + "&thumbMaps=false",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            "data": {
                "client_id": "DnlFgNLw0plsUlTJ",
                "client_secret": "a1ee763b4133491d964a38eb4b9bb157",
                "grant_type": "client_credentials"
            }
        };
        $.ajax(settings).done(function(response) {
            console.log(response);

            var lat = response['results'][0]['locations'][0]['latLng']['lat'];
            var lng = response['results'][0]['locations'][0]['latLng']['lng'];

            googleStreets.addTo(map);

            document.getElementById('lat' + l + '').value = lat;
            document.getElementById('long' + l + '').value = lng;
            //var latLon = L.latLng(lat, lng);
            //var bounds = latLon.toBounds(500); // 500 = metres
            //map.panTo(latLon).fitBounds(bounds);

            map.setView(new L.LatLng(lat, lng), 15);
            //L.Marker.setLatLng(lat, lng).addTo(map);
            // var marker = L.marker([lat, lng]).addTo(map);
            // tempMarker = marker;

        });

    }

    map.on('click', onMapClick);
</script>