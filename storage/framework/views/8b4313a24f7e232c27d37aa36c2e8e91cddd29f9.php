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
	padding: 5px 50px 10px 0px;
	font-size: 16px;
}
.border1{
	border: 1px solid black;
  	padding: 10px 50px 10px 5px;
}
.border2{
	border: 1px solid black;
  	padding: 50px 50px 50px 50px;
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
	/*border-collapse: separate;*/
    border-spacing: 5px;
}
.table2{
	/*border-collapse: separate;*/
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
.sign_all {
  /*position: left;*/
  /*padding: 0px 10px 10px 400px;*/
  width: 100%;
}
.sign_con {
  position: left;
  /*padding: 0px 10px 10px 400px;*/
  width: 150px;
}
.sign_clerk {
 /*position:  600px;*/
  padding: 0px 0px 0px 600px;
  /*width: 50%;*/
}
.sign_cash {
  /*position: right;*/
  padding: 0px 0px 0px 85%;
  /*width: 50%;*/
}
.state_tax
{
	 width:600px; font-size: 13px;margin-top: 603px !important;
}
.grid-containers {
 /*display: grid;*/
 font-weight: bold;
  grid-gap: 100px;
  width:750px;
  /*background-color: #2196F3;*/
  /*padding: 100px;*/
}
.sign{
	width:100%;
}
.conductor_section{
	float: left;
	font-size: 13px;
	font-weight: bold;
	
}
.right_section
{
	float: right; font-size: 13px;font-weight: bold;
}
.trip_detail{
	font-size: 13px;margin-top: 50px !important;
}

/*.row_table {
   
    position: initial;
    padding-top: 23px !important;
}*/

</style>


	<div class="row" >
		<div class="main_heading">
			
			<b>PEPSU ROAD TRANSPORT<br><?php echo e(strtoupper($depot_name)); ?><br>For EWaybill: <?php echo e($waybill->code); ?><br>
			CONDUCTOR WAYBILL [CW] </b>
		</div>
		<div class="pull-left">
			<b><?php echo date("l,")."  ".date("F d,Y"); ?></b>
		</div>
		<hr class="first_hori_line">
	</div>
	<div class="row" >
		<div class="border1">
			<table class="table">
				<thead>
					<tr>
						<th>
							Cndtr Code: <?php echo e($waybill->conductor->employee_code); ?>

						</th>
						<th>
							Name: <?php echo e($waybill->conductor->name); ?>

						</th>
						<th>
						</th>
						<th>
							Bus Number : <?php echo e($waybill->vehicle->register_number); ?>

						</th>
					</tr>
					<tr>
						<th>
							Driver Code: <?php echo e($waybill->driver->employee_code); ?>

						</th>
						<th>
							EBTM NO : <?php echo e($waybill->etm->imei); ?>

						</th>
						<th>
							Date : <?php echo e($waybill->date); ?>

						</th>
						<th>
							BusService : <?php echo e($waybill->vehicle->vehicleType->name); ?>

						</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>

	<div class="conductor_section">

				<h4><u>A: Conductor Booking Details in Rs</u></h4>
				
				<table>
				
				<tr>
					<td>Passanger Amount :</td>
					<td><?php echo e($waybill->passengerAmount()); ?></td>
				</tr>
				<tr>
					<td>Luggage Amount : </td>
					<td><?php echo e($waybill->luggageAmount()); ?></td>
				</tr>
				<tr>
					<td>Passes Amount :</td>
					<td><?php echo e($waybill->passesAmount()); ?></td>
				</tr>
				<tr>
					<td>Collections :</td>
					<td>0</td>
				</tr>
				<tr>
					<td>Total Amount :</td>
					<td><?php echo e($waybill->totalAmount()); ?></td>
				</tr>
				<tr>
					<td>Toll Amount :</td>
					<td>0</td>
				</tr>
				<tr>
					<td>Misc. Amount :</td>
					<td>0</td>
				</tr>
				<tr>
					<td>Toll Tax Amount :</td>
					<td><?php echo e($waybill->expenses->where('expense_type_id',1)->sum('amount')); ?></td>
				</tr>
				<tr>
					<td>Penality Amount :</td>
					<td><?php echo e($waybill->penalities->sum('amount')); ?></td>
				</tr>
				</table>
				
			

				<h4><u>B: Bus Stand Window Booking</u></h4>
				<table>
				
					<tr>
						<td>Passanger Count :</td>
						<td>0</td>
					</tr>
					<tr>
						<td>a-Adda Bkg Amount :</td>
						<td>0</td>
					</tr>
					<tr>
						<td>b-Adv Bkg EBTM :</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Total Amount :</td>
						<td>0</td>
					</tr>
				</table>
					<h4><u>C: Expenses</u></h4>
			<table>
				<?php
					$toll_tax=$waybill->expenses->where('expense_type_id',1)->sum('amount');
					$ticket_refund=$waybill->expenses->where('expense_type_id',2)->sum('amount');
					$bus_stand_fee=$waybill->expenses->where('expense_type_id',3)->sum('amount');
					$diesel=$waybill->expenses->where('expense_type_id',4)->sum('amount');
					$others=$waybill->expenses->where('expense_type_id',5)->sum('amount');
					$total_expense_amount=$toll_tax+$ticket_refund+$bus_stand_fee+$diesel+$others;
				?>
				<tr>
					<td>Toll Tax Expenses :</td>
					<td><?php echo e($toll_tax); ?></td>
				</tr>
				<tr>
					<td>Ticket Refund :</td>
					<td><?php echo e($ticket_refund); ?></td>
				</tr>
				<tr>
					<td>Bus Stand Fee : </td>
					<td><?php echo e($bus_stand_fee); ?></td>
				</tr>
				<tr>
					<td>Diesel Amount : </td>
					<td><?php echo e($diesel); ?></td>
				</tr>
				<tr>
					<td >Other Payments : </td>
					<td><?php echo e($others); ?></td>
				</tr>
				<tr>
					<td>Total Amount :</td>
					<td><?php echo e($total_expense_amount); ?></td>
				</tr>
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
				<tr>
					<td>G: Earning Per KM (EPKM) :</td>
					<td><?php echo e(bcdiv($sum_of_epkm,1,2)); ?></td>
				</tr>
				<tr>
					<td>Earning Per KM with pass Amount :</td>
					<td><?php echo e($rounded_sum_of_epkm_with_pass_amount); ?></td>
				</tr>
			</table>
				</div>
	<div class="right_section">
		<h4><u>D: Total Tickets Issued : </u><?php echo e($waybill->tickets->sum('count')); ?></h4>
		<h4><u>E: Classification of Categories</u></h4>
		<table >
			<tr>
				<td>Passanger of C.B. : </td>
				<td><?php echo e($waybill->passengerOfCB()); ?></td>
			</tr>
			<tr>
				<td>Pssngr of Window Booking :</td>
				<td>0</td>
			</tr>
			<tr>
				<td>Luggage Tickets :</td>
				<td><?php echo e($waybill->luggageTicket()); ?></td>
			</tr>
			<tr>
				<td>Pssngr with 100% Concession : </td>
				<td><?php echo e($waybill->passengerHundredPercentageConcession()); ?></td>
			</tr>
			<tr>
				<td>Pssngr with 50% Concession :</td>
				<td><?php echo e($waybill->passengerFiftyPercentageConcession()); ?></td>
			</tr>
			<tr>
				<td>Insp Ticket Count :</td>
				<td><?php echo e($waybill->penalities->count('waybill_id')); ?></td>
			</tr>
			<tr>
				<td>Insp Ticket Amount : </td>
				<td><?php echo e($waybill->penalities->sum('amount')); ?></td>
			</tr>
			<tr>
				<td>Traffic Inspection : </td>
				<td>0</td>
			</tr>
		</table>
		<h4><u>F: Concession Details </u></h4>
			<table >
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
			<h4><u>H: TOTALS</u></h4>
			<table>
				<?php
					$total_remit=$waybill->totalAmount();
					$net_amount=$total_remit-$total_expense_amount;
				?>
				<tr>
					<td>Total Remit (A): </td>
					<td><?php echo e($total_remit); ?></td>
				</tr>
				<tr>
					<td>Net Amount To be Deposited: Rs</td>
					<td><?php echo e($net_amount); ?></td>
				</tr>
			</table>
	</div>
	<br>
	<div class="row_table" >
		  <table class="state_tax"  border="1" >
                
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
                
                <tbody>
                    <tr>
                        <td>STATE AMOUNT </td>
                        <td>.00</td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                    </tr>
                    <tr>
                        <td>STATE TAX </td>
                        <td>.00</td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                        <td>.00 </td>
                    </tr>
                </tbody>
            </table>
	</div>
	<br><br><br>
	<div class="row">
		<div class="trip_detail">
			<h4><u>TRIPS & DETAILS</u></h4>
			<table >
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
				<?php $i=1; ?>
				<?php $__currentLoopData = $waybill->closedTrips(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<?php
						$total_km=$trip->km;
						$total_collection=$trip->total_collection_amount;
						$epkm=0;
						if($total_collection>0){
							$epkm=$total_collection/$total_km;
						}
					?>
					<th><?php echo e($i++); ?></th>
					<th><?php echo e($waybill->driver->name); ?></th>
					<th><?php echo e($waybill->driver->employee_code); ?></th>
					<th><?php echo e($waybill->vehicle->register_number); ?></th>
					<th><?php echo e($trip->start_time); ?></th>
					<th><?php echo e($trip->route->code); ?></th>
					<th><?php echo e($total_km); ?></th>
					<th><?php echo e($trip->fromStage->name); ?></th>
					<th><?php echo e($trip->toStage->name); ?></th>
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
	</div>

	<div class="grid-containers">

        <table class="sign" >
            <tr>
            <td><b>Sign of Conductor</b></td>
            <td><b>Sign Of Clerk</b></td>
            <td><b>Sign Of Cashier</b></td>
            </tr>
        </table>
        
    </div>	

