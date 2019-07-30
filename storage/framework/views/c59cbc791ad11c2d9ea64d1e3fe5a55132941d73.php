<li class="treeview">
  <a href="#">
      <i class="fa fa-bus"></i>
      <span>Vehicles</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="<?php echo e(url('/vehicle-list')); ?>""><i class="fa fa-list"></i> Vehicle List</a></li>
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
      <li><a href="<?php echo e(url('/etm-list')); ?>"><i class="fa fa-list"></i> ETM List</a></li>
  </ul>
</li>
  
<li class="treeview">
  <a href="#">
      <i class="fa fa-users"></i>
      <span>Employees</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="<?php echo e(url('/depo/employees/create')); ?>"><i class="fa fa-plus"></i>Add Employees</a></li>
      <li><a href="<?php echo e(url('/employee-list')); ?>"><i class="fa fa-list"></i>List Employees </a></li>
  </ul>
</li>

<li class="treeview">
    <a href="#">
      <i class="fa fa-user-plus"></i>
      <span>Users</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="<?php echo e(url('/users/create')); ?>"><i class="fa fa-plus"></i>Add User</a></li>
      <li><a href="<?php echo e(url('/users')); ?>"><i class="fa fa-list"></i> List Users</a></li>
  </ul>
</li>


<li class="treeview">
  <a href="#">
      <i class="fa fa-map-marker"></i>
      <span>Stages</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
     <li><a href="<?php echo e(url('/stages-list')); ?>"><i class="fa fa-list"></i> Stage List</a></li>
  </ul>
</li>

<li class="treeview">
  <a href="#">
      <i class="fa fa-map-marker"></i>
      <span>Routes</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="<?php echo e(url('/routes/create')); ?>"><i class="fa fa-plus"></i>Add Routes</a></li>
      <li><a href="<?php echo e(url('/routes')); ?>"><i class="fa fa-list"></i> Routes List</a></li>
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
      <li><a href="<?php echo e(url('/waybill/create')); ?>"><i class="fa fa-plus"></i>Create Waybill</a></li>
      <li><a href="<?php echo e(url('/waybill')); ?>"><i class="fa fa-list"></i>Waybill List</a></li>
      <li><a href="<?php echo e(url('/waybill-log')); ?>"><i class="fa fa-history"></i>Waybill Update History</a></li>
       <li><a href="<?php echo e(url('/waybill-ticket-log')); ?>"><i class="fa fa-history"></i>Waybill Ticket Logs</a></li>
       <li><a href="<?php echo e(url('/etm-ticket-log')); ?>"><i class="fa fa-history"></i>ETM Ticket Logs</a></li>
  
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
    <li><a href="<?php echo e(url('/agent-waybill/create')); ?>"><i class="fa fa-plus"></i>Create Waybill</a></li>
    <li><a href="<?php echo e(url('/agent-waybill')); ?>"><i class="fa fa-list"></i>Waybill List</a></li>
  </ul>
</li> 

<li><a href="<?php echo e(url('/alerts')); ?>"><i class="fa fa-warning"></i>Alert</a></li>
<li class="treeview">
    <a href="#">

            <i class="fa fa-file"></i>
            <span>Reports</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu" style="display: none;">
      <li class="treeview">
        <a href="#">
          <i class="fa fa-list-alt"></i>
          <span>Concession Reports</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/concession-report-single')); ?>"><i class="fa fa-arrow-right"></i>Particular Concession Report</a></li>
          <li><a href="<?php echo e(url('/concession-report-combined')); ?>"><i class="fa fa-arrow-right"></i>Combined Concession Report</a></li>
          <li><a href="<?php echo e(url('/concessional-report')); ?>"><i class="fa fa-arrow-right"></i>Concessional Report</a></li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-road"></i>
          <span>Route Reports</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/route-report-single')); ?>"><i class="fa fa-arrow-right"></i>Particular Route Report</a></li>
          <li><a href="<?php echo e(url('/route-report-combined')); ?>"><i class="fa fa-arrow-right"></i>Combined Route Report</a></li>
          <li><a href="<?php echo e(url('/route-report')); ?>"><i class="fa fa-arrow-right"></i>Route Report</a></li>
          <li><a href="<?php echo e(url('/route-wise-conductor-comparative-report')); ?>"><i class="fa fa-arrow-right"></i>Route Wise Conductor Comparative Report</a></li>
          <li><a href="<?php echo e(url('/stage-wise-report')); ?>"><i class="fa fa-arrow-right"></i>Stage Wise/Time Wise Report</a></li>
          <li><a href="<?php echo e(url('/trip-wise-report')); ?>"><i class="fa fa-arrow-right"></i>Trip Wise Report</a></li>
          <li><a href="<?php echo e(url('/toll-tax-report')); ?>"><i class="fa fa-arrow-right"></i>Toll Tax Statement</a></li>
        </ul>
      </li>

      <li class="treeview">
      <a href="#">

          <i class="fa fa-list-alt"></i>
          <span>ETM Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/etmSingleCollection-report')); ?>"><i class="fa fa-arrow-right"></i>Particular ETM Report</a></li>
          <li><a href="<?php echo e(url('/etmCombinedCollection-report')); ?>"><i class="fa fa-arrow-right"></i>Combined Etm Collection</a></li>
          <li><a href="<?php echo e(url('/etmForManyDaysCollection-report')); ?>"><i class="fa fa-arrow-right"></i>For Many Days</a></li>   
          <li><a href="<?php echo e(url('/etmCollection-report')); ?>"><i class="fa fa-arrow-right"></i>ETM Collection Report</a></li> 
          <li><a href="<?php echo e(url('/machine-status-report')); ?>"><i class="fa fa-arrow-right"></i>Machine Status Report</a></li>   
      </ul>
    </li>
    
     <!-- ------------------------- -->
      <li class="treeview">
      <a href="#">
          <i class="fa fa-user-circle"></i>
          <span>Conductor Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/conductor-report-single')); ?>"><i class="fa fa-arrow-right"></i>Particular Conductor Report</a></li>
          <li><a href="<?php echo e(url('/conductor-report-combined')); ?>"><i class="fa fa-arrow-right"></i>Combined Conductor Report</a></li>
          <li><a href="<?php echo e(url('/conductor-report-for-many')); ?>"><i class="fa fa-arrow-right"></i>For Many Days Conductor Report</a></li> 
          <li><a href="<?php echo e(url('/conductor-wise-report')); ?>"><i class="fa fa-arrow-right"></i>Conductor wise Report</a></li>   
          <li><a href="<?php echo e(url('/cashReceipt-Report')); ?>"><i class="fa fa-arrow-right"></i>Cash Receipt Report</a></li>
          <li><a href="<?php echo e(url('/daily-cash-collection-report')); ?>"><i class="fa fa-arrow-right"></i>Cash Collection Report</a></li>  
          <li><a href="<?php echo e(url('/expediture-statement')); ?>"><i class="fa fa-arrow-right"></i>Expenditure Statement</a></li>
      </ul>
    </li>
    <!-- ------------Driver Collection Report------------- -->


      <li class="treeview">
      <a href="#">
          <i class="fa fa-user-circle"></i>
          <span>Driver Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/Single-driver-report')); ?>"><i class="fa fa-arrow-right"></i>Particular Driver Conductor Report</a></li>
          <li><a href="<?php echo e(url('/combined-driver-report')); ?>"><i class="fa fa-arrow-right"></i>Driver Combined Report</a></li>
          <li><a href="<?php echo e(url('/formanydays-driver-report')); ?>"><i class="fa fa-arrow-right"></i>Driver For Many Days Report</a></li>      
      </ul>
    </li>
     <!-- ------------------------- -->
      <li class="treeview">
      <a href="#">
          <i class="fa fa-gg"></i>
          <span>GST Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/single-gst-report')); ?>"><i class="fa fa-arrow-right"></i>Particular GST Report</a></li>
          
          <li><a href="<?php echo e(url('/combined-gst-report')); ?>"><i class="fa fa-arrow-right"></i>Combined GST Report</a></li>      
      </ul>
    </li>

     <!-- -------------State Wise Report------------ -->
      <li class="treeview">
      <a href="#">
          <i class="fa fa-dashcube"></i>
          <span>State Wise Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/single-state-wise-report')); ?>"><i class="fa fa-arrow-right"></i>Particular State Wise Report</a></li>
          
          <li><a href="<?php echo e(url('/combined-state-wise-report')); ?>"><i class="fa fa-arrow-right"></i>Combined State Wise Report</a></li> 

          <li><a href="<?php echo e(url('/state-fare-report')); ?>"><i class="fa fa-arrow-right"></i>State Wise Fare Report</a></li>     
      </ul>
    </li>
    <!-- ------------------------- -->

    <!-- -------------Waybill Report------------ -->
      <li class="treeview">
      <a href="#">
          <i class="fa fa-list-alt"></i>
          <span>Waybill Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/conductor-waybill-abstract-report')); ?>"><i class="fa fa-arrow-right"></i>Conductor Waybill Abstract Report</a></li>
          
          <li><a href="<?php echo e(url('/waybill-trip-wise-report')); ?>"><i class="fa fa-arrow-right"></i>Waybill trip wise report</a></li>     
      </ul>
    </li>
    <!-- ------------------------- -->

    <li class="treeview">
      <a href="#">
          <i class="fa fa-money"></i>
          <span>Inspector Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/inspector-report')); ?>"><i class="fa fa-arrow-right"></i>Inspector Report</a></li> 
      </ul>
    </li>

  <!--   <li class="treeview">
      <a href="#">
          <i class="fa fa-user-circle"></i>
          <span>Driver</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/single-driver-collectio-report')); ?>"><i class="fa fa-list"></i>Single</a></li>
          <li><a href="<?php echo e(url('/combined-driver-collectio-report')); ?>"><i class="fa fa-list"></i>Combined</a></li>
          <li><a href="#"><i class="fa fa-list"></i>For Many Days</a></li>      
      </ul>
    </li> -->
            
            
            
            <!-- <li><a href="<?php echo e(url('/state-amount-bifurcation-report')); ?>"><i class="fa fa-list"></i>State Amount Bifurcation Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/cumulative-route-record')); ?>"><i class="fa fa-list"></i>cumulative Route Record</a></li> -->
            <!-- <li><a href="<?php echo e(url('/epkm-report')); ?>"><i class="fa fa-list"></i>EPKM Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/bus-wise-covered-missed-report')); ?>"><i class="fa fa-list"></i>Bus Wise Covered, Missed and Excess Kms Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/conductor-wise-covered-missed-report')); ?>"><i class="fa fa-list"></i>Conductor Wise Covered, Missed and Excess Kms Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/rotation-wise-conductor-comparative-statement')); ?>"><i class="fa fa-list"></i>Rotataion Wise Conductor Comparative Statement</a></li> -->
            <!-- <li><a href="<?php echo e(url('/bus-wise-conductor-comparative-statement')); ?>"><i class="fa fa-list"></i>Bus Wise Conductor Comparative Statement</a></li> -->
            <!-- <li><a href="<?php echo e(url('/loss-profit-statement')); ?>"><i class="fa fa-list"></i>Loss Profit Statement</a></li> -->
            <!-- <li><a href="<?php echo e(url('/depot-wise-advance-booking-report')); ?>"><i class="fa fa-list"></i>Depot Wise Advance Booking Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/bus-stand-wise-advance-booking-report')); ?>"><i class="fa fa-list"></i>Bus Stand Wise Advance Booking Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/advance-booker-wise')); ?>"><i class="fa fa-list"></i>Advance Booker Wise</a></li> -->
            <!-- <li><a href="<?php echo e(url('/adda-fee-collection-report')); ?>"><i class="fa fa-list"></i>Adda Fee Collection Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/bus-stand-wise-adda-fee-collection-report')); ?>"><i class="fa fa-list"></i>Bus Stand Wise Adda Fee Collection Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/bus-stand-wise-adda-fee-paid-report')); ?>"><i class="fa fa-list"></i>Bus Stand Wise Adda Fee Paid Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/route-wise-adda-fee-paid-report')); ?>"><i class="fa fa-list"></i>Route Wise Adda Fee Paid Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/conductor-wise-adda-fee-paid-report')); ?>"><i class="fa fa-list"></i>Conductor Wise Adda Fee Paid Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/gst-ac-bus-report')); ?>"><i class="fa fa-list"></i>GST A/C Bus Report</a></li> -->
            <!-- <li><a href="<?php echo e(url('/daily-revenue-statement')); ?>"><i class="fa fa-list"></i>Daily Revenue Statement</a></li> -->
            <!-- <li><a href="<?php echo e(url('/route-record-statement')); ?>"><i class="fa fa-list"></i>Route Record Statement</a></li> -->
      
      <!-- ADVANCE BOOKING REPORTS -->
      <li class="treeview">
        <a href="#">
          <i class="fa fa-address-card-o"></i>
          <span>Advance Booking Concession Reports</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/agent-concession-report-single')); ?>"><i class="fa fa-arrow-right"></i>Particular Concession Report</a></li>
          <li><a href="<?php echo e(url('/agent-concession-report-combined')); ?>"><i class="fa fa-arrow-right"></i>Combined Concession Report</a></li>
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-calculator"></i>
          <span>Advance Booking ETM Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="display: none;">
            <li><a href="<?php echo e(url('/agent-etmSingleCollection-report')); ?>"><i class="fa fa-arrow-right"></i>Particular ETM Report</a></li>
            <li><a href="<?php echo e(url('/agent-etmCombinedCollection-report')); ?>"><i class="fa fa-arrow-right"></i>Combined Etm Collection</a></li>
            <li><a href="<?php echo e(url('/agent-etmForManyDaysCollection-report')); ?>"><i class="fa fa-arrow-right"></i>For Many Days</a></li>   
        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-road"></i>
          <span>Advance Booking Route Reports</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/agent-route-report-single')); ?>"><i class="fa fa-arrow-right"></i>Particular Route Report</a></li>
          <li><a href="<?php echo e(url('/agent-route-report-combined')); ?>"><i class="fa fa-arrow-right"></i>Combined Route Report</a></li>
        </ul>
      </li>

       <!-- ------------------------- -->
      <li class="treeview">
      <a href="#">
          <i class="fa fa-user-circle"></i>
          <span>Advance Booker Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">

         <li><a href="<?php echo e(url('/agent-report-single')); ?>"><i class="fa fa-arrow-right"></i>Particular Agent Report</a></li>
          <li><a href="<?php echo e(url('/agent-report-combined')); ?>"><i class="fa fa-arrow-right"></i>Combined Agent Report</a></li>
          <li><a href="<?php echo e(url('/agent-report-for-many')); ?>"><i class="fa fa-arrow-right"></i>For Many Days Agent Report</a></li> 

          <li><a href="<?php echo e(url('/advance-wise-report')); ?>"><i class="fa fa-arrow-right"></i>Advance wise Report</a></li>     
      </ul>
    </li>


     <!-- -------------Advane Booker Waybill Report------------ -->
      <li class="treeview">
      <a href="#">
          <i class="fa fa-list-alt"></i>
          <span>Advance Booker Waybill Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/agent-waybill-abstract-report')); ?>"><i class="fa fa-arrow-right"></i>Advance Booker Waybill Abstract Report</a></li>
          
          <li><a href="<?php echo e(url('/agent-waybill-trip-wise-report')); ?>"><i class="fa fa-arrow-right"></i>ADvance Booker Waybill trip wise report</a></li>     
      </ul>
    </li>


     <!-- ------------------------- -->
     <!--  <li class="treeview">
      <a href="#">
          <i class="fa fa-gg"></i>
          <span>Advance Booker GST Reports</span>
          <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu" style="display: none;">
          <li><a href="<?php echo e(url('/single-advance-booker-gst-report')); ?>"><i class="fa fa-arrow-right"></i>Particular Advance Booker  GST Report</a></li>
          
          <li><a href="<?php echo e(url('/combined-advance-booker-gst-report')); ?>"><i class="fa fa-arrow-right"></i>Combined Advance Booker GST Report</a></li>      
      </ul>
    </li> -->

    </ul>
</li>

