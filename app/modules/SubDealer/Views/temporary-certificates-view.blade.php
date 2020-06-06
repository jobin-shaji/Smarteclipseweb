@extends('layouts.eclipse')
@section('title')
  View Dealer
@endsection
@section('content')
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Temporary Certificates Detailed View</li>
        <b>Temporary Certificates Detailed View</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav>        
    <div class="container-fluid">
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">
          <div class="box box-success">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
            </div>
                <?php 
                $datas = json_decode($data['details'],true);
                $encript = Crypt::encrypt($data->id);
                ?>
              <div class="box-body">
                <ul class="list-group">
                  <li class="list-group-item">
                    <b>Plan:</b> {{$datas['plan_name']}}
                  </li>
                  <li class="list-group-item">
                    <b>End User:</b> {{$datas['client_name']}}
                  </li>
                  <li class="list-group-item">
                    <b>IMEI:</b> {{$datas['imei']}}
                  </li>
                  <li class="list-group-item">
                    <b>Model:</b> {{$datas['device_model']}}
                  </li>
                  <li class="list-group-item">
                    <b>Manufacturer:</b> {{$datas['manufacturer_name']}}
                  </li>
                  <li class="list-group-item">
                    <b>CDAC Certification Number:</b> {{$datas['cdac_certification_number']}}
                  </li>
                  <li class="list-group-item">
                    <b>Registration Number:</b> {{$datas['vehicle_registration_number']}}
                  </li>
                  <li class="list-group-item">
                    <b>Engine Number:</b> {{$datas['vehicle_engine_number']}}
                  </li>
                  <li class="list-group-item">
                    <b>Chasis Number:</b> {{$datas['vehicle_chasis_number']}}
                  </li>
                  <li class="list-group-item">
                    <b>Owner Name:</b> {{$datas['owner_name']}}
                  </li>
                  <li class="list-group-item">
                    <b>Owner Address:</b> {{$datas['owner_address']}}
                  </li>
                  <li class="list-group-item">
                    <b>Date of Installation:</b> {{$datas['device_expected_date_of_installation']}}
                  </li>
                  <li class="list-group-item">
                    <button class="btn btn-primary btn-md form-btn "><i class="fa fa-download"></i>
                        <a href="{{route('temporary.certificate.downloads',$encript)}}" style="color:white">Download Certificate</a>
                    </button>
                  </li>
                </ul>                   
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection