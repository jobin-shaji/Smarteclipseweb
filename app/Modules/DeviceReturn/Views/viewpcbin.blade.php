@extends('layouts.eclipse')
@section('title')
  View PCB JOB ORDER
@endsection
@section('content')
@section('styles')
@endsection
@section('content')


<div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">PCB JOB ORDER</h6>
                    <form  method="POST" action="{{route('devicein-transfer')}}">
                    {{csrf_field()}}
                    <input type="hidden" value="{{ $servicein->id }}" name="id">
                       
                    <div class="row">
                        <div class="col-md-6">
                            <label>SERVICE</label>
                            <input class="form-control" value="{{ $servicein->service }}" name="service" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>PCB Spec Width</label>
                            <input class="form-control" value="{{ $servicein->specs_width_mm }}" name="specs_width_mm" required
                                readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>PCB Spec Height</label>
                            <input class="form-control" value="{{ $servicein->specs_height_mm }}" name="service" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>PCB Layers</label>
                            <input class="form-control" value="{{ $servicein->specs_layers }}" name="specs_width_mm" required
                                readonly>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <label>PCB Spec Quantity</label>
                            <input class="form-control" value="{{ $servicein->specs_quantity }}" name="service" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>PCB Spec Meterials</label>
                            <input class="form-control" value="{{ $servicein->specs_material }}" name="specs_width_mm" required
                                readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>PCB Spec finish</label>
                            <input class="form-control" value="{{ $servicein->specs_finish }}" name="service" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Delivery speed</label>
                            <input class="form-control" value="{{ $servicein->delivery_speed }}" name="specs_width_mm" required
                                readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>PCB Bom Stats total lines</label>
                            <input class="form-control" value="{{ $servicein->bom_stats_total_lines }}" name="service" readonly>
                        </div>
                        <div class="col-md-6">
                            <label> Bom Stats Unique Parts</label>
                            <input class="form-control" value="{{ $servicein->bom_stats_unique_parts }}" name="specs_width_mm" required
                                readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Customer Name</label>
                            <input class="form-control" value="{{ $servicein->contact_name }}" name="customername" required
                                readonly>
                        </div>
                        </div>
                    

                    </div>
                   

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>MIN SPACING</label>
                                <input class="form-control" value="{{ $servicein->vehicle_no }}" name="customername"
                                    required readonly>
                            </div>
                        </div>
                       

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Comments</label>
                            <textarea class="form-control" name="comments" required>{{ $servicein->comments }}</textarea>
                        </div>

                        @if($comments)

                        @foreach($comments as $comm)

                        <p>{{$comm->comments}}</p>
                        </br>
                        <p>Added by :{{$comm->employee->name}}
                        </p>
                        @endforeach
                        @endif
                    </div>

                    @foreach ($servicein->attachments as $items)
                    <div class="row">
                        <div class="col-md-12">
                            <label>{{$items->original_name}}</label>
                            <a href="{{$items->url}}">download</a>
                          </div>
                    </div> 
                   
                  @endforeach
                   @if($servicein->payment_proof_status=="submitted")
                    <div class="row">
                        <div class="col-md-12">
                            <label>sales payment  performa invoice</label>
                            <a href="{{$servicein->payment_proof_file_url}}">download</a>
                          </div>
                    </div>
                  @endif
                  @if($servicein->status=="requested" && $emp_depart==199)
                    <div class="row">
                        <div class="col-md-12">
                            <label>QUOTE AMOUNT</label>
                            <input class="form-control" value="" name="quote_total">
                          </div>
                    </div>
                  @endif

                    <div class="row">
                        <div class="col-md-12">
                            <label>Status</label>
                            <select class="form-control" name="status">
                           <option  value="" selected disabled>Select</option>
                        
                            <option value="{{$servicein->status}}" >{{$servicein->status}}</option>  
                        

                           </select>
                          </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Tranfer to</label>
                           <select class="form-control" name="department_id">
                           <option  value="" selected disabled>Select Department</option>
                          @foreach($department as $country)
                            <option value="{{$country->id}}" >{{$country->name}}</option>  
                          @endforeach

                           </select>

                          </div>
                    </div>

                    <div class="row">
                    <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Submit </button>
</form>
                </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $test=-1;
            if(\Auth::user()->hasRole('Finance')){?>
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
                                    <span id="grosstotal"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <span>Tax &nbsp; &nbsp; : </span>

                                </div>
                                <div class="col-md-6">
                                    <span id="taxtotal"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <span>Discount &nbsp; &nbsp; : </span>

                                </div>
                                <div class="col-md-6">
                                    <span id="dis">{{ number_format((float) ($servicein->discount + 0), 2, '.', '')  }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><span>Total &nbsp;: </span></h5>
                                </div>
                                <div class="col-md-6">
                                    <h5> <span style="font-weight:bold" id="totaltotal"></span></h5>
                                </div>
                            </div>
                            @if ($servicein->is_paid == true)
                                <div class="row">
                                    <div class="col-md-6">
                                        <span>Status&nbsp;: </span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="badge bg-success" style="color: white">Paid</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span>Reference No&nbsp;: </span>
                                    </div>
                                    <div class="col-md-6">
                                        <span style="font-weight:bold">{{ $servicein->reference_no }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <h5><span style="color: red">Total Paid&nbsp;: </span></h5>
                                    </div>
                                    <div class="col-md-6">
                                        <h5> <span
                                                style="font-weight:bold">{{number_format((float) ($servicein->paid_amount - $servicein->discount ), 2, '.', '') }}</span>
                                        </h5>
                                    </div>

                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <span>Status&nbsp;: </span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="badge bg-danger" style="color: white">Payment Pending</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span>Reference No&nbsp;: </span>
                                    </div>
                                    <div class="col-md-6">
                                        <span style="font-weight:bold">{{ $servicein->reference_no }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <h5><span style="color: red">Total Paid&nbsp;: </span></h5>
                                    </div>
                                    <div class="col-md-6">
                                        <h5> <span style="font-weight:bold">{{ $servicein->paid_amount }}</span></h5>
                                    </div>

                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
       <?php }?>
    </div>
   <!-- <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Delivery Service</th>
                                    <th>Delivery Address</th>
                                    <th>Delivery Reference</th>
                                    <th>Delivery Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $servicein->deliveryservice }}</td>
                                    <td>
                                        <div class='text-wrap width-200'>{{ $servicein->deliveryadddress }}</div>
                                    </td>
                                    <td>{{ $servicein->deliverydetails }}</td>
                                    <td>@if ($servicein->delivery_date!='')
                                        {{ \Carbon\Carbon::parse($servicein->delivery_date)->format('d/m/Y')}}

                                        @else
                                        N/A
                                    @endif</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>






                </div>
            </div>
        </div>
    </div>

--->



    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">

                @csrf
                <div class="card-body">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">Products</h6>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="pros">
                                <thead>
                                    <tr id="0">
                                        <th class="pt-0">#</th>
                                        <th class="pt-0">Product</th>
                                        <th class="pt-0">Qantity</th>
                                        {{-- <th class="pt-0">Price</th>
                                        <th class="pt-0">Gst</th>
                                        <th class="pt-0">Gross</th>
                                        <th class="pt-0">Total</th>
                                        <th class="pt-0">Comments</th>
                                        <th class="pt-0">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody id="addedproducts">

                                    @foreach ($servicein->particulars as $serv)
                                        <tr id="{{ $loop->index + 1 }}">
                                            <td>{{ $loop->index + 1 }}<input
                                                    style="width: 100%; border-top-style: hidden; border-right-style: hidden;border-left-style:hidden;border-bottom-style: hidden;"
                                                    type="hidden" value="{{ $serv->product_id }}" name="productids[]"
                                                    readonly></td>
                                            <td>{{ $serv->products->name }}</td>
                                            <td><input
                                                    style=" border-top-style: hidden; border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;"
                                                    name="quantity[]" value="{{ $serv->qty }}" readonly></td>
                                                    {{--  <td>{{ $serv->price }}</td>
                                            <td>{{ number_format((float) $serv->tax, 2, '.', '') }}</td>
                                            <td>{{ number_format((float) $serv->gross, 2, '.', '') }}</td>
                                            <td>{{ number_format((float) $serv->total, 2, '.', '') }}</td>
                                            <td><input type="text"
                                                    style=" border-top-style: hidden; border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;"
                                                    name="comments[]" value="{{ $serv->comments }}" readonly></td>
                                            <td><i class="fa fa-trash"
                                                        onclick="deleteproduct({{ $loop->index + 1 }})"></i></td> --}}
                                        </tr>
                                    @endforeach






                                </tbody>
                            </table>
                        </div>
                    </div>





                </div>

                {{-- </form> --}}
            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script>
        function addproduct() {
            var product_id = $('#productss').val();

            $.ajax({
                'url': "{{ url('getproduct') }}/" + product_id + "",
                'method': "GET",
                'contentType': 'application/json'
            }).done(function(data) {
                var productname = String(data.name);

                var price = data.price;
                // var gst = data.gst;
                var qty = $('#qty').val();
                var com = $('#comments').val();
                let gross = precise(price * qty);
                let gst = precise(data.gst * qty);
                let total = precise(gross + gst);
                var i = parseInt($('#pros tr:last').attr('id')) + 1;
                //    let i= $("#pros").find("tr").last().length + 1;





                document.getElementById("addedproducts").innerHTML +=
                    '<tr id="' + i +
                    '"><td><input style="width: 100%; border-top-style: hidden; border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;" type="text" value="' +
                    data
                    .id + '" name="productids[]" readonly></td><td>' + data.name +
                    '</td><td><input style=" border-top-style: hidden; border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;" name="quantity[]" value="' +
                    qty + '" readonly></td><td>' + price + '</td><td>' + gst +
                    '</td><td>' + gross + '</td><td>' + total +
                    '</td><td><input type="text" style=" border-top-style: hidden; border-right-style: hidden;border-left-style: hidden;border-bottom-style: hidden;" name="comments[]" value="' +
                    com +
                    '" readonly></td><td><a onclick="deleteproduct(' + i +
                    ')"><i class="fa fa-trash" ></i></a></td></tr>'
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
                taxtotal += $(this).children().eq(4).text() * 1;

                gross += $(this).children().eq(5).text() * 1;
                totaltotal += $(this).children().eq(6).text() * 1;
            });


            //  $("td#sum").text(sum_population);
            document.getElementById("grosstotal").innerHTML = precise(gross);
            document.getElementById("totaltotal").innerHTML = precise(totaltotal);

            document.getElementById("taxtotal").innerHTML = precise(taxtotal);
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
                taxtotal += $(this).children().eq(4).text() * 1;

                gross += $(this).children().eq(5).text() * 1;
                totaltotal += $(this).children().eq(6).text() * 1;
            });


            //  $("td#sum").text(sum_population);
            document.getElementById("grosstotal").innerHTML = precise(gross);
            document.getElementById("totaltotal").innerHTML = precise(totaltotal);
            document.getElementById("taxtotal").innerHTML = precise(taxtotal);
        }
        function precise(val) {
    return parseFloat(val.toFixed(2)); // for example
}
    </script>
@endsection