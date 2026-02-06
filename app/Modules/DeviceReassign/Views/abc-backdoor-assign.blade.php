@extends('layouts.eclipse')
@section('title')
Backdoor Assign Device
@endsection
@section('content')
<section class="hilite-content">
  <div class="page-wrapper_new mrg-top-50">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Backdoor Assign</li>
        <b>Backdoor Assign Device</b>
      </ol>
      @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }} 
        </div>
      </div>
      @endif 
    </nav>
    <div class="card-body">
      <form method="post" action="{{ route('devicereassign.backdoor.assign') }}">
        {{ csrf_field() }}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="srequired">Select GPS (IMEI)</label>
              <select name="gps_id" class="form-control select2" required>
                <option value="">-- Select GPS --</option>
                @foreach($gpsList as $g)
                  <option value="{{ $g->id }}">{{ $g->imei }} @if($g->serial_no) ({{ $g->serial_no }}) @endif</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Client (optional)</label>
              <select name="client_id" class="form-control select2">
                <option value="">-- No change --</option>
                @foreach($clients as $c)
                  <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <hr>
        <div class="row">
          <div class="col-md-6">
            <label>Attach to existing Vehicle (optional)</label>
            <select name="vehicle_id" class="form-control select2">
              <option value="">-- Use new vehicle below or skip --</option>
              @foreach($vehicles as $v)
                <option value="{{ $v->id }}">{{ $v->register_number }} @if($v->name) - {{ $v->name }} @endif</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label>Or create new Vehicle (optional)</label>
            <input type="text" name="vehicle_name" class="form-control" placeholder="Vehicle name">
            <input type="text" name="register_number" class="form-control mrg-top-10" placeholder="Register/plate number">
          </div>
        </div>

        <div class="row mrg-top-20">
          <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Assign Device</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
@section('script')
<script>$('.select2').select2();</script>
@endsection
@endsection
