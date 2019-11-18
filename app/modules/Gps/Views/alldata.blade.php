@extends('layouts.app')

@section('content')



<section class="content">
  <div>
        <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-default">
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped " style="width:100%;">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>IMEI</th>
                              <th>size</th>
                              <th>date</th>
                              <th>data</th>
                      
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($items as $item)
                          <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->imei}}</td>
                            <td>{{strlen($item->vlt_data)}}</td>
                            <td>{{$item->created_at->diffForHumans()}} , {{$item->created_at}}</td>
                            <td>{{$item->vlt_data}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>
@endsection