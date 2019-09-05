<?php
namespace App\Modules\Student\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Student\Models\Student;
use App\Modules\Student\Models\StudentNotification;
use App\Modules\RouteBatch\Models\RouteBatch;
use App\Modules\School\Models\School;
use App\Modules\ClassDivision\Models\ClassDivision;
use App\Modules\SchoolClass\Models\SchoolClass;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class StudentNotifiationController extends Controller {
    //student creation page
    public function create() {
        $client_id = \Auth::user()->client->id;
        $route_batches = RouteBatch::select('id', 'name')
                        ->where('client_id', $client_id)
                        ->get();
        $students = Student::select('id', 'name', 'code', 'route_batch_id')
                    ->where('client_id', $client_id)
                    ->get();
        return view('Student::student-notification-create', ['route_batches' => $route_batches, 'students' => $students]);
    }
    public function getStudentFromBatch(Request $request) {
        $client_id = \Auth::user()->client->id;
        $students = Student::select('id', 'name', 'code', 'route_batch_id')
                    ->where('client_id', $client_id)
                    ->where('route_batch_id', $request->batch)
                    ->get();
        $student_ids = [];
        foreach ($students as $student) {
            array_push($student_ids, $student->id);
        }
        $data = ["studets" => $student_ids];
        return response()->json($data);
    }

    public function sendMessageToUser(Request $request){
        $student_ids=$request->student_id;
        $client_id = \Auth::user()->client->id;
        foreach ( $student_ids as $student_id) {
          $message=$request->message;
          $student=Student::find($student_id);
          $parent_name=$student->parent_name;
          $Student_name=$student->name;
          $parent_phone=$student->mobile;
          $message=str_replace('[student]',$Student_name,$message);
          $message=str_replace('[parent]',$parent_name,$message);
          $message_data_og=$message;
          $message_data=urlencode($message);

          $send_notification=$this->sendNotification($parent_phone,$message_data);
            $alert_type = StudentNotification::create([
            'mobile' =>$parent_phone,
            'message' =>$message_data_og,  
            'client_id'=>$client_id,  
            'type' => 1,        
            'date' => date('Y-m-d H:i:s'),               
          ]);
        }
        $request->session()->flash('message', 'Student message  successfully sent!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('student-notification')); 



    }
    public function getNotification(){
       return view('Student::student-notification-list');
    }

    public function getNotificationList(){
          $notification = StudentNotification::select(
                'id',
                'mobile',
                'message',
                'date')->get();
         return DataTables::of($notification)
               ->addIndexColumn()
               ->make();
    }

   // send message
    public function sendNotification($phone,$message){
        $text = $message;
        $curl = curl_init();
        // Send the POST request with cURL
        curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => "http://reseller.smschub.com/api/sms/format/json", CURLOPT_POST => 1, CURLOPT_CUSTOMREQUEST => 'POST', CURLOPT_HTTPHEADER => array('X-Authentication-Key:358afcb5cd344aa01d10eddb9f0345e0', 'X-Api-Method:MT'), CURLOPT_POSTFIELDS => array('mobile' => $phone, 'route' => 'TL', 'text' => $text, 'sender' => 'GPSVST')));
           // Send the request & save response to $response
        $response = curl_exec($curl);
         // Close request to clear up some resources
        curl_close($curl);
    }


}
