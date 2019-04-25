 
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
	<a href="<?php echo e(route('waybill')); ?>">
		<button class="btn btn-default pull-right"><i class="fa fa-times"></i> </button>
	</a>
 	<button class="btn btn-default pull-right" onclick="downloadWayBill(<?php echo e($waybill->id); ?>)">Download PDF  <i class="fa fa-download"></i> </button>
</div>
	<div class="row">
		<div class="text-center main_heading">
			<b>PEPSU ROAD TRANSPORT<br><?php echo e(strtoupper($depot_name)); ?><br>For EWaybill: <?php echo e($waybill->code); ?><br>
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
					Cndtr Code: <?php $__currentLoopData = $waybill->waybillLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waybilllog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($waybilllog->conductor->employee_code); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<br>
					Driver Code:  <?php $__currentLoopData = $waybill->waybillLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waybilllog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($waybilllog->driver->employee_code); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</b>
			</div>
			<div class="col-md-3">
				<b>
					Name:  <?php $__currentLoopData = $waybill->waybillLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waybilllog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($waybilllog->conductor->name); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<br>
					EBTM NO : <?php echo e($waybill->etm->imei); ?>

				</b>
			</div>
			<div class="col-md-3">
				<b>
					<br>
					Date : <?php echo e($waybill->date); ?>

				</b>
			</div>
			<div class="col-md-3">
				<b>
					Bus Number :  <?php $__currentLoopData = $waybill->waybillLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waybilllog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($waybilllog->vehicle->register_number); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<br>
					Bus Service :  <?php $__currentLoopData = $waybill->waybillLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waybilllog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($waybilllog->vehicle->vehicleType->name); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
						<div><?php echo e($waybill->passengerAmount()); ?></div>
						<div><?php echo e($waybill->luggageAmount()); ?></div>
						<div><?php echo e($waybill->passesAmount()); ?></div>
						<div>0</div>
						<div><?php echo e($waybill->totalAmount()); ?></div><br>
						<div>0</div>
						<div>0</div>
						<div><?php echo e($waybill->expenses->where('expense_type_id',1)->sum('amount')); ?></div><br>
						<div><?php echo e($waybill->penalities->sum('amount')); ?></div>
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
						<div>0</div>
						<div>0</div>
						<div>0</div>
						<div>0</div>
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
						<?php
							$toll_tax=$waybill->expenses->where('expense_type_id',1)->sum('amount');
							$ticket_refund=$waybill->expenses->where('expense_type_id',2)->sum('amount');
							$bus_stand_fee=$waybill->expenses->where('expense_type_id',3)->sum('amount');
							$diesel=$waybill->expenses->where('expense_type_id',4)->sum('amount');
							$others=$waybill->expenses->where('expense_type_id',5)->sum('amount');
							$total_expense_amount=$toll_tax+$ticket_refund+$bus_stand_fee+$diesel+$others;
						?>
						<div><?php echo e($toll_tax); ?></div>
						<div><?php echo e($ticket_refund); ?></div>
						<div><?php echo e($bus_stand_fee); ?></div>
						<div><?php echo e($diesel); ?></div>
						<div><?php echo e($others); ?></div>
						<div><?php echo e($total_expense_amount); ?></div><br>
						<?php
							$sum_of_total_km=$waybill->trips->sum('km');
							$sum_of_total_collection=$waybill->trips->sum('total_collection_amount');
							$sum_of_epkm=0;
							$rounded_sum_of_epkm_with_pass_amount=0;
							if($sum_of_total_collection>0){
								$sum_of_epkm=$sum_of_total_km/$sum_of_total_collection;
								$pass_amount=$waybill->passesAmount();
								$pass_disc_amount=$waybill->totalConcessionDiscountAmount();
								$sum_of_epkm_with_pass_amount=(($sum_of_total_collection-$pass_amount)+$pass_disc_amount)/$sum_of_total_km;
								$rounded_sum_of_epkm_with_pass_amount=bcdiv($sum_of_epkm_with_pass_amount,1,2);
							}
						?>
						<div><?php echo e(bcdiv($sum_of_epkm,1,2)); ?></div>
						<div><?php echo e($rounded_sum_of_epkm_with_pass_amount); ?></div>
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
						<b><?php echo e($waybill->tickets->count()); ?></b>
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
						<div><?php echo e($waybill->passengerOfCB()); ?></div>
						<div>0</div>
						<div><?php echo e($waybill->luggageTicket()); ?></div>
						<div><?php echo e($waybill->passengerHundredPercentageConcession()); ?></div>
						<div><?php echo e($waybill->passengerFiftyPercentageConcession()); ?></div>
						<div><?php echo e($waybill->penalities->count('waybill_id')); ?></div>
						<div><?php echo e($waybill->penalities->sum('amount')); ?></div>
						<?php 
						if($waybill->inspectorVisit() > 0 ){?>
							<div><i class="fa fa-check" aria-hidden="true"></i></div>
						<?php	}else{ ?>
							<div><i class="fa fa-times" aria-hidden="true"></i></i></div>
						<?php	}
						?>
						
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
						<th><?php echo e($waybill->tickets->where('concession_id',1)->sum('count')); ?> </th>
						<th><?php echo e($waybill->tickets->where('concession_id',1)->sum('total_amount')); ?></th>
						<?php
							$disc = 00.00;
							$tot = $waybill->tickets->where('concession_id',1)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',1)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th><?php echo e($disc); ?></th>
					</tr>
					<tr>
						<th>CANCER PAT</th>
						<th>100 </th>
						<th><?php echo e($waybill->tickets->where('concession_id',2)->sum('count')); ?> </th>
						<th><?php echo e($waybill->tickets->where('concession_id',2)->sum('total_amount')); ?></th>
						<?php
							$tot = $waybill->tickets->where('concession_id',2)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',2)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th><?php echo e($disc); ?></th>
					</tr>
					<tr>
						<th>FREEDOM F</th>
						<th>100 </th>
						<th><?php echo e($waybill->tickets->where('concession_id',3)->sum('count')); ?> </th>
						<th><?php echo e($waybill->tickets->where('concession_id',3)->sum('total_amount')); ?></th>
						<?php
							$tot = $waybill->tickets->where('concession_id',3)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',3)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th><?php echo e($disc); ?></th>
					</tr>
					<tr>
						<th>OLD WOMAN</th>
						<th>50 </th>
						<th><?php echo e($waybill->tickets->where('concession_id',4)->sum('count')); ?> </th>
						<th><?php echo e($waybill->tickets->where('concession_id',4)->sum('total_amount')); ?></th>
						<?php
							$tot = $waybill->tickets->where('concession_id',4)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',4)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th><?php echo e($disc); ?></th>
					</tr>
					<tr>
						<th>P HANDICAPP</th>
						<th>50 </th>
						<th><?php echo e($waybill->tickets->where('concession_id',5)->sum('count')); ?> </th>
						<th><?php echo e($waybill->tickets->where('concession_id',5)->sum('total_amount')); ?></th>
						<?php
							$tot = $waybill->tickets->where('concession_id',5)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',5)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th><?php echo e($disc); ?></th>
					</tr>
					<tr>
						<th>POLICE</th>
						<th>100 </th>
						<th><?php echo e($waybill->tickets->where('concession_id',6)->sum('count')); ?> </th>
						<th><?php echo e($waybill->tickets->where('concession_id',6)->sum('total_amount')); ?></th>
						<?php
							$tot = $waybill->tickets->where('concession_id',6)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',6)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th><?php echo e($disc); ?></th>
					</tr>
					<tr>
						<th>PRESS REPOR</th>
						<th>100 </th>
						<th><?php echo e($waybill->tickets->where('concession_id',7)->sum('count')); ?> </th>
						<th><?php echo e($waybill->tickets->where('concession_id',7)->sum('total_amount')); ?></th>
						<?php
							$tot = $waybill->tickets->where('concession_id',7)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',7)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th><?php echo e($disc); ?></th>
					</tr>
					<tr>
						<th>STUDENT PAS</th>
						<th>100 </th>
						<th><?php echo e($waybill->tickets->where('concession_id',8)->sum('count')); ?> </th>
						<th><?php echo e($waybill->tickets->where('concession_id',8)->sum('total_amount')); ?></th>
						<?php
							$tot = $waybill->tickets->where('concession_id',8)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',8)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th><?php echo e($disc); ?></th>
					</tr>
					<tr>
						<th>TLH PATIENT</th>
						<th>100 </th>
						<th><?php echo e($waybill->tickets->where('concession_id',9)->sum('count')); ?> </th>
						<th><?php echo e($waybill->tickets->where('concession_id',9)->sum('total_amount')); ?></th>
						<?php
							$tot = $waybill->tickets->where('concession_id',9)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',9)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th><?php echo e($disc); ?></th>
					</tr>
					<tr>
						<th>WINDOWS TKT</th>
						<th>100 </th>
						<th><?php echo e($waybill->tickets->where('concession_id',10)->sum('count')); ?> </th>
						<th><?php echo e($waybill->tickets->where('concession_id',10)->sum('total_amount')); ?></th>
						<?php
							$tot = $waybill->tickets->where('concession_id',10)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',10)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th><?php echo e($disc); ?></th>
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
						<?php
							$total_remit=$waybill->totalAmount();
							$net_amount=$total_remit-$total_expense_amount;
						?>
						<div><?php echo e($total_remit); ?></div><br>
						<div><?php echo e($net_amount); ?></div>
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
						<th><?php echo e($waybill->stateCollection->where('state_id',7)->sum('fare')); ?></th>
						<th><?php echo e($waybill->stateCollection->where('state_id',10)->sum('fare')); ?></th>
						<th><?php echo e($waybill->stateCollection->where('state_id',13)->sum('fare')); ?></th>
						<th><?php echo e($waybill->stateCollection->where('state_id',14)->sum('fare')); ?></th>
						<th><?php echo e($waybill->stateCollection->where('state_id',15)->sum('fare')); ?></th>
						<th><?php echo e($waybill->stateCollection->where('state_id',28)->sum('fare')); ?></th>
						<th><?php echo e($waybill->stateCollection->where('state_id',29)->sum('fare')); ?></th>
						<th><?php echo e($waybill->stateCollection->where('state_id',34)->sum('fare')); ?></th>
						<th><?php echo e($waybill->stateCollection->where('state_id',33)->sum('fare')); ?></th>
					</tr>
					<tr>
						<th>STATE TAX </th>
						<?php
						$tax = $waybill->getStateTax(7);
						if($tax){
						$collection = $waybill->stateCollection->where('state_id',7)->sum('fare');
						$state_tax = $collection*(int)$tax->percentage/100;
						}else{
							$state_tax = 0;
						}
	
						?>
						<th><?php echo e($state_tax); ?></th>
						<?php
						$tax = $waybill->getStateTax(10);
						if($tax){
						$collection = $waybill->stateCollection->where('state_id',10)->sum('fare');
						$state_tax = $collection*(int)$tax->percentage/100;
						}else{
							$state_tax = 0;
						}

						?>
						<th><?php echo e($state_tax); ?></th>
						<?php
						$tax = $waybill->getStateTax(13);
						if($tax){
						$collection = $waybill->stateCollection->where('state_id',13)->sum('fare');
						$state_tax = $collection*(int)$tax->percentage/100;
						}else{
							$state_tax = 0;
						}
			
						?>
						<th><?php echo e($state_tax); ?></th>
						<?php
						$tax = $waybill->getStateTax(14);
						if($tax){
						$collection = $waybill->stateCollection->where('state_id',14)->sum('fare');
						$state_tax = $collection*(int)$tax->percentage/100;
						}else{
							$state_tax = 0;
						}
					
						?>
						<th><?php echo e($state_tax); ?></th>
						<?php
						$tax = $waybill->getStateTax(15);
						if($tax){
						$collection = $waybill->stateCollection->where('state_id',15)->sum('fare');
						$state_tax = $collection*(int)$tax->percentage/100;
						}else{
							$state_tax = 0;
						}
			
						?>
						<th><?php echo e($state_tax); ?> </th>
						<?php
						$tax = $waybill->getStateTax(28);
						if($tax){
						$collection = $waybill->stateCollection->where('state_id',28)->sum('fare');
						$state_tax = $collection*(int)$tax->percentage/100;
						}else{
							$state_tax = 0;
						}
						?>
						<th><?php echo e($state_tax); ?> </th>
						<?php
						$tax = $waybill->getStateTax(29);
						if($tax){
						$collection = $waybill->stateCollection->where('state_id',29)->sum('fare');
						$state_tax = $collection*(int)$tax->percentage/100;
						}else{
							$state_tax = 0;
						}
		
						?>
						<th><?php echo e($state_tax); ?></th>
						<?php
						$tax = $waybill->getStateTax(34);
						if($tax){
						$collection = $waybill->stateCollection->where('state_id',34)->sum('fare');
						$state_tax = $collection*(int)$tax->percentage/100;
						}else{
							$state_tax = 0;
						}
		
						?>
						<th><?php echo e($state_tax); ?></th>
						<?php
						$tax = $waybill->getStateTax(33);
						if($tax){
						$collection = $waybill->stateCollection->where('state_id',33)->sum('fare');
						$state_tax = $collection*(int)$tax->percentage/100;
						}else{
							$state_tax = 0;
						}

						?>
						<th><?php echo e($state_tax); ?></th>
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
				<?php $__currentLoopData = $waybill->trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<?php
						if($trip->has_closed){
							$total_km=$trip->km;
							$trip_start=$trip->fromStage->name;
							$trip_end=$trip->toStage->name;
                			$total_collection=$trip->totalTripCollection();
                			$epkm=0;
                			if($total_collection>0){
                    			$epkm=$total_collection/$total_km;
                			}
						}else{
							$total_km=0;
							$trip_start="-";
							$trip_end="-";
                			$total_collection=$trip->totalTripCollection();
                			$epkm=0;
						}
						
					?>
					<th><?php echo e($loop->iteration); ?></th>
					<th><?php echo e($trip->driver->name); ?></th>
					<th><?php echo e($trip->driver->employee_code); ?></th>
					<th><?php echo e($trip->vehicle->register_number); ?></th>
					<th><?php echo e($trip->start_time); ?></th>
					<th><?php echo e($trip->route->code); ?></th>
					<th><?php echo e($total_km); ?></th>
					<th><?php echo e($trip_start); ?></th>
					<th><?php echo e($trip_end); ?></th>
					<th>0</th>
					<th><?php echo e($total_collection); ?></th>
					<th><?php echo e($total_collection); ?></th><!-- net trip amount=advance_bk_amount+total_collection_amount -->
					<th><?php echo e(bcdiv($epkm,1,2)); ?></th>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<th colspan="2">Records:  <?php echo e($waybill->trips->count('trip_id')); ?></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th><?php echo e($sum_of_total_km); ?></th>
					<th></th>
					<th></th>
					<th>0.00</th><!-- sum of advance booking -->
					<th><?php echo e($sum_of_total_collection); ?></th>
					<th><?php echo e($sum_of_total_collection); ?></th><!-- net trip amount=advance_bk_amount+total_collection_amount -->
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