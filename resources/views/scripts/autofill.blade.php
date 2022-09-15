<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type='text/javascript'>
    $(document).ready(function() {

        // Department Change
        $('#state').change(function() {

            // Department id
            var state = $(this).val();

            // Empty the dropdown
            $('#district').find('option').not(':first').remove();
            $('#taluk').find('option').not(':first').remove();

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

                            $("#district").append(option);
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

                            $("#taluk").append(option);
                        }
                    }

                }
            });
        });

        $('#district').change(function() {

            // Department id
            var state = $('#state').val();
            var district = $(this).val();

            $('#taluk').find('option').not(':first').remove();

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

                            $("#taluk").append(option);
                        }
                    }

                }
            });
        });

        $('#taluk').change(function() {

            // Department id
            var state = $('#state').val();
            var district = $('#district').val();
            var taluk = $(this).val();

            $('#village').find('option').not(':first').remove();

            $.ajax({
                url: '/getvillagebytaluk/' + taluk + '/' + district + '/' + state ,
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

                            $("#village").append(option);
                        }
                    }

                }
            });
        });
    });
</script>