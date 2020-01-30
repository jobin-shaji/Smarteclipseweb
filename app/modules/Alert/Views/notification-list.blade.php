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
				        <li class="breadcrumb-item"><a href="#">Home</a></li>
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
								<div id="notification" calss="notification">								
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
			<div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel2">Heading</h4>
						</div>
						<div class="modal-body">
							<p>
							Test Samples
							</p>
						</div>
					</div>
				<!-- modal-content -->
				</div>
			<!-- modal-dialog -->
			</div>		
			<div class="modal right fade" id="myModal-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-3">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel2">Heading 2</h4>
						</div>
						<div class="modal-body">
							<p>
							Test Samples
							</p>
						</div>
					</div>
					<!-- modal-content -->
				</div>
				<!-- modal-dialog -->
			
		
	</div>
</div>
@section('script')
<script async defer src ="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&callback=initMap"></script>
<script src="{{asset('js/gps/alert-notification.js')}}"></script>	
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
		<script>
		$(function() {

      // Dropdown toggle
      $('.dropdown-toggle').click(function() {
        $(this).next('.dropdown').toggle( 400 );
      });

      $(document).click(function(e) {
        var target = e.target;
        if (!$(target).is('.dropdown-toggle') && !$(target).parents().is('.dropdown-toggle')) {
          $('.dropdown').hide() ;
        }
      });

});
		</script/>
	


 @endsection
