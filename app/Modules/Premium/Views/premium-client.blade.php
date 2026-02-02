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
  @foreach($subscription as $sub)
    <div class="card mb-3 shadow-sm">
      <div style="height:72px">
        <!-- <img src="{{url('/')}}/premium/car1.jpg" class="card-img-top" alt="..." style="width: 7rem;margin: 3% auto"> -->
      <!--   <div class="card-body">
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div> -->
      </div>
      <div class="card-header">
        <h4 class="my-0 font-weight-normal">{{$sub->name}} </h4>
      </div>
      <div class="card-body">
      <?php
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";
        $encryption_id=encrypt(4);
        if (strpos($url, $rayfleet_key) == true) {  ?>
           <button type="button" class="btn"><a href="#" class="js-modal-show button-primary" onclick="popup()">Pay Now</a></button>
          <div class="l-modal is-hidden--off-flow js-modal-shopify">
            <div class="l-modal__shadow js-modal-hide"></div>
            <div class="c-popup l-modal__body">
              <a href="#" onclick="hide_popup()">X</a>
              <p class="blink_me" style="color: red">Contact your distributor for upgradation</p>
            </div>
          </div>
        <?php } 
        else if (strpos($url, $eclipse_key) == true) { ?>
           <button type="button" class="btn"><a href="#" class="js-modal-show button-primary" onclick="popup()">Pay Now</a></button>
          <div class="l-modal is-hidden--off-flow js-modal-shopify">
            <div class="l-modal__shadow js-modal-hide"></div>
            <div class="c-popup l-modal__body">
              <a href="#" onclick="hide_popup()">X</a>
              <p class="blink_me" style="color: red">Contact your distributor for upgradation</p>
            </div>
          </div>
        <?php }
        else { ?>
           <button type="button" class="btn"><a href="#" class="js-modal-show button-primary" onclick="popup()">Pay Now</a></button>
          <div class="l-modal is-hidden--off-flow js-modal-shopify">
            <div class="l-modal__shadow js-modal-hide"></div>
            <div class="c-popup l-modal__body">
              <a href="#" onclick="hide_popup()">X</a>
              <p class="blink_me" style="color: red">Contact your distributor for upgradation</p>
            </div>
          </div>
      <?php } ?> 

      

      {!!$sub->description!!}
          </div>
        
        <!-- <button type="button" class="btn btn-lg btn-block btn-primary">Try Now</button> -->
    
    </div>
    @endforeach
         <!-- <button type="button" class="btn btn-lg btn-block btn-outline-primary">Pay Now</button> -->
      </div>

  
    
  </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
</body>
@endsection
<script type="text/javascript">
function popup()
{
  $('.js-modal-shopify').toggleClass('is-shown--off-flow').toggleClass('is-hidden--off-flow');
}
function hide_popup(){
  $('.js-modal-shopify').toggleClass('is-shown--off-flow').toggleClass('is-hidden--off-flow');
}
</script>
<style type="text/css">
  .is-hidden--off-flow {
  opacity: 0;
  transition: all 0.2s ease-in-out;
  z-index: -10;   /* *1* */
  visibility: hidden;   /* *1* */
}


.l-modal {
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  height: 100%;
  margin: 0 auto;
  z-index: 2;
  text-align: center;
}

.l-modal__shadow {
  width: 100%;
  height: 100%;
  position: fixed;
  display: block;
  background: #161616;
  opacity: 0.92;
  z-index: -1;
  cursor: pointer;
}

.l-modal__body {
  position: relative;
  top: 50%;
  transform: translateY(-50%);
}

.c-popup {
    display: inline-block;
    text-align: center;
    background: white;
    max-width: 400px;
    width: 90%;
    line-height: 1.48;

    border-radius: 7px;
    background: #ccc;
}
.l-modal .l-modal__shadow {
    width: 100%;
    height: 100%;
    position: fixed;
    display: block;
    background: #0000008f;
    opacity: 0.92;
    z-index: -1;
    cursor: pointer;
}
.l-modal__body a{
    background: #b9b9b9;
    width: 100%;
    float: left;
    padding: 6px 0;
    color: #fff;
    font-weight: bold;
    text-align: right;
        font-size: 20px;
      border-top-left-radius: 7px;
    padding-right: 4%;
      border-top-right-radius:7px;
  }
.l-modal__body a:hover{
color: #000;
  }
.l-modal__body p{
float: left;
    text-align: center;
    width: 100%;
    font-size: 18px;
    padding: 22px 0;}

</style>