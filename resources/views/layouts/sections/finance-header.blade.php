
 <ul class="navbar-nav float-left mr-auto">
    <li class="nav-item d-none d-md-block">
    </li>
    <li class="nav-item">
        <a class="nav-link waves-effect waves-dark" href="{{url('/home')}}">
            <i class="fa fa-home" aria-hidden="true"></i>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> INVOICE
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">  
           <a class="dropdown-item" href="{{url('/customerapproved')}}">PENDING  </a>    
           <a class="dropdown-item" href="{{url('/paid')}}">PAID</a>                  
           <a class="dropdown-item" href="{{url('/servicepaymentreceived')}}">COMPLETED</a>
           <a class="dropdown-item" href="{{url('/cancelledview')}}">CANCELLED</a> 
           <a class="dropdown-item" href="{{url('/simrenewal')}}">ESIM RENEWAL</a> 
          
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> PURCHASE
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">  
        <a href="{{url('/create-components')}}" class="dropdown-item">
                 ADD COMPONENTS</a>
           <a class="dropdown-item" href="{{url('/service-components')}}">LIST COMPONENTS</a> 
           
           <a href="" data-toggle="modal" data-target="#myModals" onclick="clearform()"
                        class="dropdown-item">
                 ADD ASSETS</a>
           <a class="dropdown-item" href="{{url('/service-assets')}}">LIST ASSETS</a> 


           <a href="" data-toggle="modal" data-target="#myModal" onclick="clearform()"
                        class="dropdown-item">
                 ADD PRODUCT</a>
           <a class="dropdown-item" href="{{url('/service-products')}}">LIST PRODUCT</a> 
        <!--   <a class="dropdown-item" href="{{url('/servicepaymentreceived')}}">COMPLETED</a>
           <a class="dropdown-item" href="{{url('/cancelledview')}}">CANCELLED</a> 
           <a class="dropdown-item" href="{{url('/simrenewal')}}">ESIM RENEWAL</a> -->
          
        </div>
    </li>

    
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
           REPORTS
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">  
           <a class="dropdown-item" href="{{url('/service_list')}}">SERVICE LIST</a>    
           <a class="dropdown-item" href="{{url('/paymentcollection')}}">PAYMENT COLLECTION</a>  
           
         
           <a class="dropdown-item" href="{{url('/courierlist')}}">COURIER LIST</a>  
          
        </div>
    </li>
    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
           Logout
        </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
    </li>
 </ul>
