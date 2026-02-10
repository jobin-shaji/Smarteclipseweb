<!-- SUB DEALER ROLE-START -->
@role('sub_dealer')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <div class="row">
      <div class="col-lg-3 col-xs-6 new_arrival_dashboard_grid dash_grid">
        <div class="small-box bg-green bxs">
          <div class="inner inner-left">
            <h3 id="gps_new_arrival_subdealer">
              <div class="loader"></div>
            </h3>
            <p>New Arrivals</p>
          </div>
          <div class="icon">
            <i class="fa fa-tablet"></i>
          </div>
          <div class="a-tag">
            <a href="/gps-subdealer-new" class="small-box-footer1 view-last">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 dealer_dashboard_grid dash_grid">
        <!-- small box -->
        <div class="small-box bg-green bxs">
          <div class="inner inner-left">
            <h3 id="total_gps_subdealer">
              <div class="loader"></div>
            </h3>
            <p>Total GPS </p>
          </div>
          <div class="icon">
            <i class="fa fa-tablet"></i>
          </div>
          <div class="a-tag">
            <a href="/gps-sub-dealer" class="small-box-footer1 view-last">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 gps_dashboard_grid dash_grid">
        <!-- small box -->
        <div class="small-box bg-green bxs">
          <div class="inner inner-left">
            <h3 id="gps_in_stock_subdealer">
              <div class="loader"></div>
            </h3>
            <p>GPS In Stock</p>
          </div>
          <div class="icon">
            <i class="fa fa-tablet"></i>
          </div>
          <div class="a-tag">
            <a href="/gps-in-stock-sub-dealer" class="small-box-footer1 view-last">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6 transferred_gps_dashboard_grid dash_grid">
        <!-- small box -->
        <div class="small-box bg-green bxs">

          <div class="inner inner-left">
            <div class="box-2">
              <div style="float:left; width:50%">
                <h3 id="transferred_gps_from_dealer_to_trader_awaiting"></h3>
                <p class="mrg-bt-0">Awaiting Confirmation</p>
              </div>
              <div style="float:left; width:50%">
                <h3 id="transferred_gps_from_dealer_to_trader"></h3>
                <p class="mrg-bt-0">Transferred GPS To Sub Dealer</p>
              </div>
            </div>
          </div>
          <div class="icon">
            <i class="fa fa-tablet"></i>
          </div>
          <a href="/gps-transfers-subdealer-to-trader" class="small-box-footer view-last">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 transferred_gps_dashboard_grid dash_grid">
        <!-- small box -->
        <div class="small-box bg-blue bxs">
          <div class="inner">
            <h3 id="transferred_gps_from_dealer_to_client">
              <div class="loader"></div>
            </h3>
            <p>Transferred GPS To End User</p>
          </div>
          <div class="icon">
            <i class="fa fa-tablet"></i>
          </div>
          <a href="/gps-transfers-subdealer" class="small-box-footer small-box-footer2">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 gps_returned_dashboard_grid dash_grid">
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
      <div class="col-lg-3 col-xs-6 sub_dealer_dashboard_grid dash_grid">
          <!-- small box -->
          <div class="small-box bg-green bxs">

            <div class="inner inner-left">
              <div class="box-2">
                <div style="float:left; width:50%">
                  <h3 id="subdealer_trader"></h3>
                  <p class="mrg-bt-0">Active Sub Dealers</p>
                </div>
                <div style="float:left; width:50%">
                  <h3 id="subdealer_client"></h3>
                  <p class="mrg-bt-0">Active End Users</p>
                </div>
              </div>
            </div>
            <a href="/trader" class="small-box-footer" style='float: left;width: 50%;'>View <i class="fa fa-arrow-circle-right"></i></a>
            <a href="/clients" class="small-box-footer" style='float: left;width: 50%;'>View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>   
      <div class="col-lg-3 col-xs-6 client_dashboard_grid dash_grid">
        <!-- small box -->
        <div class="small-box bg-blue bxs">
          <div class="inner">
            <h3 id="subdealer_complaints">
              <div class="loader"></div>
            </h3>
            <p>New Complaints</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="/complaint" class="small-box-footer small-box-footer2">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6 col-xs-6">
        <canvas id="rootChart" style="max-width: 100%;"></canvas>
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
@endrole
<!-- SUB DEALER ROLE-END -->
