@extends('layouts.gps-client')
@section('title')
  List GPS
@endsection
@section('content')
    <section class="content-header">
        <h1>Create vehicle</h1>
    </section>
   

<section class="hilite-content">
      <!-- title row -->
       <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
             <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/List Client Gps</li>
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
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
  <div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <div class="dataTables_length" id="zero_config_length">
              <label>Select Vehicle
                <select name="zero_config_length" aria-controls="zero_config" class="form-control form-control-sm">
                  <option value="10">Select Vehicle</option>
                  
                </select>
                </label>
              </div>
            </div>
            <div class="col-sm-12 col-md-6">
              <div id="zero_config_filter" class="dataTables_filter">
                <label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="zero_config"></label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <table id="zero_config" class="table table-striped table-bordered dataTable" role="grid" aria-describedby="zero_config_info">
                <thead>
                  <tr role="row">
                    <th class="sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 260px;">Vehicle No</th>
                    <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 402px;">KL-08-AP 602</th>
                  </tr>
                </thead>
                <tbody>
                  <tr role="row" class="odd">
                    <td class="sorting_1">Chassis No</td>
                    <td></td>                   
                  </tr>
                  <tr role="row" class="even">
                      <td class="sorting_1">Engine No</td>
                      <td></td>
                      
                  </tr>
                  <tr role="row" class="odd">
                      <td class="sorting_1">Type of Vehicle</td>
                      <td></td>
                  </tr>
                  <tr role="row" class="odd">
                    <td class="sorting_1">Vehicle(Make)</td>
                    <td>TATA</td>
                     
                  </tr><tr role="row" class="even">
                      <td class="sorting_1">Vehicle(Model)</td>
                      <td>LPT1212</td>
                      
                  </tr><tr role="row" class="odd">
                      <td class="sorting_1">Registration Date</td>
                      <td>15/11/2016</td>
                      
                  </tr><tr role="row" class="even">
                      <td class="sorting_1">Date of Mfg, Year</td>
                      <td>15/07/2016</td>
                      
                  </tr><tr role="row" class="odd">
                      <td class="sorting_1">Next Service Date</td>
                      <td>15/11/2017</td>
                     
                  </tr><tr role="row" class="even">
                      <td class="sorting_1">Insurance Expiry Date</td>
                      <td>15/11/2020</td>
                      
                  </tr>

                  <tr role="row" class="even">
                      <td class="sorting_1">Pollution Expiry Date</td>
                      <td>15/05/2017</td>
                      
                  </tr>
                  <tr role="row" class="even">
                      <td class="sorting_1">Next Fitness Date</td>
                      <td>15/05/2022</td>
                      
                  </tr>    




                                        </tbody>
                                        
                                    </table></div></div><div class="row"></div></div>
                                </div>

                            </div>
                
            </div>
           
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
</section>
 
<div class="clearfix"></div>


@endsection