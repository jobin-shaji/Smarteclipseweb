  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="bg-info">
          <a href="{{url('/home')}}">
            <i class="fa fa-home"> </i> <span>Home</span>
          </a>
        </li>
        @role('root')
            @include('layouts.sections.root')
        @endrole
        @role('dealer')
            @include('layouts.sections.dealer')
        @endrole
        @role('sub_dealer')
            @include('layouts.sections.sub-dealer')
        @endrole
        @role('end_user')
            @include('layouts.sections.end-user')
        @endrole
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
