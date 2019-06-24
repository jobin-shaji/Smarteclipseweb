<!-- Left side column. contains the logo and sidebar -->
<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav" id="left_sidebar_hide">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/home')}}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                @role('root')
                @include('layouts.sections.root')
                @endrole
                @role('dealer')
                @include('layouts.sections.dealer')
                @endrole
                @role('sub_dealer')
                @include('layouts.sections.sub-dealer')
                @endrole
                @role('client')
                @include('layouts.sections.client-demo')
                @endrole
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>