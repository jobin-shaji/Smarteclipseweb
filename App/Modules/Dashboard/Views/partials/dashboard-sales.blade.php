<!-- sales ROLE-START -->
@role('sales')
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

<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6 new_arrival_dashboard_grid dash_grid">
          <div class="small-box bg-yellow bxs">
            <div class="inner">
              <h3>
                <div class="loader"></div>
              </h3>
              <p> DEVICE STOCK REPORT</p>
            </div>
            <a href="/gps-stock-report" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 transferred_gps_dashboard_grid dash_grid">
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3>
                <div class="loader"></div>
              </h3>
              <p> DEVICE TRANSFER REPORT</p>
            </div>
            <a href="/gps-transfer-report" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>        
      </div>
    </section>
  </div>
</div>
@endrole
<!-- sales ROLE-END -->
