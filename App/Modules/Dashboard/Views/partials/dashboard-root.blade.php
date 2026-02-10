<!-- ROOT ROLE-START -->
@role('root')
<style>
  .btn-pop {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: #ccc;
    border: 1px solid transparent;
    padding: 0 .21rem;
    line-height: 2;
    font-size: .75rem !important;
    border-radius: .25rem;
    margin: 0 .1rem .5rem .1rem;
    color: #000;
  }

  .btn-pop:hover {
    background: #f7b018;
  }
</style>

<title></title>
<meta name="viewport" content="initial-scale=1.0">
<meta charset="utf-8">
<link href='https://fonts.googleapis.com/css?family=Raleway:300,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="style.css" type="text/css" media="all">
<script src="modernizr.js"></script>
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6 new_arrival_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner inner-left">
              <div class="box-2">
                <div style="float:left; width:50%">
                  <h3 id="gps_manufactured"></h3>
                  <p class="mrg-bt-0">GPS Devices Manufactured</p>
                </div>
                <div style="float:left; width:50%">
                  <h3 id="refurbished_devices"></h3>
                  <p class="mrg-bt-0">Refurbished GPS Devices</p>
                </div>
              </div>
            </div>
            <a href="/gps-all" class="small-box-footer view-last">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">

            <div class="inner inner-left">
              <div class="box-2">
                <div style="float:left; width:50%">
                  <h3 id="gps"></h3>
                  <p class="mrg-bt-0">GPS Devices In Stock</p>
                </div>
                <div style="float:left; width:50%">
                  <h3 id="refurbished_gps"></h3>
                  <p class="mrg-bt-0">Refurbished GPS Devices In Stock</p>
                </div>
              </div>
            </div>
            <a href="/gps" class="small-box-footer view-last">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 transferred_gps_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="gps_transferred">
                <div class="loader"></div>
              </h3>
              <p>GPS Devices Transferred</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/gps-transferred-root" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 gps_non_stock_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="gps_to_be_added_to_stock">
                <div class="loader"></div>
              </h3>
              <p>GPS Devices: To be added to stock</p>
            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="row"> 
        <div class="col-lg-3 col-xs-6 gps_returned_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">

            <div class="inner inner-left">
              <div class="box-2">
                <div style="float:left; width:50%">
                  <h3 id="gps_returned"></h3>
                  <p class="mrg-bt-0">GPS Devices: Returned</p>
                </div>
                <div style="float:left; width:50%">
                  <h3 id="gps_returned_request"></h3>
                  <p class="mrg-bt-0">GPS Devices: Return Request</p>
                </div>
              </div>
            </div>
            <a href="/returned-gps" class="small-box-footer" style='float: left;width: 49%;'>View <i class="fa fa-arrow-circle-right"></i></a>
            <a href="/device-return-history-list" class="small-box-footer" style='float: left;width: 51%;'>View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>          
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 dealer_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <h3 id="dealer">
                <div class="loader"></div>
              </h3>
              <p>Active Distributors</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 sub_dealer_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-blue bxs">
            <div class="inner">
              <h3 id="sub_dealer">
                <div class="loader"></div>
              </h3>
              <p>Active Dealers</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/sub-dealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6 client_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="client">
                <div class="loader"></div>
              </h3>
              <p>Active End Users</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="/client" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-xs-6">
          <canvas id="rootChart" style="max-width: 100%; height: 200px;"></canvas>
        </div>
        <div class="col-lg-6 col-xs-6">
          <canvas id="rootChartUser" style="max-width: 100%; height: 200px;"></canvas>
        </div>
        <div class="col-lg-6 col-xs-6">
          <canvas id="rootGpsSaleChart" style="max-width: 100%; height: 200px;"></canvas>
        </div>
        
      </div>
       <div class="row">
        
      </div>
    </section>
  </div>
</div>
@endrole
<!-- ROOT ROLE-END -->
