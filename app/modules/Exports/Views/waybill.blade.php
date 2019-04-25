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
.trip_row{
    font-size: 12px;
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
			
			<b>PEPSU ROAD TRANSPORT<br>{{strtoupper($depot_name)}}<br>For EWaybill: {{ $waybill->code}}<br>
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
							Cndtr Code: @foreach($waybill->waybillLogs  as $waybilllog){{$waybilllog->conductor->employee_code}}, @endforeach
						</th>
						<th>
							Name: @foreach($waybill->waybillLogs  as $waybilllog){{$waybilllog->conductor->name}}, @endforeach
						</th>
						<th>
						</th>
						<th>
							Bus Number : @foreach($waybill->waybillLogs  as $waybilllog){{$waybilllog->vehicle->register_number}}, @endforeach
						</th>
					</tr>
					<tr>
						<th>
							Driver Code: @foreach($waybill->waybillLogs  as $waybilllog){{$waybilllog->driver->employee_code}}, @endforeach
						</th>
						<th>
							EBTM NO : {{$waybill->etm->imei}}
						</th>
						<th>
							Date : {{$waybill->date}}
						</th>
						<th>
							BusService : @foreach($waybill->waybillLogs  as $waybilllog){{$waybilllog->vehicle->vehicleType->name}}, @endforeach
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
					<td>{{$waybill->passengerAmount()}}</td>
				</tr>
				<tr>
					<td>Luggage Amount : </td>
					<td>{{$waybill->luggageAmount()}}</td>
				</tr>
				<tr>
					<td>Passes Amount :</td>
					<td>{{$waybill->passesAmount()}}</td>
				</tr>
				<tr>
					<td>Collections :</td>
					<td>0</td>
				</tr>
				<tr>
					<td>Total Amount :</td>
					<td>{{$waybill->totalAmount()}}</td>
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
					<td>{{$waybill->expenses->where('expense_type_id',1)->sum('amount')}}</td>
				</tr>
				<tr>
					<td>Penality Amount :</td>
					<td>{{$waybill->penalities->sum('amount')}}</td>
				</tr>
				</table>
				
			

				<h4><u>B: Bus Stand Window Booking</u></h4>
				<table>
					<?php
						$advance_booking_passenger_count=$waybill->advanceBooking()->sum('agent_ticket_count');
						$advance_booking_amount=$waybill->sumOfAdvanceBookingAmount();
						$adda_booking_amount=$waybill->addaFee->sum('amount');
						$advance_booking_total_amount=$advance_booking_amount+$adda_booking_amount;
					?>
					<tr>
						<td>Passanger Count :</td>
						<td>{{$advance_booking_passenger_count}}</td>
					</tr>
					<tr>
						<td>a-Adda Bkg Amount :</td>
						<td>0</td>
					</tr>
					<tr>
						<td>b-Adv Bkg EBTM :</td>
						<td>{{$advance_booking_amount}}</td>
					</tr>
					<tr>
						<td>Total Amount :</td>
						<td>{{$advance_booking_total_amount}}</td>
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
					<td>{{$toll_tax}}</td>
				</tr>
				<tr>
					<td>Ticket Refund :</td>
					<td>{{$ticket_refund}}</td>
				</tr>
				<tr>
					<td>Bus Stand Fee : </td>
					<td>{{$bus_stand_fee}}</td>
				</tr>
				<tr>
					<td>Diesel Amount : </td>
					<td>{{$diesel}}</td>
				</tr>
				<tr>
					<td >Other Payments : </td>
					<td>{{$others}}</td>
				</tr>
				<tr>
					<td>Total Amount :</td>
					<td>{{$total_expense_amount}}</td>
				</tr>
				<?php
					$sum_of_total_km=$waybill->trips->whereNotIn('total_number_ticket',0)->sum('km');
					$sum_of_total_collection=$waybill->trips->whereNotIn('total_number_ticket',0)->sum('total_collection_amount');
					$sum_of_epkm=0;
					$rounded_sum_of_epkm_with_pass_amount=0;
					if($sum_of_total_km>0){
						$sum_of_epkm=$sum_of_total_collection/$sum_of_total_km;
						$pass_amount=$waybill->passesAmount();
						$pass_disc_amount=$waybill->totalConcessionDiscountAmount();
						if($pass_amount){
							$sum_of_epkm_with_pass_amount=(($sum_of_total_collection-$pass_amount)+$pass_disc_amount)/$sum_of_total_km;
							$rounded_sum_of_epkm_with_pass_amount=bcdiv($sum_of_epkm_with_pass_amount,1,2);
						}
					}
				?>
				<tr>
					<td>G: Earning Per KM (EPKM) :</td>
					<td>{{bcdiv($sum_of_epkm,1,2)}}</td>
				</tr>
				<tr>
					<td>Earning Per KM with pass Amount :</td>
					<td>{{$rounded_sum_of_epkm_with_pass_amount}}</td>
				</tr>
			</table>
				</div>
	<div class="right_section">
		<h4><u>D: Total Tickets Issued : </u>{{$waybill->tickets->sum('count')}}</h4>
		<h4><u>E: Classification of Categories</u></h4>
		<table >
			<tr>
				<td>Passanger of C.B. : </td>
				<td>{{$waybill->passengerOfCB()}}</td>
			</tr>
			<tr>
				<td>Pssngr of Window Booking :</td>
				<td>{{$advance_booking_passenger_count}}</td>
			</tr>
			<tr>
				<td>Luggage Tickets :</td>
				<td>{{$waybill->luggageTicket()}}</td>
			</tr>
			<tr>
				<td>Pssngr with 100% Concession : </td>
				<td>{{$waybill->passengerHundredPercentageConcession()}}</td>
			</tr>
			<tr>
				<td>Pssngr with 50% Concession :</td>
				<td>{{$waybill->passengerFiftyPercentageConcession()}}</td>
			</tr>
			<tr>
				<td>Insp Ticket Count :</td>
				<td>{{$waybill->penalities->count('waybill_id')}}</td>
			</tr>
			<tr>
				<td>Insp Ticket Amount : </td>
				<td>{{$waybill->penalities->sum('amount')}}</td>
			</tr>
			<tr>
				<td>Traffic Inspection : </td>
				<?php 
				if($waybill->inspectorVisit() > 0 ){?>
					<td>Verified</td>
				<?php	}else{ ?>
					<td>X</td>
				<?php	}
				?>
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
						<th>{{ $waybill->tickets->where('concession_id',1)->sum('count') }} </th>
						<th>{{ $waybill->tickets->where('concession_id',1)->sum('total_amount') }}</th>
						<?php
							$disc = 00.00;
							$tot = $waybill->tickets->where('concession_id',1)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',1)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th>{{$disc}}</th>
					</tr>
					<tr>
						<th>CANCER PAT</th>
						<th>100 </th>
						<th>{{ $waybill->tickets->where('concession_id',2)->sum('count') }} </th>
						<th>{{ $waybill->tickets->where('concession_id',2)->sum('total_amount') }}</th>
						<?php
							$tot = $waybill->tickets->where('concession_id',2)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',2)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th>{{$disc}}</th>
					</tr>
					<tr>
						<th>FREEDOM F</th>
						<th>100 </th>
						<th>{{ $waybill->tickets->where('concession_id',3)->sum('count') }} </th>
						<th>{{ $waybill->tickets->where('concession_id',3)->sum('total_amount') }}</th>
						<?php
							$tot = $waybill->tickets->where('concession_id',3)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',3)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th>{{$disc}}</th>
					</tr>
					<tr>
						<th>OLD WOMAN</th>
						<th>50 </th>
						<th>{{ $waybill->tickets->where('concession_id',4)->sum('count') }} </th>
						<th>{{ $waybill->tickets->where('concession_id',4)->sum('total_amount') }}</th>
						<?php
							$tot = $waybill->tickets->where('concession_id',4)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',4)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th>{{$disc}}</th>
					</tr>
					<tr>
						<th>P HANDICAPP</th>
						<th>50 </th>
						<th>{{ $waybill->tickets->where('concession_id',5)->sum('count') }} </th>
						<th>{{ $waybill->tickets->where('concession_id',5)->sum('total_amount') }}</th>
						<?php
							$tot = $waybill->tickets->where('concession_id',5)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',5)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th>{{$disc}}</th>
					</tr>
					<tr>
						<th>POLICE</th>
						<th>100 </th>
						<th>{{ $waybill->tickets->where('concession_id',6)->sum('count') }} </th>
						<th>{{ $waybill->tickets->where('concession_id',6)->sum('total_amount') }}</th>
						<?php
							$tot = $waybill->tickets->where('concession_id',6)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',6)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th>{{$disc}}</th>
					</tr>
					<tr>
						<th>PRESS REPOR</th>
						<th>100 </th>
						<th>{{ $waybill->tickets->where('concession_id',7)->sum('count') }} </th>
						<th>{{ $waybill->tickets->where('concession_id',7)->sum('total_amount') }}</th>
						<?php
							$tot = $waybill->tickets->where('concession_id',7)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',7)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th>{{$disc}}</th>
					</tr>
					<tr>
						<th>STUDENT PAS</th>
						<th>100 </th>
						<th>{{ $waybill->tickets->where('concession_id',8)->sum('count') }} </th>
						<th>{{ $waybill->tickets->where('concession_id',8)->sum('total_amount') }}</th>
						<?php
							$tot = $waybill->tickets->where('concession_id',8)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',8)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th>{{$disc}}</th>
					</tr>
					<tr>
						<th>TLH PATIENT</th>
						<th>100 </th>
						<th>{{ $waybill->tickets->where('concession_id',9)->sum('count') }} </th>
						<th>{{ $waybill->tickets->where('concession_id',9)->sum('total_amount') }}</th>
						<?php
							$tot = $waybill->tickets->where('concession_id',9)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',9)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th>{{$disc}}</th>
					</tr>
					<tr>
						<th>WINDOWS TKT</th>
						<th>100 </th>
						<th>{{ $waybill->tickets->where('concession_id',10)->sum('count') }} </th>
						<th>{{ $waybill->tickets->where('concession_id',10)->sum('total_amount') }}</th>
						<?php
							$tot = $waybill->tickets->where('concession_id',10)->sum('total_amount');
							$act = $waybill->tickets->where('concession_id',10)->sum('actual_amount');

							$disc = $act-$tot;
						?>
						<th>{{$disc}}</th>
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
					<td>{{$total_remit}}</td>
				</tr>
				<tr>
					<td>Net Amount To be Deposited: Rs</td>
					<td>{{$net_amount}}</td>
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
						<th>STATE AMOUNT </th>
						<th>{{ $waybill->stateCollection->where('state_id',6)->sum('fare') }}</th>
						<th>{{ $waybill->stateCollection->where('state_id',10)->sum('fare') }}</th>
						<th>{{ $waybill->stateCollection->where('state_id',13)->sum('fare') }}</th>
						<th>{{ $waybill->stateCollection->where('state_id',14)->sum('fare') }}</th>
						<th>{{ $waybill->stateCollection->where('state_id',15)->sum('fare') }}</th>
						<th>{{ $waybill->stateCollection->where('state_id',28)->sum('fare') }}</th>
						<th>{{ $waybill->stateCollection->where('state_id',29)->sum('fare') }}</th>
						<th>{{ $waybill->stateCollection->where('state_id',34)->sum('fare') }}</th>
						<th>{{ $waybill->stateCollection->where('state_id',33)->sum('fare') }}</th>
					</tr>
					<tr>
						<th>STATE TAX </th>
						
						<?php
						$waybill_vehicle_type_id=$waybill->vehicle->vehicleType->id;
						$tax_type = $waybill->getStateTaxType(6,$waybill_vehicle_type_id);
						if($tax_type=1){
							$covered_km = $waybill->tripCoveredKM->where('state_id',6)->sum('km');
							$value = $waybill->getStateTaxValue(6,$waybill_vehicle_type_id);
							$state_tax = $covered_km*$value;
						}else if($tax_type=2){
							$collection = $waybill->stateCollection->where('state_id',6)->sum('fare');
							$value = $waybill->getStateTaxValue(6,$waybill_vehicle_type_id);
							$state_tax = $collection*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
	
						?>
						<th>{{$state_tax}}</th>
						<?php
						$tax_type = $waybill->getStateTaxType(10,$waybill_vehicle_type_id);
						if($tax_type=1){
							$covered_km = $waybill->tripCoveredKM->where('state_id',10)->sum('km');
							$value = $waybill->getStateTaxValue(10,$waybill_vehicle_type_id);
							$state_tax = $covered_km*$value;
						}else if($tax_type=2){
							$collection = $waybill->stateCollection->where('state_id',10)->sum('fare');
							$value = $waybill->getStateTaxValue(10,$waybill_vehicle_type_id);
							$state_tax = $collection*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
	
						?>
						<th>{{$state_tax}}</th>
						<?php
						$tax_type = $waybill->getStateTaxType(13,$waybill_vehicle_type_id);
						if($tax_type=1){
							$covered_km = $waybill->tripCoveredKM->where('state_id',13)->sum('km');
							$value = $waybill->getStateTaxValue(13,$waybill_vehicle_type_id);
							$state_tax = $covered_km*$value;
						}else if($tax_type=2){
							$collection = $waybill->stateCollection->where('state_id',13)->sum('fare');
							$value = $waybill->getStateTaxValue(13,$waybill_vehicle_type_id);
							$state_tax = $collection*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
	
						?>
						<th>{{$state_tax}}</th>
						<?php
						$tax_type = $waybill->getStateTaxType(14,$waybill_vehicle_type_id);
						if($tax_type=1){
							$covered_km = $waybill->tripCoveredKM->where('state_id',14)->sum('km');
							$value = $waybill->getStateTaxValue(14,$waybill_vehicle_type_id);
							$state_tax = $covered_km*$value;
						}else if($tax_type=2){
							$collection = $waybill->stateCollection->where('state_id',14)->sum('fare');
							$value = $waybill->getStateTaxValue(14,$waybill_vehicle_type_id);
							$state_tax = $collection*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
	
						?>
						<th>{{$state_tax}}</th>
						<?php
						$tax_type = $waybill->getStateTaxType(15,$waybill_vehicle_type_id);
						if($tax_type=1){
							$covered_km = $waybill->tripCoveredKM->where('state_id',15)->sum('km');
							$value = $waybill->getStateTaxValue(15,$waybill_vehicle_type_id);
							$state_tax = $covered_km*$value;
						}else if($tax_type=2){
							$collection = $waybill->stateCollection->where('state_id',15)->sum('fare');
							$value = $waybill->getStateTaxValue(15,$waybill_vehicle_type_id);
							$state_tax = $collection*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
	
						?>
						<th>{{$state_tax}} </th>
						<?php
						$tax_type = $waybill->getStateTaxType(28,$waybill_vehicle_type_id);
						if($tax_type=1){
							$covered_km = $waybill->tripCoveredKM->where('state_id',28)->sum('km');
							$value = $waybill->getStateTaxValue(28,$waybill_vehicle_type_id);
							$state_tax = $covered_km*$value;
						}else if($tax_type=2){
							$collection = $waybill->stateCollection->where('state_id',28)->sum('fare');
							$value = $waybill->getStateTaxValue(28,$waybill_vehicle_type_id);
							$state_tax = $collection*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
	
						?>
						<th>{{$state_tax}} </th>
						<?php
						$tax_type = $waybill->getStateTaxType(29,$waybill_vehicle_type_id);
						if($tax_type=1){
							$covered_km = $waybill->tripCoveredKM->where('state_id',29)->sum('km');
							$value = $waybill->getStateTaxValue(29,$waybill_vehicle_type_id);
							$state_tax = $covered_km*$value;
						}else if($tax_type=2){
							$collection = $waybill->stateCollection->where('state_id',29)->sum('fare');
							$value = $waybill->getStateTaxValue(29,$waybill_vehicle_type_id);
							$state_tax = $collection*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
	
						?>
						<th>{{$state_tax}}</th>
						<?php
						$tax_type = $waybill->getStateTaxType(34,$waybill_vehicle_type_id);
						if($tax_type=1){
							$covered_km = $waybill->tripCoveredKM->where('state_id',34)->sum('km');
							$value = $waybill->getStateTaxValue(34,$waybill_vehicle_type_id);
							$state_tax = $covered_km*$value;
						}else if($tax_type=2){
							$collection = $waybill->stateCollection->where('state_id',34)->sum('fare');
							$value = $waybill->getStateTaxValue(34,$waybill_vehicle_type_id);
							$state_tax = $collection*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
	
						?>
						<th>{{$state_tax}}</th>
						<?php
						$tax_type = $waybill->getStateTaxType(33,$waybill_vehicle_type_id);
						if($tax_type=1){
							$covered_km = $waybill->tripCoveredKM->where('state_id',33)->sum('km');
							$value = $waybill->getStateTaxValue(33,$waybill_vehicle_type_id);
							$state_tax = $covered_km*$value;
						}else if($tax_type=2){
							$collection = $waybill->stateCollection->where('state_id',33)->sum('fare');
							$value = $waybill->getStateTaxValue(33,$waybill_vehicle_type_id);
							$state_tax = $collection*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
	
						?>
						<th>{{$state_tax}}</th>
					</tr>
					<tr>
						<th>HVAC</th>
						<?php
						$tax_type = $waybill->getStateTaxType(6,3);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',6)->where('vehicle_type_id',3)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',6)->where('vehicle_type_id',3)->sum('km');
							$value = $waybill->getStateTaxValue(6,3);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(6,3);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(3);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
	
						?>
						<th>{{$vehicle_gst}}</th>

						<?php
						$tax_type = $waybill->getStateTaxType(10,3);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',10)->where('vehicle_type_id',3)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',10)->where('vehicle_type_id',3)->sum('km');
							$value = $waybill->getStateTaxValue(10,3);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(10,3);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(3);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>
								<?php
						$tax_type = $waybill->getStateTaxType(13,3);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',13)->where('vehicle_type_id',3)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',13)->where('vehicle_type_id',3)->sum('km');
							$value = $waybill->getStateTaxValue(13,3);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(13,3);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(3);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(14,3);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',14)->where('vehicle_type_id',3)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',14)->where('vehicle_type_id',3)->sum('km');
							$value = $waybill->getStateTaxValue(14,3);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(14,3);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(3);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(15,3);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',15)->where('vehicle_type_id',3)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',15)->where('vehicle_type_id',3)->sum('km');
							$value = $waybill->getStateTaxValue(15,3);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(15,3);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(3);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(28,3);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',28)->where('vehicle_type_id',3)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',28)->where('vehicle_type_id',3)->sum('km');
							$value = $waybill->getStateTaxValue(28,3);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(28,3);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(3);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(29,3);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',29)->where('vehicle_type_id',3)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',29)->where('vehicle_type_id',3)->sum('km');
							$value = $waybill->getStateTaxValue(29,3);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(29,3);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(3);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(34,3);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',34)->where('vehicle_type_id',3)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',34)->where('vehicle_type_id',3)->sum('km');
							$value = $waybill->getStateTaxValue(34,3);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(34,3);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(3);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(33,3);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',33)->where('vehicle_type_id',3)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',33)->where('vehicle_type_id',3)->sum('km');
							$value = $waybill->getStateTaxValue(33,3);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(33,3);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(3);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>
					</tr>
					<tr>
						<th>VOLVO</th>
						<?php
						$tax_type = $waybill->getStateTaxType(6,9);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',6)->where('vehicle_type_id',9)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',6)->where('vehicle_type_id',9)->sum('km');
							$value = $waybill->getStateTaxValue(6,9);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(6,9);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(9);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
	
						?>
						<th>{{$vehicle_gst}}</th>

						<?php
						$tax_type = $waybill->getStateTaxType(10,9);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',10)->where('vehicle_type_id',9)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',10)->where('vehicle_type_id',9)->sum('km');
							$value = $waybill->getStateTaxValue(10,9);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(10,9);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(9);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>
								<?php
						$tax_type = $waybill->getStateTaxType(13,9);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',13)->where('vehicle_type_id',9)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',13)->where('vehicle_type_id',9)->sum('km');
							$value = $waybill->getStateTaxValue(13,9);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(13,9);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(9);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(14,9);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',14)->where('vehicle_type_id',9)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',14)->where('vehicle_type_id',9)->sum('km');
							$value = $waybill->getStateTaxValue(14,9);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(14,9);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(9);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(15,9);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',15)->where('vehicle_type_id',9)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',15)->where('vehicle_type_id',9)->sum('km');
							$value = $waybill->getStateTaxValue(15,9);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(15,9);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(9);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(28,9);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',28)->where('vehicle_type_id',9)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',28)->where('vehicle_type_id',9)->sum('km');
							$value = $waybill->getStateTaxValue(28,9);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(28,9);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(9);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(29,9);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',29)->where('vehicle_type_id',9)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',29)->where('vehicle_type_id',9)->sum('km');
							$value = $waybill->getStateTaxValue(29,9);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(29,9);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(9);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(34,9);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',34)->where('vehicle_type_id',9)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',34)->where('vehicle_type_id',9)->sum('km');
							$value = $waybill->getStateTaxValue(34,9);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(34,9);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(9);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>

						<?php
						$tax_type = $waybill->getStateTaxType(33,9);
						$collection_of_vehicle = $waybill->stateCollection->where('state_id',33)->where('vehicle_type_id',9)->sum('fare');
						if($tax_type=1){
							$covered_km_of_vehicle = $waybill->tripCoveredKM->where('state_id',33)->where('vehicle_type_id',9)->sum('km');
							$value = $waybill->getStateTaxValue(33,9);
							$state_tax = $covered_km_of_vehicle*$value;
						}else if($tax_type=2){
							$value = $waybill->getStateTaxValue(33,9);
							$state_tax = $collection_of_vehicle*(int)$value/100;
						}
						else{
							$state_tax = 0;
						}
						$gst = $waybill->getGst(9);
						if($gst){
							$gst_first=$collection_of_vehicle-$state_tax;
							$vehicle_gst = $gst_first*(int)$gst->gst_percentage/100;
						}else{
							$vehicle_gst = 0;
						}
						?>
						<th>{{$vehicle_gst}} </th>
					</tr>
				</tbody>
            </table>
	</div>
	<br><br><br>
	<div class="row">
		<div class="trip_detail">
			<h4><u>TRIPS & DETAILS</u></h4>
			<table border="1">
	            <thead>
	                <tr>
	                    <th>Sl. NO </th>
	                    <th>Trip NO </th>
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
				@foreach($waybill->trips as $trip)
					<?php
						$count_of_tickets_in_trip=$trip->countOfTicketsInTrip();
						if($trip->has_closed){
							$trip_start=$trip->fromStage->name;
							$trip_end=$trip->toStage->name;
							$total_ticket_count=$trip->total_number_ticket;
							if($total_ticket_count > 0){
								$total_km=$trip->km;
								$advance_booking_amount=$trip->advance_booking_amount;
								$total_collection=$trip->totalTripCollection();
								$net_trip_amount=$total_collection+$advance_booking_amount;
                				$epkm=0;
                				if($total_km>0){
                    				$epkm=$net_trip_amount/$total_km;
                				}
							}else{
								$total_km=0;
								$advance_booking_amount=0;
								$total_collection=0;
								$net_trip_amount=0;
                				$epkm=0;
							}
							
                			
						}else{
							$total_km=0;
							$trip_start="-";
							$trip_end="-";
                			$total_collection=$trip->totalTripCollection();
                			$advance_booking_amount=$trip->advanceBookingAmount();
                			$net_trip_amount=0;
                			$epkm=0;
						}
					if($count_of_tickets_in_trip > 0)
					{
					?>
					<tr>
					<th>{{$i++}}</th>
					<th>{{$trip->trip_id}}</th>
					<th>{{$trip->driver->employee_code}}</th>
					<th>{{$trip->vehicle->register_number}}</th>
					<th>{{$trip->start_time}}</th>
					<th>{{$trip->route->code}}</th>
					<th>{{$total_km}}</th>
					<th>{{$trip_start}}</th>
					<th>{{$trip_end}}</th>
					<th>{{$advance_booking_amount}}</th>
					<th>{{$total_collection}}</th>
					<th>{{$net_trip_amount}}</th>
					<th>{{bcdiv($epkm,1,2)}}</th>
					</tr>
				<?php } ?>
				@endforeach
				<tr>
					<th colspan="3">Records:  {{$waybill->trips->where('total_collection_amount', '>', 0)->count('trip_id')}}</th>
					<th> </th>
					<th> </th>
					<th> </th>
					<th>{{$sum_of_total_km}}</th>
					<th> </th>
					<th> </th>
					<?php
					$sum_of_advance_booking_amount=$waybill->sumOfAdvanceBookingAmount();
					$sum_of_net_trip_amount=$sum_of_advance_booking_amount+$sum_of_total_collection;
					?>
					<th>{{$sum_of_advance_booking_amount}}</th>
					<th>{{$sum_of_total_collection}}</th>
					<th>{{$sum_of_net_trip_amount}}</th>
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

