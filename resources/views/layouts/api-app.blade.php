<!DOCTYPE html>
<html>

    @include('layouts.sections.api-meta')   
    <body class="hold-transition skin-black-light sidebar-mini">
        <div class="wrapper">
          
                <div class="content-wrapper">
                      @include('layouts.sections.api-header')
                    @yield('content')
                </div> 
          
        </div>
    <!-- ./wrapper -->
    <!-- jQuery 3 -->

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/adminlte.min.js')}}"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- search option in dropdown -->
    <script src="{{asset('js/bootstrap-select.js')}}"></script>

    <!-- datetime picker -->
    <script src="{{asset('js/moment-with-locales.js')}}"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
    
    <!-- datetime picker -->
    {!! Toastr::render() !!}

    @yield('script')

    <script type="text/javascript">
        toastr.options.closeButton = true;
        toastr.options.escapeHtml = true;
        toastr.options.newestOnTop = false;
    </script>
<script src="{{asset('js/api-custom.js')}}"></script>
    </body>
</html>
