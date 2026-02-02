@extends('layouts.eclipse')
@section('title')
Production(Service)
@endsection
@section('content')   
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Production(Service)</li>
        <b>Production(Service)</b>
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
        <div class="card-body">
          <div class="table-responsive">
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">          
                <div class="row">

   
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Production</h6>


                    <div class="row">
                        <input type="hidden" value="{{ $servicein->id }}" id="serviceid">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>IMEI</label>
                                <input class="form-control" value="{{ $servicein->imei }}" name="entry_no" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>SL. NO</label>
                                <input class="form-control" value="{{ $servicein->serial_no }}" name="slno" required
                                    readonly>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <label>Customer Name</label>
                            <input class="form-control"  value="{{ $servicein->customer_name }}" name="customername" required
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Mobile</label>
                            <input class="form-control" value="{{ $servicein->customermobile }}" name="mobile" required
                                readonly>
                        </div>

                    </div> --}}
                    {{-- @if ($servicein->is_dealer == false) --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Customer Name</label>
                                    <input class="form-control" value="{{ $servicein->customer_name }}" name="customername"
                                        required readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Mobile</label>
                                    <input class="form-control" value="{{ $servicein->customermobile }}" name="mobile"
                                        required readonly>
                                </div>
                            </div>

                        </div>
                    {{-- @elseif ($servicein->is_dealer == true) --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Dealer Name</label>
                                    <input class="form-control" value="{{ $servicein->dealer_name }}" name="dealername"
                                        required readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Dealer Mobile</label>
                                    <input class="form-control" value="{{ $servicein->dealermobile }}" name="dealermobile"
                                        required readonly>
                                </div>
                            </div>

                        </div>
                    {{-- @endif --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Complaint Type</label>
                                <input class="form-control" value="{{ $servicein->type->name }}" name="complaint_type"
                                    required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Address</label>
                                <textarea class="form-control" name="address" required readonly>{{ $servicein->address }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>MSISDN</label>
                                <input class="form-control" id="msisdn" value="{{ $servicein->msisdn }}"
                                    name="complaint_type" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>SIM 1</label>
                                <input class="form-control" id="sim1" value="{{ $servicein->sim1 }}"
                                    name="complaint_type" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>SIM 2</label>
                                <input class="form-control" id="sim2" value="{{ $servicein->sim2 }}"
                                    name="complaint_type" required>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-top: 14px">
                            <br>
                            <input value="1" name="warranty" type="radio" id="warranty"
                                @if ($servicein->warranty) checked @endif readonly disabled>
                            <label> Warranty</label>
                            &nbsp; <input value="1" name="is_renewal" type="radio"
                                id="renewal"@if ($servicein->is_renewal) checked @endif readonly disabled>
                            <label> Renewal</label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Vehicle Number</label>
                                <input class="form-control" value="{{ $servicein->vehicle_no }}" name="customername"
                                    required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3" style="margin-top: 14px">
                                <br>
                                <input value="1" name="Customer" type="radio" id="warranty"
                                    @if ($servicein->is_dealer==false) checked @endif readonly disabled>
                                <label> Customer</label>
                                &nbsp; <input value="1" name="Dealer" type="radio"
                                    id="renewal"@if ($servicein->is_dealer==true) checked @endif readonly disabled>
                                <label> Dealer</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Comments</label>
                            <textarea class="form-control" name="comments" required readonly>{{ $servicein->comments }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="button" onclick="addsimdetails()" value="Save" style="margin-top: 5px"
                                class="btn btn-primary float-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Summery</h6>


                    <div class="row">
                        <div class="card-body" style="margin-top: 15%">
                            <div class="row">
                                <div class="col-md-6">
                                    Date :
                                </div>
                                <div class="col-md-6">
                                    <span>{{ $servicein->fdate }}</span>

                                    {{-- <span class="form-control">{{ $servicein->fdate }}</span> --}}
                                </div>
                                <div class="col-md-6">
                                    Entry No :
                                </div>
                                <div class="col-md-6">

                                    <span>{{ $servicein->entry_no }}</span>
                                    {{-- <span class="form-control">{{ $servicein->fdate }}</span> --}}
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <span>Gross : </span>
                                </div>
                                <div class="col-md-6">
                                    <span style="font-weight:bold" id="grosstotal"></span>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <span>Tax &nbsp; &nbsp; : </span>

                                </div>
                                <div class="col-md-6">
                                    <span style="font-weight:bold" id="taxtotal"></span>
                                </div>
                            </div>
                            @if ($servicein->is_renewal == true)
                                <div class="row">
                                    <div class="col-md-6">
                                        <span>Renewal Charge :</span><span id="customerrenewaltotal"></span><br>
                                    </div>
                                    <div class="col-md-6">
                                        <span id="recharge">{{ $renewalcharge }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><span>Total &nbsp;: </span></h5>
                                </div>
                                <div class="col-md-6">
                                    <h5> <span style="font-weight:bold" id="totaltotal"></span></h5>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Add Components</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Product</label>
                            <select name="productss" id="productss" class="">
                                <option value='0'>-- Select Product --</option>

                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Qantity</label>
                            <input type="text" name="qty" id="qty" value="" class="form-control"
                                placeholder="QTY">
                        </div>
                        <div class="col-md-12">
                            <label>Comments</label>
                            <textarea id="comments" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12">
                            <button type="button" onclick="addproduct()" style="margin-top: 2%;"
                                class="btn btn-primary float-right">Add</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <form method="POST" action="{{ url('add-products/' . $servicein->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                                <h6 class="card-title mb-0">Products</h6>
                                <input type="submit" class="btn btn-primary float-right">

                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="pros">
                                    <thead>
                                        <tr id="0">
                                            <th class="pt-0">#</th>
                                            <th class="pt-0">Product</th>
                                            <th class="pt-0">Qantity</th>
                                            <th class="pt-0">Price</th>
                                            <th class="pt-0">Gross</th>
                                            <th class="pt-0">TAX</th>
                                            <th class="pt-0">Total</th>
                                            <th class="pt-0">Comments</th>
                                            <th class="pt-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="addedproducts">

                                        @foreach ($servicein->particulars as $serv)
                                            <tr id="{{ $loop->index + 1 }}">
                                                <td>{{ $loop->index + 1 }}<input
                                                        style="width: 100%; border-top-style: hidden; border-right-style: hidden;border-left-style:hidden;border-bottom-style: hidden;"
                                                        type="hidden" value="{{ $serv->product_id }}"
                                                        name="productids[]" readonly></td>
                                                <td>{{ $serv->products->name }}</td>
                                                <td><input
                                                        style=" border-top-style: hidden; border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;"
                                                        name="quantity[]" value="{{ $serv->qty }}" readonly></td>
                                                <td>{{ $serv->price }}</td>

                                                <td>{{ number_format((float)$serv->gross, 2, '.', '') }}</td>
                                                <td>{{number_format((float)$serv->tax, 2, '.', '') }}</td>
                                                <td>{{ number_format((float)$serv->total, 2, '.', '') }}</td>
                                                <td><input type="text"
                                                        style=" border-top-style: hidden; border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;"
                                                        name="comments[]" value="{{ $serv->comments }}" readonly></td>
                                                <td><i class="fa fa-trash"
                                                        onclick="deleteproduct({{ $loop->index + 1 }})"></i></td>
                                            </tr>
                                        @endforeach






                                    </tbody>
                                </table>
                            </div>
                        </div>





                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function addsimdetails() {
            let msisdn = $('#msisdn').val();
            let sim1 = $('#sim1').val();
            let sim2 = $('#sim2').val();
            let id = $('#serviceid').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url': "{{ url('set-sim-details-update') }}/" + id + "",
                'method': "GET",
                data: {
                    msisdn: msisdn,
                    sim1: sim1,
                    sim2: sim2,
                },
                'contentType': 'application/json'
            }).done(function(data) {

                if (data.status == true)

                {
                    location.reload();
                }

            });

        }



        function addproduct() {
            var product_id = $('#productss').val();

            $.ajax({
                'url': "{{ url('getproduct') }}/" + product_id + "",
                'method': "GET",
                'contentType': 'application/json'
            }).done(function(data) {
                var productname = String(data.name);
                console.log(data.name);
                var price = data.price;
                // var gst = data.gst;
                var qty = $('#qty').val();
                var com = $('#comments').val();


                let gross = parseFloat(price * qty);
                let gst = parseFloat(data.gst * qty);
                let total = parseFloat(gross + gst);
                var i = parseInt($('#pros tr:last').attr('id')) + 1;
                //    let i= $("#pros").find("tr").last().length + 1;



                if (qty > 0)

                {
                    document.getElementById("addedproducts").innerHTML +=
                        '<tr id="' + i +
                        '"><td>' + i +
                        '<input style="width: 100%; border-top-style: hidden; border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;" type="hidden" value="' +
                        data
                        .id + '" name="productids[]" readonly></td><td>' + data.name +
                        '</td><td><input style=" border-top-style: hidden; border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;" name="quantity[]" value="' +
                        qty + '" readonly></td><td>' + price + '</td><td>' + precise(gross) + '</td><td>' +
                            precise(gst) +
                        '</td><td>' + precise(total) +
                        '</td><td><input type="text" style=" border-top-style: hidden; border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;" name="comments[]" value="' +
                        com +
                        '" readonly></td><td><a onclick="deleteproduct(' + i +
                        ')"><i class="fa fa-trash" ></i></a></td></tr>'
                }


            })
            gettotal();



        }

        function deleteproduct(i) {
            const element = document.getElementById(i);
            element.remove();
            gettotal();

        }


        $(document).ready(function() {
            var gross = 0;
            let totaltotal = 0;
            let totalprice = 0;
            let taxtotal = 0;
            $("#pros tbody tr").each(function(index) {
                taxtotal += $(this).children().eq(5).text() * 1;

                gross += $(this).children().eq(4).text() * 1;
                totaltotal += $(this).children().eq(6).text() * 1;
            });

            let renwalcharge = $('#recharge').text();

            if ($('#recharge').length == 0) {

                let charge = 0;
                document.getElementById("grosstotal").innerHTML = Number((gross).toFixed(2));
                document.getElementById("totaltotal").innerHTML = Number((parseFloat(totaltotal) + parseFloat(
                    charge))).toFixed(2);
                document.getElementById("taxtotal").innerHTML = precise(taxtotal);
            } else {
                let charge = renwalcharge;
                document.getElementById("grosstotal").innerHTML = Number((gross).toFixed(2));
                document.getElementById("totaltotal").innerHTML = Number((parseFloat(totaltotal) + parseFloat(
                    charge))).toFixed(2);
                document.getElementById("taxtotal").innerHTML = precise(taxtotal);

            }
        });
        window.setInterval(function() {
            gettotal();
        }, 1000);

        function gettotal() {
            var gross = 0;
            let totaltotal = 0;
            let totalprice = 0;
            let taxtotal = 0;
            $("#pros tbody tr").each(function(index) {
                taxtotal += $(this).children().eq(5).text() * 1;

                gross += $(this).children().eq(4).text() * 1;
                totaltotal += $(this).children().eq(6).text() * 1;
            });

            let renwalcharge = $('#recharge').text();

            if ($('#recharge').length == 0) {

                let charge = 0;
                document.getElementById("grosstotal").innerHTML = Number((gross).toFixed(2));
                document.getElementById("totaltotal").innerHTML = Number((parseFloat(totaltotal) + parseFloat(
                    charge))).toFixed(2);
                document.getElementById("taxtotal").innerHTML = precise(taxtotal);
            } else {
                let charge = renwalcharge;
                document.getElementById("grosstotal").innerHTML = Number((gross).toFixed(2));
                document.getElementById("totaltotal").innerHTML = Number((parseFloat(totaltotal) + parseFloat(
                    charge))).toFixed(2);
                document.getElementById("taxtotal").innerHTML = precise(taxtotal);

            }
        }
    </script>
    <script type="text/javascript">
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {

            $("#productss").select2({
                ajax: {
                    url: "{{ url('select2/products') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: CSRF_TOKEN,
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }

            });

        });
    </script>
@endpush
