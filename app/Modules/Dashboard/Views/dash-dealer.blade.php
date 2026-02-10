<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <div class="container-fluid">
      <div class="card-body">
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-lg-3 col-md-6 col-sm-12  new_arrival_dashboard_grid dash_grid">
                    <div class="small-box bg-green bxs">
                      <div class="inner">
                        <h3 id="gps_new_arrival_dealer">
                          <div class="loader"></div>
                        </h3>
                        <p>New Arrivals</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-tablet"></i>
                      </div>
                      <a href="/gps-dealer-new" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12  gps_dashboard_grid dash_grid">
                    <div class="small-box bg-green bxs">
                      <div class="inner">
                        <h3 id="in_stock_gps_dealer">
                          <div class="loader"></div>
                        </h3>
                        <p>GPS In Stock</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-tablet"></i>
                      </div>
                      <a href="/gps-dealer" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12  transferred_gps_dashboard_grid dash_grid">
                    <!-- small box -->
                    <div class="small-box bg-green bxs">

                      <div class="inner inner-left">
                        <div class="box-2">
                          <div style="float:left; width:50%">
                            <h3 id="transferred_gps_awaiting"></h3>
                            <p class="mrg-bt-0">Awaiting Confirmation</p>
                          </div>
                          <div style="float:left; width:50%">
                            <h3 id="transferred_gps_dealer"></h3>
                            <p class="mrg-bt-0">Transferred GPS</p>
                          </div>
                        </div>
                      </div>
                      <div class="icon">
                        <i class="fa fa-tablet"></i>
                      </div>
                      <a href="/gps-transfers-dealer" class="small-box-footer view-last">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12  gps_returned_dashboard_grid dash_grid">
                    <!-- small box -->
                    <div class="small-box bg-green bxs">
                      <div class="inner">
                        <h3 id="gps_returned">
                          <div class="loader"></div>
                        </h3>
                        <p>GPS Devices: Return</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-tablet"></i>
                      </div>
                      <a href="/returned-gps" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-md-6 col-sm-12  sub_dealer_dashboard_grid dash_grid">
                    <!-- small box -->
                    <div class="small-box bg-yellow bxs">
                      <div class="inner">
                        <h3 id="dealer_subdealer">
                          <div class="loader"></div>
                        </h3>
                        <p>Active Dealers</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-user"></i>
                      </div>
                      <a href="/subdealers" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12  dealer_dashboard_grid dash_grid">
                    <!-- small box -->
                    <div class="small-box bg-green bxs">
                      <div class="inner">
                        <h3 id="dealer_traders">
                          <div class="loader"></div>
                        </h3>
                        <p>Active Sub Dealers</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-user"></i>
                      </div>
                      <a href="/distributor-sub-dealer" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 col-sm-12  client_dashboard_grid dash_grid">
                    <!-- small box -->
                    <div class="small-box bg-green bxs">
                      <div class="inner">
                        <h3 id="dealer_client">
                          <div class="loader"></div>
                        </h3>
                        <p>Active End Users</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-user"></i>
                      </div>
                      <a href="/dealer-client" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
               <div class="col-lg-6 col-xs-6">
                <canvas id="rootChart" style="max-width: 100%; height: 200px;"></canvas>
              </div>
              <div class="col-lg-6 col-xs-6">
                <canvas id="rootChartUser" style="max-width: 100%;"></canvas>
              </div>
               <div class="col-lg-6 col-xs-6">
              <canvas id="rootGpsSaleChart" style="max-width: 100%; height: 200px;"></canvas>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ./col -->
