
@extends('layouts.gps-client')
@section('content')
<section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
</section>
<section class="content">
<div class="row">
  @role('root')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="gps"><div class="loader"></div></h3>
              <p>GPS</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
               <h3 id="dealer"><div class="loader"></div></h3>
              <p>Dealers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="sub_dealer"><div class="loader"></div></h3>
              <p>Sub Dealers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/sub-dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="client"><div class="loader"></div></h3>
              <p>Clients</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/client" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         <!-- ./col -->
        <a href="">
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-blue"><i class="ion ion-ios-gear-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Vehicle</span>
                <span class="info-box-number" id="stages">
                  <h3 id="vehicle"><div class="loader"></div></h3>
                </span>
              </div>
            </div>
            <!-- /.info-box -->
          </div>
        </a>
        <!-- ./col -->
  @endrole

   @role('dealer')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">              
              <h3 id="gps_dealer"><div class="loader"></div></h3>
              <p>GPS</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/gps-dealer" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
               <h3 id="dealer_subdealer"><div class="loader"></div></h3>              
              <p>Sub Dealers</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/subdealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->       
  @endrole
   @role('sub_dealer')

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="subdealer_gps"><div class="loader"></div></h3>              
              <p>GPS</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/gps-transfers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="subdealer_client"><div class="loader"></div></h3>  
              <p>Client</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/clients" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
   @endrole
   @role('client')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="client_gps"><div class="loader"></div></h3>
              <p>GPS</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
               <h3 id="client_vehicle"><div class="loader"></div></h3>
              <p>Vehicle</p>
            </div>
            <div class="icon">
              <i class="ion ion-model-s"></i>
            </div>
            <a href="" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="geofence"><div class="loader"></div></h3>
              <p>Geofence</p>
            </div>
            <div class="icon">
              <!-- <i class="ion ion-person-add"></i> -->
            </div>
            <a href="" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>      
        <div class="row">
          <!-- alert report-start -->
          <div class="col-xs-6">
          <div id="page-wrap1">
             <div id="more-info"><div>               
                 <p>Hover over location on the left. (JavaScript must be enabled)</p>
             </div></div>
            <div id="map_canvas"></div>
            <!--  <ul id="locations">    
                          
                <li data-geo-lat="10.014550" data-geo-long="76.293159" >                 
                 <h3>KL-05-2015</h3>   

                                      
                                  
                  <p class="longdesc">
                    1111
                  </p>
                </li>
               
            </ul>     -->
               <ul id="locations">    
              <!-- onmouseover="getLocationData(1)         -->
               @foreach ($vehicles as $vehicles )  
               <li data-geo-lat="10.014550" data-geo-long="76.293159" > 
                 <h3>{{$vehicles['register_number']}}</h3>   
                 <p class="longdesc">
                    1111
                  </p>
                </li>
                @endforeach
            </ul> 

           
          </div>
          </div>
          <div class="col-xs-6">
            <!-- documents report -start -->
             <div class="box box-danger">
              <div class="box-header ui-sortable-handle" style="cursor: move;">
                <i class="fa fa-bell-o"></i>
                <h3 class="box-title">Alert List</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                <ul class="list-group">
                  @if($alerts)
                    @foreach ($alerts as $alert )
                    <li class="list-group-item">
                    <!-- drag handle -->
                    <span class="handle ui-sortable-handle">
                      <i class="fa fa-ellipsis-v"></i>
                      <i class="fa fa-ellipsis-v"></i>
                    </span>
                        
                    <!-- todo text -->
                    <span class="text">{{$alert->alertType->description}}</span>
                    [<span class="text-primary" style="color:#000;"> {{$alert->vehicle->name}} - {{$alert->vehicle->register_number}}</span>]
                        <?php 
                              $alert_time=$alert->created_at;
                              $alert_status=$alert->status;
                         ?>
                         <br>
                        <!-- Emphasis label -->
                        <small class="label label-danger" style="font-size: 13px;     margin: 0px 12px;"><i class="fa fa-clock-o"></i> {{$alert_time}}</small>
                        @if($alert_status==0)
                          <small class="label label-danger pull-right" style="font-size: 13px;"><?php echo "Pending"; ?></small>
                        @else
                          <small class="label label-success pull-right" style="font-size: 13px;"><?php echo "Success"; ?></small>
                        @endif
                        <!-- General tools such as edit or delete-->
                      </li>
                      @endforeach
                    @else
                      <h4 class="text-info"> Sorry!! waiting for alerts.....</h4>
                    @endif
                      
                    </ul>
                  </div>
                  <!--Alert report-end -->
                </div>

            <div class="box box-danger">
                  <div class="box-header ui-sortable-handle" style="cursor: move;">
                    <i class="fa fa-file"></i>
                    <h3 class="box-title">Expired Documents List</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                    <ul class="list-group">
                      @if($expired_documents)
                        @foreach ($expired_documents as $expired )
                        <li class="list-group-item">
                          <!-- drag handle -->
                          <span class="handle ui-sortable-handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          <!-- todo text -->
                          <span class="text-danger">{{$expired->documentType->name}} expired on {{$expired->expiry_date}}</span>
                          [<span class="text-primary" style="color:#000;">{{$expired->vehicle->name}} - {{$expired->vehicle->register_number}}</span>]

                          <div class="card-link pull-right">
                            <?php $id=Crypt::encrypt($expired->vehicle_id); ?>
                            <a href="{{route('vehicle.documents',$id)}}" class="c-link">View
                            <i class="fa fa-angle-right"></i>
                            </a>
                            
                          </div>
                          <!-- General tools such as edit or delete-->
                        </li>
                       @endforeach
                      @else
                        <h4 class="text-info"> </h4>
                      @endif
                      
                    </ul>
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                    <ul class="list-group">
                      @if($expire_documents)
                        @foreach ($expire_documents as $expired )
                        <li class="list-group-item">
                          <!-- drag handle -->
                          <span class="handle ui-sortable-handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                          
                          <!-- todo text -->
                          <span class="text-danger">{{$expired->documentType->name}} will expire on {{$expired->expiry_date}}</span>
                          [<span class="text-primary" style="color:#000;">{{$expired->vehicle->name}} - {{$expired->vehicle->register_number}}</span>]

                          <div class="card-link pull-right">
                            <?php $id=Crypt::encrypt($expired->vehicle_id); ?>
                            <a href="{{route('vehicle.documents',$id)}}" class="c-link">View
                            <i class="fa fa-angle-right"></i>
                            </a>
                            
                          </div>
                          <!-- General tools such as edit or delete-->
                        </li>
                       @endforeach
                      @else
                        <h4 class="text-info"> </h4>
                      @endif
                      
                    </ul>
                  </div>
                  <!--Documents report-end -->
                </div>
          </div>
        </div>


  @endrole

</div>
      
</section>
  @section('script')
      <script src="{{asset('js/gps/dashb.js')}}"></script>
  @endsection
  <!-- ######################################################################## -->
  <link rel='stylesheet' type='text/css' href='css/dashboard/style.css' />
   <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js'></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap" async defer></script>

  <script type='text/javascript'>
  
    $(function() {
    
      var chicago = new google.maps.LatLng(41.924832, -87.697456),
          pointToMoveTo, 
          first = true,
          curMarker = new google.maps.Marker({}),
          $el;
      
      var myOptions = {
          zoom: 10,
          center: chicago,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
      
      var map = new google.maps.Map($("#map_canvas")[0], myOptions);
    
      $("#locations li").mouseenter(function() {
      
        $el = $(this);
                
        if (!$el.hasClass("hover")) {
        
          $("#locations li").removeClass("hover");
          $el.addClass("hover");
        
          if (!first) { 
            
            // Clear current marker
            curMarker.setMap(); 
            
            // Set zoom back to Chicago level
            // map.setZoom(10);
          }
          
          // Move (pan) map to new location
          pointToMoveTo = new google.maps.LatLng($el.attr("data-geo-lat"), $el.attr("data-geo-long"));
          map.panTo(pointToMoveTo);
          
          // Add new marker
          curMarker = new google.maps.Marker({
              position: pointToMoveTo,
              map: map
          });
          
          // On click, zoom map
          google.maps.event.addListener(curMarker, 'click', function() {
             map.setZoom(14);
          });
          
          // Fill more info area
          $("#more-info")
            .find("h2")
              .html($el.find("h3").html())
              .end()
            .find("p")
              .html($el.find(".longdesc").html());
          
          // No longer the first time through (re: marker clearing)        
          first = false; 
        }
        
      });
      
      $("#locations li:first").trigger("mouseenter");
      
    });
  </script>


<!-- 
<script>
  $(document).ready(function() {

// function getLocationData(id) { 
  // alert(id);
  $('##locations li').hover(function () { 
    // document.getElementById('cash_recep').style.display = 'block';
    var waybillId = $(this).val();
    alert(waybillId);
    var data={ waybillId : waybillId };
    if(waybillId) {
      $.ajax({
        type:'POST',      
        url: '/dashboard/getlocation',
        data:data ,
        async: true,
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(data) {
            // console.log(data);
          if(data){
             //  $("#waybills").text(data.waybill_code); 
             //  $("#etmid").text(data.etm); 
             //  $("#total_passenger").text(data.passenger); 
             //  $("#vehicle_no").text(data.vehicle); 
             //   $("#vehicleTypeId").text(data.vehicleTypeId); 
             //  $("#depot").text(data.depot); 
             //  $("#conductor_name").text(data.conductor_name);
             //  $("#driver_name").text(data.driver_name); 
             //  $("#trip_count").text(data.trip_count); 
             //  $("#ticketSale").text(data.totalCollection); 
             //   $("#etm_collection").text(data.totalCollection); 
             //   $("#net_amount").text(data.amountTotal);
             //  $("#totalCollection").text(data.amountTotal); 
             //  $("#total_ticket").text(data.passenger); 
             //  $("#total_ticket_no").text(data.passenger);
             //  $("#km").text(data.assigned_km);
             //  $("#actualkm").text(data.km);
             //  $("#penality_amount").text(data.penality);
             //  $("#penality_count").text(data.penality_count);
             // $("#expenseAmount").text(data.expenseAmount);
             //  $("#startDate").text(data.startDate);
             // $("#closing_date").text(data.closing_date);
             //  $("#totalExpenses").text(data.totalExpenses);
             //  $("#firstTicket").text(data.first_ticket);
             //  $("#lastTicket").text(data.last_ticket);
            }
            else
            {
            }
          }
        });
      }else{    
    }
  });
});
</script> -->

  <!-- ############################################################ -->
@endsection