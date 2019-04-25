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
			ADVANCE BOOKING WAYBILL </b>
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
							Advance Booker Code: {{$waybill->agent->employee_code}}
						</th>
						<th>
							Name: {{$waybill->agent->name}}
						</th>
						<th>
						</th>
						<th>
							Bus Number : N/A
						</th>
					</tr>
					<tr>
						<th>
							Driver Code: N/A
						</th>
						<th>
							EBTM NO : {{$waybill->etm->imei}}
						</th>
						<th>
							Date : {{$waybill->date}}
						</th>
						<th>
							BusService : N/A
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
					<td>0</td>
				</tr>
				<tr>
					<td>Penality Amount :</td>
					<td>0</td>
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
				
				<tr>
					<td>Toll Tax Expenses :</td>
					<td>0</td>
				</tr>
				<tr>
					<td>Ticket Refund :</td>
					<td>0</td>
				</tr>
				<tr>
					<td>Bus Stand Fee : </td>
					<td>0</td>
				</tr>
				<tr>
					<td>Diesel Amount : </td>
					<td>0</td>
				</tr>
				<tr>
					<td >Other Payments : </td>
					<td>0</td>
				</tr>
				<tr>
					<td>Total Amount :</td>
					<td>0</td>
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
				<td>0</td>
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
				<td>0</td>
			</tr>
			<tr>
				<td>Insp Ticket Amount : </td>
				<td>0</td>
			</tr>
			<tr>
				<td>Traffic Inspection : </td>
				<td>X</td>
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
				?>
				<tr>
					<td>Total Remit (A): </td>
					<td>{{$total_remit}}</td>
				</tr>
				<tr>
					<td>Net Amount To be Deposited: Rs</td>
					<td>{{$total_remit}}</td>
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
					<tr>
						<th>HVAC </th>
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
						<th>VOLVO </th>
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
					<th>BUS TYPE </th>
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
				@foreach($waybill->trips as $trip)
				<tr class="trip_row">
					<?php
						$count_of_tickets_in_trip=$trip->countOfTicketsInTrip();
						if($trip->has_closed){
							$trip_start=$trip->fromStage->name;
							$trip_end=$trip->toStage->name;
							$total_ticket_count=$trip->total_number_ticket;
							if($total_ticket_count > 0){
								$total_km=$trip->km;
								$total_collection=$trip->totalTripCollection();
								$net_trip_amount=$trip->totalTripCollection();
                				$epkm=0;
                				if($total_km>0){
                    				$epkm=$net_trip_amount/$total_km;
                				}
							}else{
								$total_km=0;
								$total_collection=0;
								$net_trip_amount=0;
                				$epkm=0;
							}
							
                			
						}else{
							$total_km=0;
							$trip_start="-";
							$trip_end="-";
                			$total_collection=$trip->totalTripCollection();
                			$net_trip_amount=0;
                			$epkm=0;
						}
					if($count_of_tickets_in_trip > 0)
					{
					?>
					<th>{{$loop->iteration}}</th>
					<th>N/A</th>
					<th>N/A</th>
					<th>{{$trip->vehicle->vehicleType->name}}</th>
					<th>{{$trip->vehicle->register_number}}</th>
					<th>{{$trip->start_time}}</th>
					<th>{{$trip->route->code}}</th>
					<th>{{$total_km}}</th>
					<th>{{$trip_start}}</th>
					<th>{{$trip_end}}</th>
					<th>0</th>
					<th>{{$total_collection}}</th>
					<th>{{$net_trip_amount}}</th><!-- net trip amount=advance_bk_amount+total_collection_amount -->
					<th>{{bcdiv($epkm,1,2)}}</th>
				<?php }?>
				</tr>
				@endforeach
				<tr>
					<th colspan="2">Records:  {{$waybill->trips->where('total_collection_amount', '>', 0)->count('trip_id')}}</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th>{{$sum_of_total_km}}</th>
					<th></th>
					<th></th>
					<th>0.00</th>
					<th>{{$sum_of_total_collection}}</th>
					<th>{{$sum_of_total_collection}}</th>
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

