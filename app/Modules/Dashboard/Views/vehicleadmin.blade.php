
            <table class="tblUserVehicles">
              <tbody>
                <tr style="background-color: #ddd;cursor:default;">
                  <th><!--<i class="fa fa-refresh i.fa.fa-refresh refIcon" onclick="GetDashVehiclesView()" aria-hidden="true" style="color: blue;"></i>--></th>
                  <th>Reg.No.</th>
                  <th>IMEI</th>
                  <th title="Speed">Sp.</th>
                  <th style="text-align:left;">Owner</th>
                  @if($mode=='dash')
                  <th>Last data</th>
                  <th>Since</th>
                  
                  @endif
                </tr>

                @foreach ($vehicles as $vehicle)
                <?php
                $now = time();
                $updatedTime = strtotime($vehicle->updated_at);
                $elapsedSeconds = $now - $updatedTime;

                $hours = floor($elapsedSeconds / 3600);
                $minutes = floor(($elapsedSeconds % 3600) / 60);
                $seconds = $elapsedSeconds % 60;
                $timeFormat = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

                $lat = (float)$vehicle->lat;
                if ($lat < 1000) {
                  if ($elapsedSeconds <= 300) {
                    $iconColor = 'blue'; // Change color to green if less than or equal to 5 seconds
                  } else if ($elapsedSeconds <= 1800) {
                    $iconColor = 'orange'; // Change color to orange if less than or equal to 10 seconds
                  } else {
                    $iconColor = 'red'; // Change color to red for more than 10 seconds
                  }
                } else {
                  $iconColor = '#ddd';
                }
                $speed = (int)$vehicle->speed;
                ?>


                <tr title="{{$vehicle->lat}}" onclick="OnVehicleClicked('{{$vehicle->imei}}')">
                  <td><i class="fa fa-globe i.fa.fa-globe" aria-hidden="true" style="font-size: 1.2em!important;color:<?php echo $iconColor; ?>"></i></td>
                  <td style="text-align:left;padding-left:6px;font-size:small;">{{$vehicle->register_number}}</td>
                  <td><i style="font-size:small;">{{$vehicle->imei}}</i></td>
                  <td style="text-align: right;padding-right:1em;">{{$elapsedSeconds<300?$speed:""}}</td>
                  <td style="text-align: left;padding-right:1em;" title="{{$vehicle->client_id}}">{{$vehicle->username}}</td>
                  @if($mode=='dash')
                  <td><i style="font-size:small;color:<?php echo $iconColor; ?>">{{$vehicle->updated_at}}</i></td>
                  <td><i style="font-size:small;color:<?php echo $iconColor; ?>">{{$timeFormat}}</i></td>
                  
                  @endif
                </tr>
                @endforeach
                @if($mode=='dash')
                <tr style="background-color: #ddd;cursor:default;">
                  <th colspan=10 style="font-style: italic;color:#999;font-weight:normal;text-align:left;padding-left:1em;margin-top:5px;font-size:small;">
                    
                  <div style="display:block;float:left; margin-left:0em;font-size:small;margin-top:5px;">User id  {{ auth()->id() }}</div>
                  <div style="display:block;float:left; margin-left:1em;font-size:small;margin-top:5px;">Last updated at {{ now()->format('Y-m-d H:i:s') }}</div>
                    

                    <i class="fa fa-plus-square-o i.fa.fa-plus-square-o" onclick="ShowAddNewPanel()" aria-hidden="true" 
                    style="float: right;color:red;font-size:1.5em;margin-top:3px;margin-right:0.4em;display:block;cursor:pointer;"></i>
                    <div style="float: right;margin-right:0.8em;font-size:small;margin-top:5px;">Add Vehicle</div>



                    @if(auth()->id()==806063)
                    <i class="fa fa-user-plus i.fa.fa-user-plus" onclick="ShowManageUserPanel()" aria-hidden="true" 
                    style="float: right;color:darkgreen;font-size:1.5em;margin-top:3px;margin-right:0.4em;display:block;cursor:pointer;"></i>
                    <div style="float: right;margin-right:0.8em;font-size:small;margin-top:5px;">Manage User</div>
                    @endif
                  </th>
                  @endif
                </tr>
              </tbody>
            </table>
          