<style>
/*horizontal line*/
.first_hori_line{
    border: none;
    height: 3px;
    /* Set the hr color */
    color: #333; /* old IE */
    background-color: #333; /* Modern Browsers */
}
.heading{
	padding: 15px 50px 10px 0px;
	font-size: 18px;
}
.border1{
	border: 1px solid black;
  	padding: 10px 50px 10px 5px;
}
.border2{
	border: 1px solid black;
  	padding: 10px 20px 10px 20px;
}
.main_heading{
	font-size: 20px;
	text-align: center;
}
.updown_border{
	border: 1px ;
	border-style: groove;
}
.table{
	width:100%
}
.table1{
	border-collapse: separate;
    border-spacing: 5px;
}
.table2{
	border-collapse: separate;
    border-spacing: 6px;
    width:100%;
}
.row1_second{
	position: 100px 20px 50px 20px;
}
.split_left {
  position: left;
  width: 50%;
}
.split_right {
  padding: 0px 10px 10px 400px;
  width: 50%;
}


</style>

	<div class="row">
		<div class="main_heading">
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
			<table class="table">
				<thead>
					<tr>
						<th>
							Cndtr Code: <?php echo e($waybill->crew->employees->where('employee_designation_id',1)->first()->employee_code); ?>

						</th>
						<th>
							Name: <?php echo e($waybill->crew->employees->where('employee_designation_id',1)->first()->name); ?>

						</th>
						<th>
						</th>
						<th>
							Bus Number : <?php echo e($waybill->vehicle->register_number); ?>

						</th>
					</tr>
					<tr>
						<th>
							Driver Code: <?php echo e($waybill->crew->employees->where('employee_designation_id',2)->first()->employee_code); ?>

						</th>
						<th>
							EBTM NO :
						</th>
						<th>
							Date : <?php echo e($waybill->from_date); ?>

						</th>
						<th>
							BusService : <?php echo e($waybill->vehicle->vehicleType->name); ?>

						</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<div>
	<div>
	<div class="split_left">
			<div class="heading">
				<b><u>A: Conductor Booking Details in Rs</u></b>
			</div>
			<div>
				<div>Passanger Amount : </div>
				<div>00.00</div>
				<div>Luggage Amount : </div>
				<div>00.00</div>
				<div>Passes Amount : </div>
				<div>00.00</div>
				<div>Collections : </div>
				<div>00.00</div>
				<div>Total Amount : </div>
				<div>00.00</div>
				<div>Toll Amount : </div>
				<div>00.00</div>
				<div>Misc. Amount : </div>
				<div>00.00</div>
				<div>Toll Tax Amount : </div>
				<div>00.00</div>
				<div>Penality Amount : </div>
				<div>00.00</div>
			</div>

			<div class="heading">
				<b><u>B: Bus Stand Window Booking</u></b>
			</div>
				<div>
					<b>
						<div>Passanger Count : </div>
						<div>a-Adda Bkg Amount : </div>
						<div>b-Adv Bkg EBTM : </div>
						<div>Total Amount : </div>
					</b>
					<b>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div>
						<div>00.00</div>
					</b>
				</div>

			<div class="heading">
				<b><u>C: Expenses</u></b>
			</div>
			<div>
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
	<div class="split_right">
		<div class="heading">
			<b><u>D: Total Tickets Issued :</u></b>
		</div>
		<div class="heading">
			<b>0</b>
		</div>
		<div class="heading">
			<b><u>E: Classification of Categories</u></b>
		</div>
		<div>
			<b>
				<div>Passanger of C.B. : </div>
				<div>Pssngr of Window Booking : </div>
				<div>Luggage Tickets : </div>
				<div>Pssngr with 100% Concession : </div>
				<div>Pssngr with 50% Concession : </div>
				<div>Insp Ticket Count : </div>
				<div>Insp Ticket Amount : </div>
				<div>Traffic Inspection : </div>

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
				
					<b>
						<div>Total Remit (A): </div><br>
						<div>Net Amount To be Deposited: Rs </div>
					</b>
			
					<b>
						<div>0</div><br>
						<div>0</div>
					</b>
	
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

