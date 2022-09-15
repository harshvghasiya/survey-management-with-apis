<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/js/toaster/toastr.css">
    

</head>
<body class="hold-transition login-page" style="background: #efefef;">
<div class="login-box">
    <div class="login-logo">
        <!-- <a href="{{ url('/home') }}"><b>{{ config('app.name') }}</b></a> -->
    </div>
    <!-- /.login-logo -->

    <!-- /.login-box-body -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg" style="font-size:25px;font-weight:500;">INCLEN</p>

            <form method="post" class="FromSubmit" id="LoginUpdate" action="{{ route('admin.postlogin') }}">
                @csrf

                <div class="input-group mb-3">
                    <input type="username"
                           name="username"
                           value="{{ old('username') }}"
                           placeholder="Username"
                           class="form-control @error('username') is-invalid @enderror">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                    @error('username')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password"
                           name="password"
                           placeholder="Password"
                           class="form-control @error('password') is-invalid @enderror">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror

                </div>

                <div class="row">
                    <div class="col-8 mb-3">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">Remember Me</label>
                        </div>
                    </div>

                    @if(isset($setting->is_recaptcha) && $setting->is_recaptcha==1)
                        <div class="col-12">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        </div>
                    @endif

                    <div class="col-4 mt-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>

                </div>
            </form>

            <p class="mb-1">
                <a href="{{ route('admin.forgot_password_form') }}">I forgot my password</a>
            </p>
            <p class="mb-0">
                <!-- <a href="" class="text-center">Register a new membership</a> -->
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>

</div>
<!-- /.login-box -->

<script src="{{ mix('js/app.js') }}" defer></script>
  <script src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/js/jquery.min.js"></script>
    <script src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/js/pace.min.js"></script>

     <script src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/js/notify/bootstrap-notify.min.js"></script>
    <script src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/js/toaster/toastr.min.js"></script>

  <script src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/js/login_common.js"></script>
   
       @include('layouts.flashmessage')
    
    <script type="text/javascript">
        $(function(){
            function rescaleCaptcha(){
              var width = $('.g-recaptcha').parent().width();
              var scale;
              if (width < 302) {
                scale = width / 302;
              } else{
                scale = 1.0; 
              }

              $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
              $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
              $('.g-recaptcha').css('transform-origin', '0 0');
              $('.g-recaptcha').css('-webkit-transform-origin', '0 0');
            }

            rescaleCaptcha();
            $( window ).resize(function() { rescaleCaptcha(); });

        });
    </script>
    
</body>
</html>
