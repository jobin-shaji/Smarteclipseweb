
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
            <li><a href="<?php echo e(url('/cashReceipt-Report')); ?>"><i class="fa fa-list"></i>Cash Receipt Report</a></li>
            <li><a href="<?php echo e(url('/stage-wise-report')); ?>"><i class="fa fa-list"></i>Stage Wise/Time Wise Report</a></li>
            <li><a href="<?php echo e(url('/trip-wise-report')); ?>"><i class="fa fa-list"></i>Trip Wise Report</a></li>
            <li><a href="<?php echo e(url('/daily-cash-collection-report')); ?>"><i class="fa fa-list"></i>Cash Collection Report</a></li>
             <li><a href="<?php echo e(url('/toll-tax-report')); ?>"><i class="fa fa-list"></i>Toll Tax Statement</a></li>
            <li><a href="<?php echo e(url('/expediture-statement')); ?>"><i class="fa fa-list"></i>Expenditure Statement</a></li>
    </ul>
</li>

