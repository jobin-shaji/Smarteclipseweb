@extends('layouts.eclipse')
@section('title')
  Go Premium
@endsection
@section('content')
@section('pre-css')
  <link href="{{asset('css/style.min2.css')}}" rel="stylesheet">
@endsection

<body>
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4" style="color:#b2bb00">Go Premium</h1>
</div>

<div class="container">
  <div class="card-deck mb-3 text-center">
    <div class="card mb-3 shadow-sm">
      <div style="height:72px">
        <!-- <img src="{{url('/')}}/premium/car1.jpg" class="card-img-top" alt="..." style="width: 7rem;margin: 3% auto"> -->
      <!--   <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div> -->
      </div>
      <div class="card-header">
        <h4 class="my-0 font-weight-normal">Freebies</h4>
      </div>
      <div class="card-body">
        <!-- <h1 class="card-title pricing-card-title">$15 <small class="text-muted">/ mo</small></h1> -->
        <ul class="list-unstyled mt-3 mb-4">
          <li><i class="fas fa-mobile-alt"></i>Mobile application</li>
          <li><i class="far fa-caret-square-left"></i>Route playback history(1 Month)</li> 
          <li><i class="far fa-map"></i>Point of interest</li>
          <li><img src="{{url('/')}}/assets/images/route.png" style="margin:0 2%"></i>Route deviation</li> 
          <li><img src="{{url('/')}}/assets/images/geofence.png" style="margin:0 2%">Geofence(1 Geofence)</li> 
          <li style="height:24px"></li> 
          <li style="height:24px"></li> 
          <li style="height:24px"></li> 
          <li style="height:24px"></li> 
          <li style="height:24px"></li> 
          <li style="height:24px"></li> 
           <li style="height:24px"></li> 
          <li style="height:33px"></li> 
        </ul>
        <p>
          <a  data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
           Alert Reports (1 month history)
          </a>
        </p>
        <a data-toggle="collapse" href="#collapseExample"><img src="{{url('/')}}/assets/images/download.gif" width="20" height="30"></a>
        <div class="collapse" id="collapseExample">
          <div class="card card-body" style="margin:0!important">
          <ul class="list-unstyled mt-3 mb-4">
                   <li><img src="{{url('/')}}/assets/images/braking.png" style="margin:0 2% 0 0">Harsh Braking Alert</li> 
                  <li><img src="{{url('/')}}/assets/images/accelaration.png" style="margin:0 2% 0 0">Harsh Acceleration Alert</li>
                  <li><img src="{{url('/')}}/assets/images/turning.png" style="margin:0 2% 0 0">Rash Turning Alert</li>
                  <li><img src="{{url('/')}}/assets/images/box-open.png" style="margin:0 2% 0 0">GPS Box Opened Alert</li> 
                  <li><img src="{{url('/')}}/assets/images/geofence-entry.png" style="margin:0 2% 0 0">Geofence Entry Alert</li> 
                  <li><img src="{{url('/')}}/assets/images/geofence-exit.png" style="margin:0 2% 0 0">Geofence Exit Alert</li>
                  <li><img src="{{url('/')}}/assets/images/connect-battery.png" style="margin:0 2% 0 0">Vehicle Battery Reconnect/ Connect back to main battery Alert</li> 
                  <li><i class="fas fa-battery-quarter"></i>Low battery Alert</li>
                  <li><img src="{{url('/')}}/assets/images/low-battery.png" style="margin:0 2% 0 0">Low battery removed Alert</li> 
                  <li><img src="{{url('/')}}/assets/images/button.png" style="margin:0 2% 0 0">Emergency button wiredisconnect/wirecut Alert</li>
                  <li><img src="{{url('/')}}/assets/images/disconnect.png" style="margin:0 2% 0 0">Disconnect from main battery Alert</li> 
                  <li><img src="{{url('/')}}/assets/images/overspeed.png" style="margin:0 2% 0 0">Over speed Alert</li> 
                  <li><img src="{{url('/')}}/assets/images/tilt.png" style="margin:0 2% 0 0">Tilt Alert</li> 
                  <li><img src="{{url('/')}}/assets/images/impact.png" style="margin:0 2% 0 0">Impact Alert</li>
                   <li><img src="{{url('/')}}/assets/images/geo-entry.png" style="margin:0 2% 0 0">Overspeed+ GF Entry Alert</li> 
                   <li><img src="{{url('/')}}/assets/images/geo-exit.png" style="margin:0 2% 0 0">Overspeed + GF Exit Alert</li>
                   <li><img src="{{url('/')}}/assets/images/location.png" style="margin:0 2% 0 0">Location Update Alert</li> 
                   <li><img src="{{url('/')}}/assets/images/location-update.png" style="margin:0 2% 0 0">Location Update (history) Alert</li> 
                   <li><img src="{{url('/')}}/assets/images/ignition-on.png" style="margin:0 2% 0 0">Alert – Ignition ON Alert</li> 
                   <li><img src="{{url('/')}}/assets/images/ignition-off.png" style="margin:0 2% 0 0">Alert – Ignition OFF Alert</li> 
                   <li><img src="{{url('/')}}/assets/images/state-on.png" style="margin:0 2% 0 0">Alert – Emergency state ON* Alert</li> 
                   <li><img src="{{url('/')}}/assets/images/state-off.png" style="margin:0 2% 0 0">Alert – emergency State OFF Alert</li> 
                   <li><img src="{{url('/')}}/assets/images/air.png" >Alert Over the air parameter change Alert</li> 
                  </ul>
          </div>
        </div>
        <!-- <button type="button" class="btn btn-lg btn-block btn-primary">Try Now</button> -->
      </div>
    </div>
<div class="card mb-3 shadow-sm">
   <div style="height:72px">
 <!--  <img src="{{url('/')}}/premium/car2.jpg" class="card-img-top" alt="..." style="width:7rem;margin:8.5% auto"> -->
<!--   <div class="card-body">
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div> -->
</div>
      <div class="card-header">
        <h4 class="my-0 font-weight-normal">Fundamental</h4>
      </div>
     <button type="button" class="btn"> <a href="{{url('/')}}/payments?plan=fundamental">Pay Now</a></button>
      <div class="card-body">
        <!-- <h1 class="card-title pricing-card-title">$15 <small class="text-muted">/ mo</small></h1> -->
        <ul class="list-unstyled mt-3 mb-4">
          <li><b>Everything in Freebies +</b></li>
          <li><i class="far fa-caret-square-left"></i>Route playback history(2 Months)</li>
          <li><img src="{{url('/')}}/assets/images/geofence.png" style="margin:0 2%">Geofence(3 Geofences)</li>
          <li><i class="far fa-star"></i>Driver score</li>
          <li><i class="far fa-file-alt"></i>Invoice</li>
          <li><img src="{{url('/')}}/assets/images/towing.png" style="margin:0 2%">Towing alert</li>
          <li><img src="{{url('/')}}/assets/images/radar.png" style="margin:0 2%">Radar</li>
          <li><img src="{{url('/')}}/assets/images/aggregation.png" style="margin:0 2%">Aggregation platform</li>
          <li><i class="far fa-share-square"></i>Share in webapp</li>
          <li><img src="{{url('/')}}/assets/images/sms.png" style="margin:0 2%">Emergency alerts as SMS</li>
          <li style="height:30px"></li> 
        </ul>
        <p>
  <a  data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample1">
   Alert Reports (2 months history)
  </a>
</p>
  <a data-toggle="collapse" href="#collapseExample1"><img src="{{url('/')}}/assets/images/download.gif" width="20" height="30"></a>
<div class="collapse" id="collapseExample1">
  <div class="card card-body" style="margin:0!important">
  <ul class="list-unstyled mt-3 mb-4">
          <li><img src="{{url('/')}}/assets/images/braking.png" style="margin:0 2% 0 0">Harsh Braking Alert</li>
          <li><img src="{{url('/')}}/assets/images/accelaration.png" style="margin:0 2% 0 0">Harsh Acceleration Alert</li>
          <li><img src="{{url('/')}}/assets/images/turning.png" style="margin:0 2% 0 0">Rash Turning Alert</li>
          <li><img src="{{url('/')}}/assets/images/box-open.png" style="margin:0 2% 0 0">GPS Box Opened Alert</li>
          <li><img src="{{url('/')}}/assets/images/geofence-entry.png" style="margin:0 2% 0 0">Geofence Entry Alert</li>
          <li><img src="{{url('/')}}/assets/images/geofence-exit.png" style="margin:0 2% 0 0">Geofence Exit Alert</li>
          <li><img src="{{url('/')}}/assets/images/connect-battery.png" style="margin:0 2% 0 0">Vehicle Battery Reconnect/ Connect back to main battery Alert</li>
          <li><i class="fas fa-battery-quarter"></i>Low battery Alert</li>
          <li><img src="{{url('/')}}/assets/images/low-battery.png" style="margin:0 2% 0 0">Low battery removed Alert</li>
          <li><img src="{{url('/')}}/assets/images/button.png" style="margin:0 2% 0 0">Emergency button wiredisconnect/wirecut Alert</li>
          <li><img src="{{url('/')}}/assets/images/disconnect.png" style="margin:0 2% 0 0">Disconnect from main battery Alert</li>
          <li><img src="{{url('/')}}/assets/images/overspeed.png" style="margin:0 2% 0 0">Over speed Alert</li>
          <li><img src="{{url('/')}}/assets/images/tilt.png" style="margin:0 2% 0 0">Tilt Alert</li>
          <li><img src="{{url('/')}}/assets/images/impact.png" style="margin:0 2% 0 0">Impact Alert</li>
          <li><img src="{{url('/')}}/assets/images/geo-entry.png" style="margin:0 2% 0 0">Overspeed+ GF Entry Alert</li>
          <li><img src="{{url('/')}}/assets/images/geo-exit.png" style="margin:0 2% 0 0">Overspeed + GF Exit Alert</li>
          <li><img src="{{url('/')}}/assets/images/location.png" style="margin:0 2% 0 0">Location Update Alert</li>
          <li><img src="{{url('/')}}/assets/images/location-update.png" style="margin:0 2% 0 0">Location Update (history) Alert</li>
          <li><img src="{{url('/')}}/assets/images/ignition-on.png" style="margin:0 2% 0 0">Alert – Ignition ON Alert</li>
          <li><img src="{{url('/')}}/assets/images/ignition-off.png" style="margin:0 2% 0 0">Alert – Ignition OFF Alert</li>
          <li><img src="{{url('/')}}/assets/images/state-on.png" style="margin:0 2% 0 0">Alert – Emergency state ON* Alert</li>
          <li><img src="{{url('/')}}/assets/images/state-off.png" style="margin:0 2% 0 0">Alert – emergency State OFF Alert</li>
          <li><img src="{{url('/')}}/assets/images/air.png" style="margin:0 2% 0 0">Alert Over the air parameter change Alert</li>
          </ul>
  </div>
</div>
        
      </div>
    </div>

    <div class="card mb-3 shadow-sm">
  <div style="height:72px">
  <!-- <img src="{{url('/')}}/premium/car3.jpg" class="card-img-top" alt="..."  style="width: 7rem;margin:1.5% auto;"> -->
<!--   <div class="card-body">
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div> -->
</div>
      <div class="card-header">
        <h4 class="my-0 font-weight-normal">Superior</h4>
      </div>
      <button type="button" class="btn"><a href="{{url('/')}}/payments?plan=superior">Pay Now</a></button>
      <div class="card-body">
        <!-- <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1> -->
       <ul class="list-unstyled mt-3 mb-4">
           <li><b>Everything in Fundamental +</b></li>
           <li><i class="far fa-caret-square-left"></i>Route playback history(4 Months)</li>
          <li><img src="{{url('/')}}/assets/images/geofence.png" style="margin:0 2%">Geofence(4 Geofences)</li>
          <li><img src="{{url('/')}}/assets/images/logo.png" style="margin:0 2%">Client Logo</li>
          <li><img src="{{url('/')}}/assets/images/fuel.png" style="margin:0 2%">Fuel</li>
          <li><img src="{{url('/')}}/assets/images/immobilizer.png" style="margin:0 2%">Immobilizer</li>
          <li><img src="{{url('/')}}/assets/images/ubi.png" style="margin:0 2%">UBI(upto 4)</li>
          <li><img src="{{url('/')}}/assets/images/traffic.png" style="margin:0 2%">Traffic offence</li>
          <li><i class="far fa-comment-dots"></i>Daily report as SMS </li>
          <li><i class="far fa-envelope"></i>Daily report summary to reg. mail</li>
          <li><img src="{{url('/')}}/assets/images/theft.png" style="margin:0 2%">Theft Mode</li>
          <li style="height:0"></li> 
        </ul>
        <p>
  <a  data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
   Alert Reports (4 months history)
  </a>
</p>
<a data-toggle="collapse" href="#collapseExample2"><img src="{{url('/')}}/assets/images/download.gif" width="20" height="30"></a>
<div class="collapse" id="collapseExample2">
  <div class="card card-body" style="margin:0!important">
  <ul class="list-unstyled mt-3 mb-4">
          <li><img src="{{url('/')}}/assets/images/braking.png" style="margin:0 2% 0 0">Harsh Braking Alert</li>
          <li><img src="{{url('/')}}/assets/images/accelaration.png" style="margin:0 2% 0 0">Harsh Acceleration Alert</li>
          <li><img src="{{url('/')}}/assets/images/turning.png" style="margin:0 2% 0 0">Rash Turning Alert</li>
          <li><img src="{{url('/')}}/assets/images/box-open.png" style="margin:0 2% 0 0">GPS Box Opened Alert</li>
          <li><img src="{{url('/')}}/assets/images/geofence-entry.png" style="margin:0 2% 0 0">Geofence Entry Alert</li>
          <li><img src="{{url('/')}}/assets/images/geofence-exit.png" style="margin:0 2% 0 0">Geofence Exit Alert</li>
          <li><img src="{{url('/')}}/assets/images/connect-battery.png" style="margin:0 2% 0 0">Vehicle Battery Reconnect/ Connect back to main battery Alert</li>
          <li><i class="fas fa-battery-quarter"></i>Low battery Alert</li>
          <li><img src="{{url('/')}}/assets/images/low-battery.png" style="margin:0 2% 0 0">Low battery removed Alert</li>
          <li><img src="{{url('/')}}/assets/images/button.png" style="margin:0 2% 0 0">Emergency button wiredisconnect/wirecut Alert</li>
          <li><img src="{{url('/')}}/assets/images/disconnect.png" style="margin:0 2% 0 0">Disconnect from main battery Alert</li>
          <li><img src="{{url('/')}}/assets/images/overspeed.png" style="margin:0 2% 0 0">Over speed Alert</li>
          <li><img src="{{url('/')}}/assets/images/tilt.png" style="margin:0 2% 0 0">Tilt Alert</li>
          <li><img src="{{url('/')}}/assets/images/impact.png" style="margin:0 2% 0 0">Impact Alert</li>
          <li><img src="{{url('/')}}/assets/images/geo-entry.png" style="margin:0 2% 0 0">Overspeed+ GF Entry Alert</li>
          <li><img src="{{url('/')}}/assets/images/geo-exit.png" style="margin:0 2% 0 0">Overspeed + GF Exit Alert</li>
          <li><img src="{{url('/')}}/assets/images/location.png" style="margin:0 2% 0 0">Location Update Alert</li>
          <li><img src="{{url('/')}}/assets/images/location-update.png" style="margin:0 2% 0 0">Location Update (history) Alert</li>
          <li><img src="{{url('/')}}/assets/images/ignition-on.png" style="margin:0 2% 0 0">Alert – Ignition ON Alert</li>
          <li><img src="{{url('/')}}/assets/images/ignition-off.png" style="margin:0 2% 0 0">Alert – Ignition OFF Alert</li>
          <li><img src="{{url('/')}}/assets/images/state-on.png" style="margin:0 2% 0 0">Alert – Emergency state ON* Alert</li>
          <li><img src="{{url('/')}}/assets/images/state-off.png" style="margin:0 2% 0 0">Alert – emergency State OFF Alert</li>
          <li><img src="{{url('/')}}/assets/images/air.png" style="margin:0 2% 0 0">Alert Over the air parameter change Alert</li>
          <li><img src="{{url('/')}}/assets/images/towing.png" style="margin:0 2% 0 0">Towing alert</li>
          <li><img src="{{url('/')}}/assets/images/fuel.png" style="margin:0 2% 0 0">Fuel filling alert</li>
          <li><img src="{{url('/')}}/assets/images/fuel-low.png" style="margin:0 2% 0 0">Sudden decrease in fuel level alert</li>
        </ul>
  </div>
</div>
         <!-- <button type="button" class="btn btn-lg btn-block btn-outline-primary">Pay Now</button> -->
      </div>

    </div>
    
    <div class="card mb-3 shadow-sm">
  <div style="height:72px">
 <!--  <img src="{{url('/')}}/premium/car4.jpg" class="card-img-top" alt="..."  style="width:7rem;margin:2% auto;"> -->
<!--   <div class="card-body">
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div> -->
</div>
      <div class="card-header">
        <h4 class="my-0 font-weight-normal">PRO (White label)</h4>
      </div>
      <button type="button" class="btn"><a href="{{url('/')}}/payments?plan=pro">Pay Now</a></button>
      <div class="card-body">
        <!-- <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1> -->
        <ul class="list-unstyled mt-3 mb-4">
          <li><b>Everything in Superior +</b></li>
          <li><i class="far fa-caret-square-left"></i>Route playback history(6 Months)</li>
          <li><img src="{{url('/')}}/assets/images/geofence.png" style="margin:0 2%">Geofence(10 Geofences)</li>
          <li><i class="fas fa-list"></i>Whitelist</li>
          <li><img src="{{url('/')}}/assets/images/www.png" style="margin:0 2%">Client domain</li>
          <li><img src="{{url('/')}}/assets/images/api.png" style="margin:0 2%">API access</li>
          <li><img src="{{url('/')}}/assets/images/design.png" style="margin:0 2%">Modify design(as per requirement)</li>
          <li><img src="{{url('/')}}/assets/images/custom.png" style="margin:0 2%">Custom features</li>
          <li><img src="{{url('/')}}/assets/images/database.png" style="margin:0 2%">Database backup</li>
          <li><img src="{{url('/')}}/assets/images/support.png" style="margin:0 2%">Privileged support</li>
          <li style="height:30px"></li> 
        </ul>
        <p>
  <a  data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
   Alert Report (6 months history)
  </a>
</p>
<a data-toggle="collapse" href="#collapseExample3"><img src="{{url('/')}}/assets/images/download.gif" width="20" height="30"></a>
<div class="collapse" id="collapseExample3">
  <div class="card card-body" style="margin:0!important">
  <ul class="list-unstyled mt-3 mb-4">
          <li><img src="{{url('/')}}/assets/images/braking.png" style="margin:0 2% 0 0">Harsh Braking Alert</li>
          <li><img src="{{url('/')}}/assets/images/accelaration.png" style="margin:0 2% 0 0">Harsh Acceleration Alert</li>
          <li><img src="{{url('/')}}/assets/images/turning.png" style="margin:0 2% 0 0">Rash Turning Alert</li>
          <li><img src="{{url('/')}}/assets/images/box-open.png" style="margin:0 2% 0 0">GPS Box Opened Alert</li>
          <li><img src="{{url('/')}}/assets/images/geofence-entry.png" style="margin:0 2% 0 0">Geofence Entry Alert</li>
          <li><img src="{{url('/')}}/assets/images/geofence-exit.png" style="margin:0 2% 0 0">Geofence Exit Alert</li>
          <li><img src="{{url('/')}}/assets/images/connect-battery.png" style="margin:0 2% 0 0">Vehicle Battery Reconnect/ Connect back to main battery Alert</li>
          <li><i class="fas fa-battery-quarter"></i>Low battery Alert</li>
          <li><img src="{{url('/')}}/assets/images/low-battery.png" style="margin:0 2% 0 0">Low battery removed Alert</li>
          <li><img src="{{url('/')}}/assets/images/button.png" style="margin:0 2% 0 0">Emergency button wiredisconnect/wirecut Alert</li>
          <li><img src="{{url('/')}}/assets/images/disconnect.png" style="margin:0 2% 0 0">Disconnect from main battery Alert</li>
          <li><img src="{{url('/')}}/assets/images/overspeed.png" style="margin:0 2% 0 0">Over speed Alert</li>
          <li><img src="{{url('/')}}/assets/images/tilt.png" style="margin:0 2% 0 0">Tilt Alert</li>
          <li><img src="{{url('/')}}/assets/images/impact.png" style="margin:0 2% 0 0">Impact Alert</li>
          <li><img src="{{url('/')}}/assets/images/geo-entry.png" style="margin:0 2% 0 0">Overspeed+ GF Entry Alert</li>
          <li><img src="{{url('/')}}/assets/images/geo-exit.png" style="margin:0 2% 0 0">Overspeed + GF Exit Alert</li>
          <li><img src="{{url('/')}}/assets/images/location.png" style="margin:0 2% 0 0">Location Update Alert</li>
          <li><img src="{{url('/')}}/assets/images/location-update.png" style="margin:0 2% 0 0">Location Update (history) Alert</li>
          <li><img src="{{url('/')}}/assets/images/ignition-on.png" style="margin:0 2% 0 0">Alert – Ignition ON Alert</li>
          <li><img src="{{url('/')}}/assets/images/ignition-off.png" style="margin:0 2% 0 0">Alert – Ignition OFF Alert</li>
          <li><img src="{{url('/')}}/assets/images/state-on.png" style="margin:0 2% 0 0">Alert – Emergency state ON* Alert</li>
          <li><img src="{{url('/')}}/assets/images/state-off.png" style="margin:0 2% 0 0">Alert – emergency State OFF Alert</li>
          <li><img src="{{url('/')}}/assets/images/air.png" style="margin:0 2% 0 0">Alert Over the air parameter change Alert</li>
          <li><img src="{{url('/')}}/assets/images/towing.png" style="margin:0 2% 0 0">Towing alert</li>
          <li><img src="{{url('/')}}/assets/images/fuel.png" style="margin:0 2% 0 0">Fuel filling alert</li>
          <li><img src="{{url('/')}}/assets/images/fuel-low.png" style="margin:0 2% 0 0">Sudden decrease in fuel level alert</li>
          <li><img src="{{url('/')}}/assets/images/report.png" style="margin:0 2% 0 0">Customized report</li>
        </ul>
  </div>
</div>
         <!-- <button type="button" class="btn btn-lg btn-block btn-outline-primary">Pay Now</button> -->
      </div>

    </div>
    
  </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
</body>
@endsection