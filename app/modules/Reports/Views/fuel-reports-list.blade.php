@extends('layouts.eclipse')
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6 new_arrival_dashboard_grid dash_grid">
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="gps_manufactured">
                <div class="loader"></div>
              </h3>
              <p>fuel vs Datetime</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/fuel-report" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 new_arrival_dashboard_grid dash_grid">
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="gps_manufactured">
                <div class="loader"></div>
              </h3>
              <p>Fuel vs Driver</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/driver-fuel-report" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 new_arrival_dashboard_grid dash_grid">
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="gps_manufactured">
                <div class="loader"></div>
              </h3>
              <p>fuel vs vehicle</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/vehicle-fuel-report" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>      
      </div>
    </section>
  </div>
</div>

  @section('script')
    <script src="{{asset('js/gps/dashb.js')}}"></script>
  @endsection
@endsection