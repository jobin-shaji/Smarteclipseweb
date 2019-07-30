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
      <i class="fa fa-map-marker"></i>
      <span>Stage</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="<?php echo e(url('/stage-category')); ?>"><i class="fa fa-list"></i>List Stage Categories </a></li>
      <li><a href="<?php echo e(url('/stages/create')); ?>"><i class="fa fa-plus"></i>Add Stage</a></li>
      <li><a href="<?php echo e(url('/stages')); ?>"><i class="fa fa-list"></i> Stage List</a></li>
  </ul>
</li>

<li class="treeview">
  <a href="#">
      <i class="fa fa-money"></i>
      <span>State Fare slab</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="<?php echo e(url('/state-fare-slab/create')); ?>"><i class="fa fa-plus"></i>Add State Fare</a></li>
      <li><a href="<?php echo e(url('/state-fare-slab')); ?>"><i class="fa fa-list"></i>List State Fare Slab </a></li>
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
      <span>State Tax </span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="<?php echo e(url('/state-tax-type/create')); ?>"><i class="fa fa-plus"></i>Add State </a></li>
      <li><a href="<?php echo e(url('/state-tax-type')); ?>"><i class="fa fa-list"></i>List State Tax </a></li>
  </ul>
</li>


<!-- GST -->
<li class="treeview">
  <a href="#">
      <i class="fa fa-gg"></i>
      <span>GST</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
  </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="<?php echo e(url('/gst/create')); ?>"><i class="fa fa-plus"></i>Add GST</a></li>
       <li><a href="<?php echo e(url('/gst')); ?>"><i class="fa fa-list"></i>List GST </a></li>  
  </ul>
</li>

<!-- toll Booth -->
<li class="treeview">
  <a href="#">
      <i class="fa fa-road"></i>
      <span>Toll Booth</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
  </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="<?php echo e(url('/tollbooth/create')); ?>"><i class="fa fa-plus"></i>Add Toll Booth</a></li>
       <li><a href="<?php echo e(url('/tollbooth')); ?>"><i class="fa fa-list"></i>List Toll Booth </a></li>  
  </ul>
</li>
<!-- Adda Fee -->
<li class="treeview">
  <a href="#">
      <i class="fa fa-road"></i>
      <span>Adda Fee</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
  </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
       <li><a href="<?php echo e(url('/addafee')); ?>"><i class="fa fa-list"></i>List Adda Fee </a></li>
    
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
      <li><a href="<?php echo e(url('/ticket-category/create')); ?>"><i class="fa fa-plus"></i>Add New Ticket Category</a></li>
      <li><a href="<?php echo e(url('/ticket-category')); ?>"><i class="fa fa-list"></i>List Ticket Categories </a></li>
      <li><a href="<?php echo e(url('/concession/create')); ?>"><i class="fa fa-plus"></i>Add Concession</a></li>
      <li><a href="<?php echo e(url('/concessions')); ?>"><i class="fa fa-list"></i>List Concessions </a></li>
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

<<!-- li class="treeview">
  <a href="#">
      <i class="fa fa-file"></i>
      <span>Report</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
  </a>
  <ul class="treeview-menu" style="display: none;">
      <li><a href="<?php echo e(url('/state-wise-mileage-km-report')); ?>"><i class="fa fa-list"></i>State Wise Mileage-KMs Report</a></li>
      <li><a href="<?php echo e(url('/state-wise-fare-tax-summery')); ?>"><i class="fa fa-list"></i>State Wise fare and tax Summery</a></li>
      <li class="sideli"><a href="<?php echo e(url('/state-wise-covered-missed-report')); ?>"><i class="fa fa-list"></i>State Wise Covered,Missed & Excess KMs Report</a></li>
      <li><a href="<?php echo e(url('/state-wise-revenue-summery-of-advance-bookers')); ?>"><i class="fa fa-list"></i>State Wise Revenue Summery of Advance Bookers</a></li>
      <li><a href="<?php echo e(url('/state-amount-bifurcation-report-advance-booker')); ?>"><i class="fa fa-list"></i>State Amount Bifurcation Report(Advance Booker)</a></li>
  </ul>
</li> -->