      
              <div style="max-width: 700px;">
                <div class="row">
                    <div class="col-md-5">
                        <?php 
                           $qr='Dealer:'.$role_details->name.'Address:'.$role_details->address.'Mobile:'.$user_details->mobile.'ScannedEmployee:'.$gps_transfer->scanned_employee_code.'OrderNumber:'.$gps_transfer->order_number;
                        ?>
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($qr)) !!} ">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <p class="card-text"><b>Order Number : </b> {{$gps_transfer->order_number}} </p>
                            <p class="card-text"><b>Shipped : </b> {{$gps_transfer->dispatched_on}} </p>
                            <h5 class="card-title">Shipping To,</h5>
                            <p class="card-text">{{$role_details->name}}</p>
                            <p class="card-text">{{$role_details->address}}</p>
                            <p class="card-text"><b>Mobile Number : </b> {{$user_details->mobile}} </p>
                        </div>
                    </div>
                </div>
              </div>
              
            

  