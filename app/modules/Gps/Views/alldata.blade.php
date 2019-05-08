@extends('layouts.app')

@section('content')

<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="table-responsive">
                <div class="panel-body">
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>data</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($items as $item)
                          <tr>
                            <td>{{$loop->iteration}}</td>
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