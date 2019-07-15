        <div class="client_menu">
           <nav class="navbar navbar-fixed-left navbar-minimal animate" role="navigation">
                <div class="navbar-toggler animate">
                  <span class="menu-icon"></span>
                </div>
                <ul class="navbar-menu animate">
                  
                   <li>
                    <a href="{{url('/data-usage')}}" class="animate">
                      <span class="desc animate">Data Usage</span>
                      <span class=""><img src="{{ url('/') }}/Report-icons/Total-KM-report.png"  /></span>
                    </a>
                  </li>

                  <li>
                    <a href="{{url('/geofence-report')}}" class="animate"> <span class="glyphicon glyphicon-user"></span>
                      <span class="desc animate">SMS Ussage</span>
                      <span class=""><img src="{{ url('/') }}/Report-icons/geofence-report.png"  /></span>
                    </a>
                  </li>
                  <li>
                    <a href="{{url('/alert-report')}}" class="animate">
                      <span class="desc animate">Device Activation/Deactivation Log</span>
                      <span class=""><img src="{{ url('/') }}/Report-icons/alert-report.png"  /></span>
                    </a>
                  </li>
                  

                </ul>
              </nav> 


        </div>