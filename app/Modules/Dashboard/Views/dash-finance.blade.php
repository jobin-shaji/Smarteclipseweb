<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <section class="content">
      <div class="row">
       
      @foreach($components as $comp)
        <div class="col-lg-3 col-md-6 col-sm-12  gps_dashboard_grid dash_grid" style="background-color: #009182!important">
          <div class="small-box bg-green bxs">
            <div class="inner">
              <h3 id="new_installation_jobs">
              Box-{{$comp->box_no}}
              </h3>
              <p>{{$comp->name}}</p>

              <p id="print-{{$comp->id}}" style="text-align:center">{{$comp->description}}</p><p><span id="dots-{{$comp->id}}">....</span><span id="more-{{$comp->id}}" style="display:none"><button onclick="printDiv({{$comp->id}})">Print</button></span></p>

<button onclick="myFunction({{$comp->id}})" id="myBtn-{{$comp->id}}">Read more</button>
              <p>Stocks:{{$comp->stocks}}</p>

            </div>
            <div class="icon">
              <i class="fa fa-tablet"></i>
            </div>
            <a href="/view-components/{{$comp->id}}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endforeach
     
    </section>
  </div>
</div>
