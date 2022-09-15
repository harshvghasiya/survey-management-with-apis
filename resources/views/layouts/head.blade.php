<head>
    <meta charset="UTF-8">
    <title>@yield('title') {{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/js/toaster/toastr.css">
    
    <link rel="stylesheet" type="text/css" href="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/css/sweetalert2.css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
      <style type="text/css" media="screen">
        #removeitem{
            cursor: pointer !important;
        }    
      </style>
    
    @yield('third_party_stylesheets')

    @stack('page_css')
</head>