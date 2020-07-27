@component('mail::message')

Hello,
 
Attaching below the list of devices in which the plan is goining to expire in {{$nextMonth}} {{$year}}. Totally, there will be {{$role_count_total}} devices and the details are appending below.

<table style="margin-bottom:10px">
    <tr style="text-align:left">
        <th>Plan</th>
        <th>No of vehicles</th>
    </tr>
    @foreach(config('eclipse.PLANS') as $each_plan)
    <tr>
        <td>{{ucfirst(strtolower($each_plan['NAME']))}} </td>
        <td style="text-align:center;"> <?php (isset($role_count[$each_plan['ID']])) ? $plan = $role_count[$each_plan['ID']]['count']: $plan = 0;?>{{ $plan}}</td>
    </tr>   
    @endforeach
    <tr>
        <td>Total</td>
        <td style="text-align:center;"><?php ($role_count_total)? $total=$role_count_total:$total=0?>{{$total}}</td>
    </tr>
</table>

<br>
Regards,<br>
Team {{ ucwords(strtolower(config('app.name'))) }}
@endcomponent
