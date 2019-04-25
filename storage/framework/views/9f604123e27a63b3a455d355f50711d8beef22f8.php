<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Cash Receipt Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Cash Receipt Report</li>
      </ol>
</section>
<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="row">
            <div class="col-md-6">
              <label class="required">Waybill Id</label>
              <select class="form-control" id="waybill_id" name="waybill_id" required>
                <option value="">Select</option>
                <?php $__currentLoopData = $waybillcash; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waybill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($waybill->id); ?>"><?php echo e($waybill->code); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>   
            </div>
          </div>
        </div>
      </div>
    <div id="cash_recep" class="cash_recep">
      <div class="row">
        <button class="btn btn-default pull-right" onclick="downloadCashReceipt()">Download PDF <i class="fa fa-download"></i> 
        </button>
  </div>
  <div class="row">
    <div class="text-center main_heading">
      <h4><b> KCTSL ETM SYSTEM </b></h4>
      <h4>ETM CASH RECEIPT </h4>
    </div>
    
  
  </div>
  <div class="row">
    
    <div class="borderhead">
      <div class="col-md-12">
        <div class="col-md-4">
          <b>
            WayBill No: <span id="waybills"></span>
            <br>
            ETM ID: <span id="etmid"></span>
             <br>
            BUS No: <span id="vehicle_no"></span>
          </b>
        </div>
        <div class="col-md-4">
          <b>
            Start Date: <span id="startDate"></span>
            <br>
            End Date : <span id="closing_date"></span>
             <br>
            Bus Type : <span id="vehicleTypeId"></span>
          </b>
        </div>     
        <div class="col-md-4">
          <b>
            Depot :<span id="depot"></span>
            <br>
            Conductor : <span id="conductor_name"></span>
            <br>
            Driver : <span id="driver_name"></span>
            <br>
            Route No : <span id="route"></span>
          </b>
        </div>
      </div>
    </div>
  </div>

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
                                        <p style="font-weight: bold">No.of Trip: <span style="" id="trip_count"></span></p>
                                        <p style="font-weight: bold">Start Ticket No: <span style="font-weight:normal;" id="firstTicket"></span></p>
                                        <p style="font-weight: bold" >End Ticket No: <span style="font-weight:normal;"  id="lastTicket"></span></p>
                                        <p style="font-weight: bold">Total Ticket: <span style="font-weight:normal;" id="total_ticket"></span></p>
                                        <p style="font-weight: bold">Penalty Ticket: <span style="font-weight:normal;" id="penality_count"></span></p>
                                        
                                        <p style="font-weight: bold">Penalty Amount: <span style="font-weight:normal;" id="penality_amount"></span></p>
                                        <p style="font-weight: bold">ETM Collection: <span style="font-weight:normal;" id="etm_collection"></span></p>

                                    </td>
                                    <td style="width: 20%;">
                                        <p style="margin-top: 10px; font-weight: bold"> No.of Passengers: <span style="font-weight:normal;margin-left:70px" id="total_passenger"></span></p>
                                        <p style="margin-top: 10px; font-weight: bold">Ticket Sale Amount: <span style="font-weight:normal;" id="ticketSale"></span></p>
                                    </td>
                                    <td style="width: 20%;">
                                        <p style="font-weight: bold">Toll Amount: <span style="font-weight:normal;"></span></p>
                                        <p style="font-weight: bold">CNG Qty: <span style="font-weight:normal;"></span></p>
                                        <p style="font-weight: bold">Mis Exp: <span style="font-weight:normal;"></span></p>

                                    </td>
                                </tr>
                                <tr style="width: 100%">

                                    <td style="width: 20%;">
                                        <p style=" font-weight: bold">Total Collection: <span style="font-weight:normal;" id="totalCollection"></span></p>
                                        <p style=" font-weight: bold">Total Expenses: <span style="font-weight:normal;"></span></p>
                                        <p style="font-weight: bold">Net Amount: <span style="font-weight:normal;" id="net_amount"></span></p>
                                        <p style="font-weight: bold">Total No of Ticket: <span style="font-weight:normal;" id="total_ticket_no"></span></p>

                                    </td>
                                    <td style="width: 20%;">
                                        <p style="font-weight: bold">Schedule KM: <span style="font-weight:normal;" id="km"></span></p>
                                        <p style="font-weight: bold">Actual KM: <span style="font-weight:normal;" align="right" id="actualkm"></span></p>
                                        <p style="font-weight: bold"> EPKM: <span style="font-weight:normal;"></span></p>
                                       
                                    </td>
                                </tr>

                            </table>
                           


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
  </div>
</section>
<div class="clearfix"></div>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('js/etm/cash-receipt-report.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>