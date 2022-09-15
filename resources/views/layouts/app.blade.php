<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
       @include('layouts.header')
        @include('layouts.sidebar')
        <div class="content-wrapper">
            <section class="content" style="background: #efefef;">
                @yield('content')
            </section>
        </div>
       @include('layouts.footer')
    </div>
@include('layouts.javascript')
@yield('third_party_scripts')
@stack('page_scripts')
@include('layouts.flashmessage')
</body>

</html>