  <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav" id="left_sidebar_hide">
                    <ul id="sidebarnav" class="p-t-30">
                        @role('root')
                          @include('layouts.sections.eclipse-root-sidebar')
                        @endrole
                         @role('client')
                          @include('layouts.sections.eclipse-client-sidebar')
                        @endrole


                     

                  </ul>
              </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
  </aside>