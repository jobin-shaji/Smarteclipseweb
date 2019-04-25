 
<?php $__env->startSection('title'); ?>
   Waybill generation
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<section class="content-header">
    <h1>WayBill</h1>
</section>
<?php if(Session::has('message')): ?>
    <div class="pad margin no-print">
      	<div class="callout <?php echo e(Session::get('callout-class', 'callout-success')); ?>" style="margin-bottom: 0!important;">
         <?php echo e(Session::get('message')); ?>  
      	</div>
    </div>
<?php endif; ?>  



<section class="hilite-content">
	<div class="row">
 <button class="btn btn-default pull-right" onclick="downloadWayBill(<?php echo e($waybill->id); ?>)">Download PDF  <i class="fa fa-download"></i> </button>
</div>
	<div class="row">
		<div class="text-center main_heading">
			<b>PEPSU ROAD TRANSPORT<br>LUDHIANA<br>For EWaybill: <?php echo e($waybill->id); ?><br>
			CONDUCTOR WAYBILL [CW] </b>
		</div>
		<div class="pull-left">
			<b><?php echo date("l,")."  ".date("F d,Y"); ?></b>
		</div>
		<hr class="first_hori_line">
	</div>
	<div class="row">
		<div class="border1">
			<div class="col-md-3">
				<b>
					Cndtr Code: <?php echo e($waybill->crew->employees->where('employee_designation_id',1)->first()->employee_code); ?>

					<br>
					Driver Code: <?php echo e($waybill->crew->employees->where('employee_designation_id',2)->first()->employee_code); ?>

				</b>
			</div>
			<div class="col-md-3">
				<b>
					Name: <?php echo e($waybill->crew->employees->where('employee_designation_id',1)->first()->name); ?>

					<br>
					EBTM NO :
				</b>
			</div>
			<div class="col-md-3">
				<b>
					<br>
					Date : <?php echo e($waybill->from_date); ?>

				</b>
			</div>
			<div class="col-md-3">
				<b>
					Bus Number : <?php echo e($waybill->vehicle->register_number); ?>

					<br>
					BusService : <?php echo e($waybill->vehicle->vehicleType->name); ?>

				</b>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="heading">
				<b><u>A: Conductor Booking Details in Rs</u></b>
			</div>
			<div class="row">
				<div class="col-md-6">
					<b>
						<div>Passanger Amount : </div>
						<div>Luggage Amount : </div>
						<div>Passes Amount : </div>
						<div>Collections : </div>
						<div>Total Amount : </div><br>
						<div>Toll Amount : </div>
						<div>Misc. Amount : </div>
						<div>Toll Tax Amount : </div><br>
						<div>Penality Amount : </div>
					</b>
				</div>
				<div class="col-md-6">
					<b>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div><br>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div><br>
						<div>00.00</div>
					</b>
				</div>
			</div>

			<div class="heading">
				<b><u>B: Bus Stand Window Booking</u></b>
			</div>
			<div class="row">
				<div class="col-md-6">
					<b>
						<div>Passanger Count : </div>
						<div>a-Adda Bkg Amount : </div>
						<div>b-Adv Bkg EBTM : </div>
						<div>Total Amount : </div>
					</b>
				</div>
				<div class="col-md-6">
					<b>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div>
					</b>
				</div>
			</div>

			<div class="heading">
				<b><u>C: Expenses</u></b>
			</div>
			<div class="row">
				<div class="col-md-6">
					<b>
						<div>Toll Tax Expenses : </div>
						<div>Ticket Refund : </div>
						<div>Bus Stand Fee : </div>
						<div>Diesel Amount : </div>
						<div>Other Payments : </div>
						<div>Total Amount : </div><br>
						<div>G: Earning Per KM (EPKM) : </div>
						<div>Earning Per KM with pass Amount : </div>
					</b>
				</div>
				<div class="col-md-6">
					<b>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div><br>
						<div>00.00</div>
						<div>00.00</div>
					</b>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-6">
					<div class="heading">
						<b><u>D: Total Tickets Issued :</u></b>
					</div>
				</div>
				<div class="col-md-6">
					<div class="heading">
						<b>0</b>
					</div>
				</div>
			</div>

			<div class="heading">
				<b><u>E: Classification of Categories</u></b>
			</div>
			<div class="row">
				<div class="col-md-6">
					<b>
						<div>Passanger of C.B. : </div>
						<div>Pssngr of Window Booking : </div>
						<div>Luggage Tickets : </div>
						<div>Pssngr with 100% Concession : </div>
						<div>Pssngr with 50% Concession : </div>
						<div>Insp Ticket Count : </div>
						<div>Insp Ticket Amount : </div>
						<div>Traffic Inspection : </div>
					</b>
				</div>
				<div class="col-md-6">
					<b>
						<div>0</div>
						<div>0</div>
						<div>0</div>
						<div>0</div>
						<div>0</div>
						<div>0</div>
						<div>0</div>
						<div>X</div>
					</b>
				</div>
			</div>

			<div class="heading">
				<b><u>F: Concession Details </u></b>
			</div>
			<table class="table1">
				<thead>
					<tr>
						<th>PASS TYPE </th>
						<th>DISC% </th>
						<th>TKTS </th>
						<th>NET AMT </th>
						<th>DISC AMT </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>BLIND</th>
						<th>100 </th>
						<th>0 </th>
						<th>0000.00 </th>
						<th>0000.00 </th>
					</tr>
					<tr>
						<th>CANCER PAT</th>
						<th>100 </th>
						<th>0 </th>
						<th>0000.00 </th>
						<th>0000.00 </th>
					</tr>
					<tr>
						<th>FREEDOM F</th>
						<th>100 </th>
						<th>0 </th>
						<th>0000.00 </th>
						<th>0000.00 </th>
					</tr>
					<tr>
						<th>OLD WOMAN</th>
						<th>50 </th>
						<th>0 </th>
						<th>0000.00 </th>
						<th>0000.00 </th>
					</tr>
					<tr>
						<th>P HANDICAPP</th>
						<th>50 </th>
						<th>0 </th>
						<th>0000.00 </th>
						<th>0000.00 </th>
					</tr>
					<tr>
						<th>POLICE</th>
						<th>100 </th>
						<th>0 </th>
						<th>0000.00 </th>
						<th>0000.00 </th>
					</tr>
					<tr>
						<th>PRESS REPOR</th>
						<th>100 </th>
						<th>0 </th>
						<th>0000.00 </th>
						<th>0000.00 </th>
					</tr>
					<tr>
						<th>STUDENT PAS</th>
						<th>100 </th>
						<th>0 </th>
						<th>0000.00 </th>
						<th>0000.00 </th>
					</tr>
					<tr>
						<th>TLH PATIENT</th>
						<th>100 </th>
						<th>0 </th>
						<th>0000.00 </th>
						<th>0000.00 </th>
					</tr>
					<tr>
						<th>WINDOWS TKT</th>
						<th>100 </th>
						<th>0 </th>
						<th>0000.00 </th>
						<th>0000.00 </th>
					</tr>
				</tbody>
			</table>

			<div class="heading">
				<b><u>H: TOTALS</u></b>
			</div>
			<div class="row">
				<div class="col-md-6">
					<b>
						<div>Total Remit (A): </div><br>
						<div>Net Amount To be Deposited: Rs </div>
					</b>
				</div>
				<div class="col-md-6">
					<b>
						<div>0</div><br>
						<div>0</div>
					</b>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="border2">
			<table class="table2">
				<thead>
					<tr>
						<th>STATE NAME </th>
						<th>CHANDIGARH</th>
						<th>DELHI </th>
						<th>HARYANA </th>
						<th>HIMACHAL PRADESH </th>
						<th>JAMMU & KASMIR </th>
						<th>PUNJAB </th>
						<th>RAJASTHAN </th>
						<th>UTTARAKHAND </th>
						<th>UTTAR PARDESH </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>STATE AMOUNT </th>
						<th>.00</th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
					</tr>
					<tr>
						<th>STATE TAX </th>
						<th>.00</th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
						<th>.00 </th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="text-center main_heading">
			<b><u>TRIPS & DETAILS</u></b>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>TRIP NO </th>
					<th>DRIVER NAME</th>
					<th>DRIVER NO </th>
					<th>BUS NO </th>
					<th>TRIP DATE </th>
					<th>ROUTE NO </th>
					<th>ROUTE KM </th>
					<th>TRIP START </th>
					<th>TRIP END </th>
					<th>ADVANCE BOOK </th>
					<th>TOTAL COLLECTION </th>
					<th>NET TRIP AMT </th>
					<th>EPKM </th>
				</tr>
			</thead>
			<tbody>
				<?php $__currentLoopData = $waybill->schedule->scheduleDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<th><?php echo e($trip->tripDetails->id); ?></th>
					<th><?php echo e($waybill->crew->employees->where('employee_designation_id',1)->first()->name); ?></th>
					<th><?php echo e($waybill->crew->employees->where('employee_designation_id',1)->first()->employee_code); ?></th>
					<th><?php echo e($waybill->vehicle->register_number); ?></th>
					<th><?php echo e($trip->tripDetails->start); ?></th>
					<th><?php echo e($trip->tripDetails->route->route_code); ?></th>
					<th><?php echo e($trip->tripDetails->route->km); ?> km</th>
					<th><?php echo e($trip->tripDetails->route->fromStageData->name); ?></th>
					<th><?php echo e($trip->tripDetails->route->toStageData->name); ?></th>
					<th>00.00</th>
					<th>00.00</th>
					<th>00.00</th>
					<th>00.00</th>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<th>Records:0</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th>0.00</th>
					<th></th>
					<th></th>
					<th>0.00</th>
					<th>0.00</th>
					<th>0.00</th>
					<th></th>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="row main_heading">
		<br>
		<div class="col-md-4">
			<div class="pull-left">
				<b>Sign of Conductor</b>
			</div>
		</div>
		<div class="col-md-4">
			<div class="text-center">
				<b>Sign Of Clerk</b>
			</div>
		</div>
		<div class="col-md-4">
			<div class="pull-right">
				<b>Sign Of Cashier</b>
			</div>
		</div>
	</div>
</section>

<div class="clearfix"></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>