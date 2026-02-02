@extends('layouts.etm')
@section('title')
  {{$state->name}} State
@endsection

@section('content')

    <section class="content-header">
        <h1>{{$state->name}} State</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  


<section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-user-plus"></i> Add User
          </h2>
          <form action="{{route('root.user.create',$state->id)}}" method="post">
              @csrf
            <div class="col-md-6">
              <div class="form-group has-feedback">
                <label>User name</label>
                <input type="" name="username" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" value="{{old('username')}}">
              </div>
              @if ($errors->has('username'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('username') }}</strong>
                </span>
              @endif
              <div class="form-group">
                <label>Password</label>
                <input type="" name="password" class="form-control {{ $errors->has('password') ? ' has-error' : '' }}" value="{{old('password')}}">
              </div>
              @if ($errors->has('password'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Email</label>
               <input type="" name="email" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" value="{{old('email')}}">
              </div>
              @if ($errors->has('email'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('email') }}</strong>
                </span>
              @endif
              <div class="form-group">
                <label>Mobile</label>
                <input type="" name="mobile" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" value="{{old('mobile')}}">
              </div>
              @if ($errors->has('mobile'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                </span>
              @endif
            </div>
            <button class="btn btn-success pull-right"><i class="fa fa-user-plus"></i> Create New User</button>
          </form>
        </div>
        <!-- /.col -->
      </div>
</section>

<section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-users"></i> Users
          </h2>

          <div class="table-responsive">          
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>username</th>
                  <th>email</th>
                  <th>mobile</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$user->username}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->mobile}}</td>
                  <td><?php if($user->status){echo "Active";}else{echo "InActive";}?></td>
                  <td><button class="btn btn-sm btn-info">Edit</button> <button class="btn btn-sm btn-danger">Delete</button></th>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
        </div>
        <!-- /.col -->
      </div>
</section>

<section class="hilite-content">
    <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-building"></i> Depots
          </h2>

          <div class="table-responsive">          
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Code</th>
                  <th>district</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($state->depots->sortBy('district_id') as $depot)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$depot->name}}</td>
                  <td>{{$depot->code}}</td>
                  <td>{{$depot->districtData->name}}</td>
                  <td><button class="btn btn-sm btn-info">Edit</button> <button class="btn btn-sm btn-danger">Delete</button></td>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
        </div>
        <!-- /.col -->
      </div>
</section>
 
<div class="clearfix"></div>


@endsection