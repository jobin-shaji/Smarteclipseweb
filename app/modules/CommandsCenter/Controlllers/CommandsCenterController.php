<?php
namespace App\Modules\CommandsCenter\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\Ota\Models\OtaResponse;
use App\Http\Traits\MqttTrait;

class CommandsCenterController extends Controller
{
    /**
     * 
     * 
     *
     */
    use MqttTrait;
    /**
     *
     */
    public $topic;
    
    /**
     *
     *
     */
    public function __construct()
    {
        $this->topic    = 'cmd';
    }
    public function commandsCenterMainPage()
    {
        $imei_serial_no_list = (new Gps())->getImeiListOfUnReturnedDevices();
        return view('CommandsCenter::commands-center-main-page', [ 'imei_serial_no_list' => $imei_serial_no_list ]);
    }

    public function commandsCenterSubmission(Request $request)
    {
        $device_array_list  = $request->selected_gps_id;
        $command_array_list = $request->selected_command;
        $device_array       = explode(",",$device_array_list[0]);
        $command_array      = explode(",",$command_array_list[0]);
        foreach ($device_array as $each_device) 
        {
            foreach ($command_array as $each_command) 
            {
                $response   = (new OtaResponse())->saveCommandsToDevice($each_device,$each_command);
                if($response)
                {
                    $gps_details                    =   (new Gps())->getGpsDetails($each_device);
                    $is_command_write_to_device     =   (new OtaResponse())->writeCommandToDevice($gps_details->imei,$each_command);
                    if($is_command_write_to_device)
                    {
                        $this->topic                    =   $this->topic.'/'.$gps_details->imei;
                        $is_mqtt_publish                =   $this->mqttPublish($this->topic, $each_command);
                    }
                    else
                    {
                        $request->session()->flash('message', 'Try again');
                        $request->session()->flash('alert-class', 'alert-success');
                        return  redirect(route('commands-center'));
                    }
                }
                else
                {
                    $request->session()->flash('message', 'Try again');
                    $request->session()->flash('alert-class', 'alert-success');
                    return  redirect(route('commands-center'));
                }
            }
        }
        if ($is_mqtt_publish === true) 
        {
            $request->session()->flash('message', 'Command send successfully');
            $request->session()->flash('alert-class', 'alert-success');
            return  redirect(route('commands-center'));
        }
        else
        {
            $request->session()->flash('message', 'Try again');
            $request->session()->flash('alert-class', 'alert-success');
            return  redirect(route('commands-center'));
        }
    }
    
}
