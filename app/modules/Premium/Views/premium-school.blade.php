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
          <h4 class="my-0 font-weight-normal">Basic</h4>
        </div>
        <div class="card-body">
          <!-- <h1 class="card-title pricing-card-title">$15 <small class="text-muted">/ mo</small></h1> -->
          <ul class="list-unstyled mt-3 mb-4">
            <li><i class="fas fa-mobile-alt"></i>Parent mobile application</li>
            
          </ul>
          <p>
            <a  data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
             ALERTS AS NOTIFICATION
            </a>
          </p>
          <a data-toggle="collapse" href="#collapseExample"><img src="{{url('/')}}/assets/images/download.gif" width="20" height="30"></a>
          <div class="collapse" id="collapseExample">
            <div class="card card-body" style="margin:0!important">
              <ul class="list-unstyled mt-3 mb-4">
                <li><img src="{{url('/')}}/assets/images/braking.png" style="margin:0 2% 0 0">Bus starts from starting point (Starting of pick up)</li> 
                <li><img src="{{url('/')}}/assets/images/accelaration.png" style="margin:0 2% 0 0">Bus reaches the assigned stop</li>
                <li><img src="{{url('/')}}/assets/images/turning.png" style="margin:0 2% 0 0">Bus reaches school</li>
                <li><img src="{{url('/')}}/assets/images/box-open.png" style="margin:0 2% 0 0">Bus starts from school (starting of drop off)</li> 
                <li><img src="{{url('/')}}/assets/images/geofence-entry.png" style="margin:0 2% 0 0">Bus reaches drop off point</li> 
                <li><img src="{{url('/')}}/assets/images/geofence.png" style="margin:0 2% 0 0">Geofence alert (For bus in and out for particular stops)</li>
                <li><img src="{{url('/')}}/assets/images/connect-battery.png" style="margin:0 2% 0 0">Prior stop alert</li> 
                <li><img src="{{url('/')}}/assets/images/low-battery.png" style="margin:0 2% 0 0">bus fee payment alert</li> 
                <li><img src="{{url('/')}}/assets/images/button.png" style="margin:0 2% 0 0">Bus breakdown alert</li>
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
        <h4 class="my-0 font-weight-normal">PREMIUM</h4>
      </div>
      <button type="button" class="btn"><a href="#">Pay Now</a></button>
      <div class="card-body">
        <!-- <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1> -->
        <ul class="list-unstyled mt-3 mb-4">
          <li><b>Everything in Basic +</b></li>
          <li><i class="far fa-caret-square-left"></i>Payment gateway for fee payment</li>
          <li><img src="{{url('/')}}/assets/images/www.png" style="margin:0 2%">NFC Integration</li>
          <li><img src="{{url('/')}}/assets/images/api.png" style="margin:0 2%">NFC Swiping alerts(Student entry/exit)</li>
          <li><img src="{{url('/')}}/assets/images/design.png" style="margin:0 2%">Alerts as text message</li>
        </ul>
        <p>
          <a  data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
          Alert Reports (6 months history)
          </a>
        </p>
        <a data-toggle="collapse" href="#collapseExample3"><img src="{{url('/')}}/assets/images/download.gif" width="20" height="30"></a>
        <div class="collapse" id="collapseExample3">
          <div class="card card-body" style="margin:0!important">
            <ul class="list-unstyled mt-3 mb-4">
              <li><img src="{{url('/')}}/assets/images/overspeed.png" style="margin:0 2% 0 0">Over speed Alert</li>
              <li><img src="{{url('/')}}/assets/images/tilt.png" style="margin:0 2% 0 0">Route deviation Alert</li>
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