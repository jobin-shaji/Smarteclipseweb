@extends('layouts.eclipse') 
@section('title')
   GPS Transfer
@endsection
@section('content')

     

<div class="page-wrapper page-wrapper-root">
<div class="page-wrapper-root1"> 
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-md-6 d-flex no-block align-items-center">
        <h4 class="page-title">GPS Transfer</h4>
        @if(Session::has('message'))
        <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
        </div>
        @endif  
        </div>
      </div>
    </div>
 
        <div class="card-body">
          <section class="hilite-content">
       
<form  method="POST" action="{{route('gps-transfer.create.p')}}">
        {{csrf_field()}}
      <div class="row">
        <div class="col-md-12">
          <div class="form-group has-feedback">
              <label class="srequired">To User</label>
              <select class="form-control selectpicker" id="to_user" name="to_user_id" data-live-search="true" title="Select Dealer" required>
                @foreach($entities as $entity)
                <option value="{{$entity->user->id}}">{{$entity->name}}</option>
                @endforeach
              </select>
              <span class="glyphicon glyphicon-car form-control-feedback"></span>
          </div>     
          @if ($errors->has('to_user'))
            <span class="help-block">
                <strong class="error-text">{{ $errors->first('to_user') }}</strong>
            </span>
          @endif 
        </div>
      </div>

      <div class="form-group has-feedback">
        <label class="srequired">GPS</label>
        <div class="row">

               @forelse  ($devices as $device )
                <div class="col-md-6">
                    <input type="checkbox" name="gps_id[]" value="{{$device->id}}">{{$device->name}}||{{$device->imei}}
                </div>
              @empty
                @section('script')
                  <script>alert("No GPS Found");</script>
                @endsection
                <p style="font-size: 20px;padding-left: 15px;color: red;"><b>No GPS Found</b></p>
              @endforelse

        </div>
        <div class="row">
        <!-- /.col -->
        <div class="col-md-3 ">
          <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
        </div>
        <!-- /.col -->
      </div>
      </div>     
      @if ($errors->has('gps_id'))
        <span class="help-block">
            <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
        </span>
      @endif 

    </form>
</section>
 
</div>
</div>
</div>

<div class="clearfix"></div>

@section('script')
    <script src="{{asset('js/gps/gps-transfer.js')}}"></script>
@endsection
   
@endsection