<!DOCTYPE html>
<html dir="ltr" lang="en">

    @include('layouts.sections.api-meta')

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->

        @include('layouts.sections.api-header')

       
        
        @yield('content')
      

    </div>
    <!-- <div class="page-wrapper">
         @include('layouts.sections.eclipse-footer')
 </div> -->
     <script src="{{ url('/') }}/assets/libs/jquery/dist/jquery.min.js"></script>
    
    <script src="{{ url('/') }}/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="{{ url('/') }}/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="{{ url('/') }}/assets/extra-libs/sparkline/sparkline.js"></script>
    
    <script src="{{ url('/') }}/dist/js/waves.js"></script>
    
    <script src="{{ url('/') }}/dist/js/sidebarmenu.js"></script>
    
    <script src="{{ url('/') }}/dist/js/custom.min.js"></script>
    
    <script src="{{ url('/') }}/assets/libs/flot/excanvas.js"></script>
    <script src="{{ url('/') }}/assets/libs/flot/jquery.flot.js"></script>
    <script src="{{ url('/') }}/assets/libs/flot/jquery.flot.pie.js"></script>
    <script src="{{ url('/') }}/assets/libs/flot/jquery.flot.time.js"></script>
    <script src="{{ url('/') }}/assets/libs/flot/jquery.flot.stack.js"></script>
    <script src="{{ url('/') }}/assets/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="{{ url('/') }}/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="{{ url('/') }}/dist/js/pages/chart/chart-page-init.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

        <!-- search option in dropdown -->
    <!-- <script src="{{asset('js/bootstrap-select.js')}}"></script> -->

    <!-- datetime picker -->
    <script src="{{asset('js/moment-with-locales.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

     <script src="{{asset('js/alertify.min.js')}}"></script>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    
        
    <script type="text/javascript">+
    $( document ).ready(function() {
            $( ".menu_click" ).trigger( "click" );
            
        });
        
    </script>
       <!--  -->
    
    <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
    
    <!-- datetime picker -->
    {!! Toastr::render() !!}

    @yield('script')

    <script type="text/javascript">
        toastr.options.closeButton = true;
        toastr.options.escapeHtml = true;
        toastr.options.newestOnTop = false;
    </script>
    <script src="{{asset('js/custom.js')}}"></script>
    </body>




</html>

