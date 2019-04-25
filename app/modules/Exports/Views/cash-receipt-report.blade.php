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

</style>
	<div class="row" >
		<div class="main_heading">		
		<h4><b> KCTSL ETM SYSTEM </b></h4>
      <h4>ETM CASH RECEIPT </h4>
		</div>	
		<hr class="first_hori_line">
	</div>
	  <div class="row">
	  	<div class="border1">
			<table class="table">
				<thead>
					<tr>
						<th>
							WayBill No: {{$waybill->code}}
						</th>
						<th>
							Start Date: {{date('Y-m-d', strtotime($waybill->created_at))}}
						</th>
						
						<th>
							Depot:{{$waybill->depo->name}}
						</th>
					</tr>
					<tr>
						<th>
							ETM: {{$waybill->etm->name}}
						</th>
						<th>
							End Date: {{$waybill->date}}
						</th>
						
						<th>
							Conductor : {{$waybill->conductor->name}}
						</th>
					</tr>
				</thead>
				<tr>
						<th>
							Bus No: {{$waybill->vehicle->register_number}}
						</th>
						<th>
							Bus Type: {{$waybill->vehicle->vehicleType->name}}
						</th>
						<th>
							Driver: {{$waybill->driver->name}}
						</th>					
					</tr>
					<tr>
						<th></th>
						<th></th>
						<th>Route : </th>
					</tr>
				</thead>
			</table>
		</div>
	</div>  
  <div class="row">
    <br>
    <div style="border-width: 1px 1px 1px 1px; border-color: black; border-style: solid; border-collapse: collapse; " >
        <table width="100%">
            <tr style="width: 100%;">
                <td style="width: 35%;padding-left: 5px"> <label style="margin-top: 10px; font-weight: bold">ETM-Data</label></td>
                <td style="width: 35%;padding-left: 5px"> <label style="margin-top: 10px; font-weight: bold">Manual Ticket Details</label></td>
                <td style="width: 35%;padding-left: 5px"> <label style="margin-top: 10px; font-weight: bold;margin-right:65px">Expense Details</label></td>
            </tr>

        </table>
    </div>
    <table border=1 style="border-collapse: collapse; border-style: solid; border-color: black; " width="100%">
        <tr style="width: 100%">
            <td rowspan=2 style="width: 20%;">
                <p style="font-weight: bold">No.of Trip: {{$waybill->trips->count()}}</p>
                <p style="font-weight: bold">Start Ticket No: <span style="font-weight:normal;" id="firstTicket">{{$waybill->tickets->first()->ticket_code}}</span></p>
                <p style="font-weight: bold" >End Ticket No: <span style="font-weight:normal;"  id="lastTicket">{{$waybill->tickets->last()->ticket_code}}</span></p>
                <p style="font-weight: bold">Total Ticket: <span style="font-weight:normal;" id="total_ticket">{{$waybill->trips->sum('total_number_ticket')}}</span></p>
                <p style="font-weight: bold">Penalty Ticket: <span style="font-weight:normal;" id="penality_count">{{$waybill->penalities->count()}}</span></p>
                
                <p style="font-weight: bold">Penalty Amount: <span style="font-weight:normal;" id="penality_amount">{{$waybill->penalities->sum('amount')}}</span></p>
                <p style="font-weight: bold">ETM Collection: <span style="font-weight:normal;" id="etm_collection">{{$waybill->trips->sum('total_collection_amount')}}</span></p>

            </td>
            <td style="width: 20%;">
                <p style="margin-top: 10px; font-weight: bold"> No.of Passengers: <span style="font-weight:normal;margin-left:70px" id="total_passenger">{{$waybill->trips->sum('total_number_ticket')}}</span></p>
                <p style="margin-top: 10px; font-weight: bold">Ticket Sale Amount: <span style="font-weight:normal;" id="ticketSale">{{$waybill->trips->sum('total_collection_amount')}}</span></p>
            </td>
            <td style="width: 20%;">
                <p style="font-weight: bold">Toll Amount: <span style="font-weight:normal;"></span></p>
                <p style="font-weight: bold">CNG Qty: <span style="font-weight:normal;"></span></p>
                <p style="font-weight: bold">Mis Exp: <span style="font-weight:normal;"></span></p>

            </td>
        </tr>
        <tr style="width: 100%">

            <td style="width: 20%;">
                <p style=" font-weight: bold">Total Collection: <span style="font-weight:normal;" id="totalCollection">{{$waybill->trips->sum('total_collection_amount')}}</span></p>
                <p style=" font-weight: bold">Total Expenses: <span style="font-weight:normal;">{{$waybill->trips->sum('total_collection_amount')}}</span></p>
                <p style="font-weight: bold">Net Amount: <span style="font-weight:normal;" id="net_amount"></span></p>
                <p style="font-weight: bold">Total No of Ticket: <span style="font-weight:normal;" id="total_ticket_no">{{$waybill->trips->sum('total_number_ticket')}}</span></p>

            </td>
            <td style="width: 20%;">
                <p style="font-weight: bold">Schedule KM: <span style="font-weight:normal;" id="km">{{$waybill->assigned_km}}</span></p>
                <p style="font-weight: bold">Actual KM: <span style="font-weight:normal;" align="right" id="actualkm">{{$waybill->trips->sum('km')}}</span></p>
                <p style="font-weight: bold"> EPKM: <span style="font-weight:normal;"></span></p>
               
            </td>
        </tr>
    </table>          
    <br><br><br>
	   <div class="grid-containers">
        <table class="sign" >
            <tr>
            <td><b>Sign of Conductor</b></td>
            <td><b>Sign Of Clerk</b></td>
            <td><b>Sign Of Cashier</b></td>
            </tr>
        </table>    
      </div>
    </div>	

