<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">
    <title>@yield('title'){{ env('APP_NAME') }}</title>
    <link rel="stylesheet" type="text/css" href="/{{ config('path.css') }}/fonts.css">
    <link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/jquery-ui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/{{ config('path.plugins') }}/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('cssFiles')
</head>

<body class="@yield('body-class')">
    <div class="wrapper">@yield('wrapper')</div>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/jquery/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/jquery-ui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/holder.js/2.9.0/holder.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/fancybox/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/icheck/1.0.2/icheck.min.js"></script>
    <script type="text/javascript"
        src="/{{ config('path.plugins') }}/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
        src="/{{ config('path.plugins') }}/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/moment.js/2.15.1/moment.min.js"></script>
    <script type="text/javascript"
        src="/{{ config('path.plugins') }}/datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/daterangepicker/2.1.24/daterangepicker.js"></script>
    <script type="text/javascript"
        src="/{{ config('path.plugins') }}/datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript"
        src="/{{ config('path.plugins') }}/timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/fastclick/1.0.6/fastclick.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/icheck/1.0.2/icheck.min.js"></script>
    <script type="text/javascript"
        src="/{{ config('path.plugins') }}/inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/slimscroll/1.3.8/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/selectpicker/bootstrap-select.js"></script>
    <script type="text/javascript" src="/{{ config('path.plugins') }}/sweetalert/sweetalert2.all.js"></script>

   <script type="text/javascript" src="/{{ config('path.themes.backend') }}/js/app.min.js"></script>
   <script type="text/javascript" src="/{{ config('path.js') }}/scripts.js"></script>
   <script type="text/javascript" src="/{{ config('path.plugins') }}/elFinder-2.1.48/js/elfinder.full.js"></script>

    <script>
        window.base_url = '{!! URL::to("/") !!}/';
        window.token = $('meta[name="csrf-token"]').attr('content');
        jQuery(document).ready(function () {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': window.token }
            });
        });
    </script>
    @yield('jsFiles')
</body>
</html>
