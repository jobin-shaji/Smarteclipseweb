
            <table class="tblUserVehicles">
              <tbody>
                <tr style="background-color: #ddd;cursor:default;">
                  <th><!--<i class="fa fa-refresh i.fa.fa-refresh refIcon" onclick="GetDashVehiclesView()" aria-hidden="true" style="color: blue;"></i>--></th>
                  <th>Username</th>
                  <th>mobile</th>
                  <th>email</th>
                </tr>

                @foreach ($users as $user)
                  <tr >
                    <td><i class="fa fa-user i.fa.fa-user" aria-hidden="true" style="font-size: 1.2em!important;"></i></td>
                    <td style="text-align:left;padding-left:6px;font-size:small;">{{$user->username}}</td>
                    <td style="text-align:left;padding-left:6px;font-size:small;">{{$user->mobile}}</td>
                    <td style="text-align:left;padding-left:6px;font-size:small;">{{$user->email}}</td>
                    
                    
                    
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
            