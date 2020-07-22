@extends('layouts.eclipse')
@section('title')
  Esim Details
@endsection
@section('content')   
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Esim Details</li>
        <b>Esim Details</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav>
    <div class="container">
    <div class="col-md-3 col-lg-3 " align="center">  </div>
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td> <b>End User Details:</b></td>
                        <td>
                        <span class="user_name">
                        <?php
                        if(isset($esim->gps->gpsStock))
                        {
                          if(isset($esim->gps->gpsStock->client))
                          {
                            $client_name  = strtoupper($esim->gps->gpsStock->client->name);
                            $mobile       = $esim->gps->gpsStock->client->user->mobile;
                          }
                          else{
                            $client_name  = "NA";
                            $mobile       = "NA";
                          }

                        }
                        else{
                          $client_name    = "NA";
                          $mobile         = "NA";
                        }
                        ?>
                            <i class="fa fa-user"></i> : {{$client_name}}
                        </span>
                        <span class="user_phone" style="padding-left: 60px;">
                            <i class="fa fa-mobile"></i> : {{$mobile}}
                        </span>
                        <span class="user_role" style="padding-left: 60px;">
                        <i class='far fa-id-card'></i> : 
                        <?php
                        if(isset($esim->gps->gpsStock))
                        {
                          if($esim->gps->gpsStock->client)
                          {
                              $plan_names     = array_column(config('eclipse.PLANS'), 'NAME', 'ID');
                              $plan_name      = $plan_names[$esim->gps->gpsStock->client->user->role ? $esim->gps->gpsStock->client->user->role : 0];                            
                          }
                          else
                          {
                            $plan_name      ="NA";
                          }
                        }
                        else
                        {
                          $plan_name      ="NA";
                        }
                            echo $plan_name;
                        ?>
                        </span> 
                        </td>
                      </tr>
                      <tr>
                        <td><b>IMEI:</b></td>
                        <td>{{$esim->imei ? $esim->imei : "-"}}</td>
                      </tr>
                      <tr>
                        <td><b>MSISDN[Esim Number]:</b></td>
                        <td>{{$esim->msisdn ? $esim->msisdn : "-"}}</td>
                      </tr>
                   
                         <tr>
                             <tr>
                        <td><b>ICCID:</b></td>
                        <td> {{$esim->iccid ? $esim->iccid : "-"}}</td>
                      </tr>
                        <tr>
                        <td><b>IMSI:</b></td>
                        <td>{{$esim->imsi ? $esim->imsi : "-"}}</td>
                      </tr>
                      <tr>
                        <td><b>PUK:</b></td>
                        <td>{{$esim->puk ? $esim->puk : "-"}}</td>
                      </tr>
                        <td><b>Product Type:</b></td>
                        <td>{{$esim->product_type ? $esim->product_type : "-"}}</td> 
                      </tr>
                     
                       </tr>
                        <td><b>Activation On:</b></td>
                        <td>{{$esim->activated_on ? $esim->activated_on : "-" }}</td>
                      </tr>
                     
                      </tr>
                        <td><b>Expire On:</b></td>
                        <td>{{$esim->expire_on ? $esim->expire_on : "-"}}</td>  
                      </tr>

                      </tr>
                        <td><b>Business Unit Name:</b></td>
                        <td>{{$esim->business_unit_name ? $esim->business_unit_name : "-"}}</td>  
                      </tr>
                      </tr>
                        <td><b>Product Status:</b></td>
                        <td>{{$esim->product_status ? $esim->product_status : "-"}}</td>  
                      </tr>

                     
                     
                    </tbody>
                  </table>
                  
                  
                </div>

        </div>
  </div>

               
             
</section>
<style>
.user-row {
    margin-bottom: 14px;
}

.user-row:last-child {
    margin-bottom: 0;
}

.dropdown-user {
    margin: 13px 0;
    padding: 5px;
    height: 100%;
}

.dropdown-user:hover {
    cursor: pointer;
}

.table-user-information > tbody > tr {
    border-top: 1px solid rgb(221, 221, 221);
}

.table-user-information > tbody > tr:first-child {
    border-top: 0;
}


.table-user-information > tbody > tr > td {
    border-top: 0;
}
.toppad
{margin-top:20px;
}

</style>
 @endsection