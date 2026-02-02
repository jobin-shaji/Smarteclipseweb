@extends('layouts.eclipse')
@section('title')
  All Vehicle
@endsection
	<div style="clear"></div>
		<div class="notification-map">			
			<div style="width: 100%; height:100%; float:left;">
				<input type="hidden" id="lat" name="lat" value="{{$client->latitude}}">
            	<input type="hidden" id="lng" name="lng" value="{{$client->longitude}}"> 				
			<div class="notification-display-bg">
					
				<div class="content-header-1">
					<ol class="breadcrumb">
				        <li class="breadcrumb-item"><a href="/home">Home</a></li>
				        <li class="breadcrumb-item active">Alerts</li>
				    </ol>
				</div>
			</div>
		</div>

			<div class="box-inner">		
				<div class="notification-bar-outer">
					<div class="notification-bar">
						<div class="box-header">
							<div class="noti-head">Alerts</div>
						</div>
						<div class="noti-box">					
							<div class="notificaton-bx-inner">

								<div id="notification" class="alert_notification">					
									<div class="loader-wrapper" id="loader-1">
                                     <div id="loader" class="load-style"></div>
                                     </div> 			
								</div>
								<div id="show_more" class="show_more">					
									
                                     </div> 			
								</div>
							</div>
						</div>					
					</div>
					<div class="mp-outer-bg">
				<div id="map" style="width:100%; height:600px;border: 1px solid #c5c7c7;">
					
				</div>
				</div>
				
			</div>
			</div>			
			<div class="modal right fade" id="clickedModelInDetailPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
				<div class="modal-dialog model-class-new" role="document">
					<div class="modal-content modal-content-new">
						<div class="modal-header modal-header-new">
							<h4 class="modal-title" id="myModalLabel2">Alert Details</h4>
							<button type="button" class="close modal-close-new" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>					
						</div>
						<div class="modal-body">
							<div class="loader-wrapper loader-1" >
								<div  class="load-style loader"></div>
							</div> 
						<div style="text-align:center;">
							<label class='model_label' id="description" ></label><br>
						</div>
						<label>Vehicle Name :</label><span class='model_label' id="vehicle_name"></span><br>
						<label>Register Number :</label><span class='model_label' id="register_number"></span><br>							
						<label>Alert Time:</label><span class='model_label' id="device_time"></span><br>
						<label>Address :</label><span class='model_label' id="address"></span><br>
							<!-- <label>Register Number :</label><span id="register_number"></span><br> -->

						</div>
					</div>
				<!-- modal-content -->
				</div>
			<!-- modal-dialog -->
			</div>		
	</div>
</div>
@section('script')

<script async defer src ="https://maps.googleapis.com/maps/api/js?key={{config('eclipse.keys.googleMap')}}&callback=initMap"></script>
<!-- <script src="{{asset('js/gps/alert-notification-firebase.js')}}"></script> -->
<script src="{{asset('js/gps/alert-notification.js')}}"></script>

			
<link rel="stylesheet" href="{{asset('css/loader-1.css')}}">
<script>
		var el = document.querySelector('.notification');
		document.querySelector('.button').addEventListener('click', function(){
		    var count = Number(el.getAttribute('data-count')) || 0;
		    el.setAttribute('data-count', count + 1);
		    el.classList.remove('notify');
		    el.offsetWidth = el.offsetWidth;
		    el.classList.add('notify');
		    if(count === 0){
		        el.classList.add('show-count');
		    }
		}, false);
		</script>	
<style>
	.load-style
	     {
			    top: 190px !important;
			    width: 30px !important;
			    height: 30px !important;
		 }

	.model-class-new
	{
					position: fixed !important;
			right: 0 !important;
			width: 400px !important;
			margin: 0px !important;
			height: 100% !important;
			padding: 0 !important;
			min-height: 400px !important;
			overflow: scroll;
			background:#fff;
	}
	.modal-content-new{
box-shadow: none;
border: 0;
	}
	.modal-header-new{
		background:#f0b100;
color:#fff;
	}
	.modal-close-new{
		border: 0;
opacity: 1 !important;
outline: 0px;
margin-top: -3px;
	}
	.modal-close-new span{
		 color:#fff;
	}
	.clr{
		background:#fffbee;
	}
	.alert{
		background:#e1f9f3;
	}
</style>
	


 @endsection
