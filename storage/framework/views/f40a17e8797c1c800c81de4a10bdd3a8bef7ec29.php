  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="bg-info">
          <a href="<?php echo e(url('/home')); ?>">
            <i class="fa fa-home"> </i> <span>Home</span>
          </a>
        </li>
        <?php if(auth()->check() && auth()->user()->hasRole('root')): ?>
         <li>
          <a href="<?php echo e(url('/states')); ?>">
            <i class="fa fa-users"></i> <span>States</span>
          </a>
        </li>
        <li>
          <a href="<?php echo e(url('/users')); ?>">
            <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li>
        <?php endif; ?>
        <?php if(auth()->check() && auth()->user()->hasRole('state')): ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-building"></i>
            <span>Depot</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/depots/create')); ?>"><i class="fa fa-plus"></i>Add Depot</a></li>
            <li><a href="<?php echo e(url('/depots')); ?>"><i class="fa fa-list"></i>List Depots </a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-mobile fa-lg"></i>
            <span>ETM</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/etm/create')); ?>"><i class="fa fa-plus"></i>Add ETM</a></li>
            <li><a href="<?php echo e(url('/etms')); ?>"><i class="fa fa-list"></i>List ETM's </a></li>


            <li><a href="<?php echo e(url('/etm-transfer/create')); ?>"><i class="fa fa-plus"></i>Transfer ETM</a></li>
            <li><a href="<?php echo e(url('/etm-transfers')); ?>"><i class="fa fa-list"></i> ETM Transfer list </a></li>

          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Employee</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/employees/create')); ?>"><i class="fa fa-plus"></i>Add Employee</a></li>
            <li><a href="<?php echo e(url('/employees')); ?>"><i class="fa fa-list"></i>List Employees </a></li>
            <li><a href="<?php echo e(url('/employee-transfer/create')); ?>"><i class="fa fa-plus"></i>Transfer Employee</a></li>
            <li><a href="<?php echo e(url('/employee-transfer')); ?>"><i class="fa fa-list"></i> Employee Transfer List</a></li>

            <li><a href="<?php echo e(url('/employees-desig/create')); ?>"><i class="fa fa-plus"></i>Add Employee Designation</a></li>
            <li><a href="<?php echo e(url('/employee-designation')); ?>"><i class="fa fa-list"></i>List Employee Designations </a></li>

            <li><a href="<?php echo e(url('/employment-type/create')); ?>"><i class="fa fa-plus"></i>Add Employee Type</a></li>
            <li><a href="<?php echo e(url('/employment-type')); ?>"><i class="fa fa-list"></i>List Employee Types </a></li>

          
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-bus"></i>
            <span>Vehicle</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/vehicles/create')); ?>"><i class="fa fa-plus"></i>Add Vehicle</a></li>
            <li><a href="<?php echo e(url('/vehicles')); ?>"><i class="fa fa-list"></i>List Vehicles </a></li>

            <li><a href="<?php echo e(url('vehicle-type/create')); ?>"><i class="fa fa-plus"></i>Add Vehicle Type</a></li>
            <li><a href="<?php echo e(url('/vehicle-types')); ?>"><i class="fa fa-list"></i>List Vehicle Types </a></li>

            
            <li><a href="<?php echo e(url('/vehicle-transfer')); ?>"><i class="fa fa-plus"></i>Transfer Vehicle</a></li>
            <li><a href="<?php echo e(url('/vehicle-transfer-list')); ?>"><i class="fa fa-list"></i>Vehicle Transfer List</a></li>

          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-ticket"></i>
            <span>Ticket Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/ticket-category/create')); ?>"><i class="fa fa-plus"></i>Add New Ticket Category</a></li>
            <li><a href="<?php echo e(url('/ticket-category')); ?>"><i class="fa fa-list"></i>List Ticket Categories </a></li>
          </ul>
        </li>  

        <li class="treeview">
          <a href="#">
            <i class="fa fa-ticket"></i>
            <span>Ticket</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/concession/create')); ?>"><i class="fa fa-plus"></i>Add Concession</a></li>
            <li><a href="<?php echo e(url('/concessions')); ?>"><i class="fa fa-list"></i>List Concessions </a></li>
          </ul>
        </li>  

        <li class="treeview">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Fare Slab</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/fare-slab/create')); ?>"><i class="fa fa-plus"></i>Add Fare Slab</a></li>
            <li><a href="<?php echo e(url('/fare-slabs')); ?>"><i class="fa fa-list"></i>List Fare Slab </a></li>
          </ul>
        </li>  

        <li class="treeview">
          <a href="#">
            <i class="fa fa-suitcase"></i>
            <span>Expense</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/expense-type/create')); ?>"><i class="fa fa-plus"></i>Add Expense Type</a></li>
            <li><a href="<?php echo e(url('/expense-type')); ?>"><i class="fa fa-list"></i>List Expense Type </a></li>
          </ul>
        </li>  

        <li class="treeview">
          <a href="#">
            <i class="fa fa-stop"></i>
            <span>Stop Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/stop-category/create')); ?>"><i class="fa fa-plus"></i>Add Stop Category</a></li>
            <li><a href="<?php echo e(url('/stop-category')); ?>"><i class="fa fa-list"></i>List Stop Categories </a></li>
          </ul>
        </li>  

        <!-- toll slab -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-road"></i>
            <span>Toll Fee Slab</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/tollfee-slab/create')); ?>"><i class="fa fa-plus"></i>Add Toll Fee Slab</a></li>
            <li><a href="<?php echo e(url('/tollfee-slab')); ?>"><i class="fa fa-list"></i>List Toll Fee Slab </a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashcube"></i>
            <span>State Tax</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/state-tax/create')); ?>"><i class="fa fa-plus"></i>Add State Tax</a></li>
            <li><a href="<?php echo e(url('/state-tax')); ?>"><i class="fa fa-list"></i>List State Tax </a></li>
          </ul>
        </li>


         <li class="treeview">
          <a href="#">
            <i class="fa fa-dashcube"></i>
            <span>State Fare slab</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/state-tax/create')); ?>"><i class="fa fa-plus"></i>Add State Tax</a></li>
            <li><a href="<?php echo e(url('/state-tax')); ?>"><i class="fa fa-list"></i>List State Fare Slab </a></li>
          </ul>
        </li>


        <?php endif; ?> 

        <?php if(auth()->check() && auth()->user()->hasRole('depot')): ?>
       
        <li class="treeview">
          <a href="#">
            <i class="fa fa-map-marker"></i>
            <span>Stages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/stages/create')); ?>"><i class="fa fa-plus"></i>Add Stage</a></li>
            <li><a href="<?php echo e(url('/stages')); ?>"><i class="fa fa-list"></i> Stage List</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-road"></i>
            <span>Routes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/routes/create')); ?>"><i class="fa fa-plus"></i>Add Route</a></li>
            <li><a href="<?php echo e(url('/routes')); ?>"><i class="fa fa-list"></i> Route List</a></li>
          </ul>
        </li>

        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-space-shuttle"></i>
            <span>Trip</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/trips/create')); ?>"><i class="fa fa-plus"></i>Add Trip</a></li>
            <li><a href="<?php echo e(url('/trips')); ?>"><i class="fa fa-list"></i>List Trips </a></li>
          </ul>
        </li> 

        <li class="treeview">
          <a href="#">
            <i class="fa fa-clock-o"></i>
            <span>Schedule</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/schedule/create')); ?>"><i class="fa fa-plus"></i>Add Schedule</a></li>
            <li><a href="<?php echo e(url('/schedules')); ?>"><i class="fa fa-list"></i>List Schedules </a></li>
          </ul>
        </li> 
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Crew</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/crew/create')); ?>"><i class="fa fa-plus"></i>Crew Creation</a></li>
            <li><a href="<?php echo e(url('/crews')); ?>"><i class="fa fa-list"></i>Crew List</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-list-alt"></i>
            <span>Conductor WayBill</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/waybill')); ?>"><i class="fa fa-list"></i>Waybill List</a></li>
            <li><a href="#"><i class="fa fa-history"></i>Waybill Log</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-list-alt"></i>
            <span>Advance Booker WayBill</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/agent-waybill')); ?>"><i class="fa fa-list"></i>Waybill List</a></li>
          </ul>
        </li>
        <?php endif; ?>


          <?php if(auth()->check() && auth()->user()->hasRole('state')): ?>
          <li class="treeview">
          <a href="#">
            <i class="fa fa-ban"></i>
            <span>Penality</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/penality')); ?>"><i class="fa fa-list"></i>Penality List</a></li>
            
          </ul>
        </li>
         <?php endif; ?>

          <?php if(auth()->check() && auth()->user()->hasRole('depot')): ?>
          <li class="treeview">
          <a href="#">
            <i class="fa fa-file"></i>
            <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/stage-wise-report')); ?>"><i class="fa fa-list"></i>Stage Wise/Time Wise Report</a></li>

            <li><a href="<?php echo e(url('/trip-wise-report')); ?>"><i class="fa fa-list"></i>Trip Wise Report</a></li>

            <li><a href="<?php echo e(url('/cumulative-route-record')); ?>"><i class="fa fa-list"></i>cumulative Route Record</a></li>
            
             <li><a href="<?php echo e(url('/toll-tax-report')); ?>"><i class="fa fa-list"></i>Toll Tax Statement</a></li>
              <li><a href="<?php echo e(url('/concessional-report')); ?>"><i class="fa fa-list"></i>Concessional Report</a></li>

            <li><a href="<?php echo e(url('/epkm-report')); ?>"><i class="fa fa-list"></i>EPKM Report</a></li>

            <li><a href="<?php echo e(url('/route-wise-conductor-comparative-report')); ?>"><i class="fa fa-list"></i>Route Wise Conductor Comparative Report</a></li>

            <li><a href="<?php echo e(url('/bus-wise-covered-missed-report')); ?>"><i class="fa fa-list"></i>Bus Wise Covered, Missed and Excess Kms Report</a></li>

            <li><a href="<?php echo e(url('/conductor-wise-covered-missed-report')); ?>"><i class="fa fa-list"></i>Conductor Wise Covered, Missed and Excess Kms Report</a></li>

            

            <li><a href="<?php echo e(url('/rotation-wise-conductor-comparative-statement')); ?>"><i class="fa fa-list"></i>Rotataion Wise Conductor Comparative Statement</a></li>

            <li><a href="<?php echo e(url('/bus-wise-conductor-comparative-statement')); ?>"><i class="fa fa-list"></i>Bus Wise Conductor Comparative Statement</a></li>

            <li><a href="<?php echo e(url('/loss-profit-statement')); ?>"><i class="fa fa-list"></i>Loss Profit Statement</a></li>

            <li><a href="<?php echo e(url('/depot-wise-advance-booking-report')); ?>"><i class="fa fa-list"></i>Depot Wise Advance Booking Report</a></li>

            <li><a href="<?php echo e(url('/bus-stand-wise-advance-booking-report')); ?>"><i class="fa fa-list"></i>Bus Stand Wise Advance Booking Report</a></li>

            <li><a href="<?php echo e(url('/advance-booker-wise')); ?>"><i class="fa fa-list"></i>Advance Booker Wise</a></li>

            <li><a href="<?php echo e(url('/adda-fee-collection-report')); ?>"><i class="fa fa-list"></i>Adda Fee Collection Report</a></li>

            <li><a href="<?php echo e(url('/bus-stand-wise-adda-fee-collection-report')); ?>"><i class="fa fa-list"></i>Bus Stand Wise Adda Fee Collection Report</a></li>

            <li><a href="<?php echo e(url('/bus-stand-wise-adda-fee-paid-report')); ?>"><i class="fa fa-list"></i>Bus Stand Wise Adda Fee Paid Report</a></li>

            <li><a href="<?php echo e(url('/route-wise-adda-fee-paid-report')); ?>"><i class="fa fa-list"></i>Route Wise Adda Fee Paid Report</a></li>

            <li><a href="<?php echo e(url('/conductor-wise-adda-fee-paid-report')); ?>"><i class="fa fa-list"></i>Conductor Wise Adda Fee Paid Report</a></li>

            <li><a href="<?php echo e(url('/gst-ac-bus-report')); ?>"><i class="fa fa-list"></i>GST A/C Bus Report</a></li>

            <li><a href="<?php echo e(url('/daily-revenue-statement')); ?>"><i class="fa fa-list"></i>Daily Revenue Statement</a></li>

            <li><a href="<?php echo e(url('/route-record-statement')); ?>"><i class="fa fa-list"></i>Route Record Statement</a></li>

           

            <li><a href="<?php echo e(url('/expediture-statement')); ?>"><i class="fa fa-list"></i>Expenditure Statement</a></li>

           

            
            
          </ul>
        </li>
         <?php endif; ?>

         <?php if(auth()->check() && auth()->user()->hasRole('state')): ?>
          <li class="treeview">
          <a href="#">
            <i class="fa fa-file"></i>
            <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/state-amount-bifurcation-report')); ?>"><i class="fa fa-list"></i>State Amount Bifurcation Report</a></li>

            <li><a href="<?php echo e(url('/state-wise-mileage-km-report')); ?>"><i class="fa fa-list"></i>State Wise Mileage-KMs Report</a></li>

            <li><a href="<?php echo e(url('/state-wise-fare-tax-summery')); ?>"><i class="fa fa-list"></i>State Wise fare and tax Summery</a></li>

            <li class="sideli"><a href="<?php echo e(url('/state-wise-covered-missed-report')); ?>"><i class="fa fa-list"></i>State Wise Covered,Missed & Excess KMs Report</a></li>

            <li><a href="<?php echo e(url('/state-wise-revenue-summery-of-advance-bookers')); ?>"><i class="fa fa-list"></i>State Wise Revenue Summery of Advance Bookers</a></li>

            <li><a href="<?php echo e(url('/state-amount-bifurcation-report-advance-booker')); ?>"><i class="fa fa-list"></i>State Amount Bifurcation Report(Advance Booker)</a></li>
            
          </ul>
        </li>
         <?php endif; ?>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
