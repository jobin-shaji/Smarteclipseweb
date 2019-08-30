<?php
namespace App\Modules\Student\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Student\Models\Student;
use App\Modules\RouteBatch\Models\RouteBatch;
use App\Modules\School\Models\School;
use App\Modules\ClassDivision\Models\ClassDivision;
use App\Modules\SchoolClass\Models\SchoolClass;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class StudentController extends Controller {
   
    //student creation page
    public function create()
    {
        $client_id = \Auth::user()->client->id;
        $classes=SchoolClass::select('id','name')
                ->where('client_id',$client_id)
                ->get();
        $route_batches=RouteBatch::select('id','name')
                ->where('client_id',$client_id)
                ->get();
        $random_password=$this->randomPassword();
        return view('Student::student-create',['classes'=>$classes,'random_password'=>$random_password,'route_batches'=>$route_batches]);
    }

    //get division in dependent dropdown
    public function getClassDivisionList(Request $request)
    {
        $classID=$request->classID;
        $division = ClassDivision::select(
                'id',
                'name'
                )
                ->where("class_id",$classID)
                ->get();
        return response()->json($division);
    }

    //upload student details to database table
    public function save(Request $request)
    {
        $client_id = \Auth::user()->client->id;    
        $rules = $this->studentCreateRules();
        $this->validate($request, $rules);  
        $location_lat=$request->latitude;
        $location_lng=$request->longitude;  
        if($location_lat==null){
            $placeLatLng=$this->getPlaceLatLng($request->student_location); 
            if($placeLatLng==null){
                  $request->session()->flash('message', 'Enter correct location'); 
                  $request->session()->flash('alert-class', 'alert-danger'); 
                  return redirect(route('student.create'));        
            }
            $location_lat=$placeLatLng['latitude'];
            $location_lng=$placeLatLng['longitude'];  
        }
            
        $student = Student::create([ 
            'code' => $request->code,           
            'name' => $request->name,  
            'gender' => $request->gender,  
            'class_id' => $request->class_id, 
            'division_id' => $request->division_id,       
            'parent_name' => $request->parent_name,       
            'address' => $request->address,
            'mobile' => $request->mobile, 
            'email' => $request->email,
            'route_batch_id' => $request->route_batch_id,
            'nfc' => $request->nfc,
            'latitude' => $location_lat,
            'longitude' => $location_lng,
            'password' => bcrypt($request->password),
            'client_id' => $client_id,       
        ]);
        $eid= encrypt($student->id);
        $request->session()->flash('message', 'New student created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('student'));        
    }

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    //Student list
    public function studentList()
    {
        return view('Student::student-list');
    }

    public function getStudentlist(Request $request)
    {
        $student = Student::select(
            'id', 
            'code',
            'name',  
            'gender',                  
            'class_id', 
            'division_id', 
            'parent_name', 
            'email', 
            'route_batch_id', 
            'nfc', 
            'address',
            'mobile',
            'client_id',
            'deleted_at')
            ->withTrashed()
            ->with('class:id,name')
            ->with('division:id,name')
            ->with('routeBatch:id,name')
            ->get();
            return DataTables::of($student)
            ->addIndexColumn()
            ->addColumn('gender', function ($student) {
                $gender=$student->gender;
                if($gender==1){
                    return "Male";
                }else if($gender==2){
                    return "Female";
                }else{
                    return "Other";
                }
            })
            ->addColumn('class', function ($student) {
                $class=$student->class->name;
                $division=$student->division->name;
                $class_division=$class.' '.$division;
                return $class_division;
            })
            ->addColumn('action', function ($student) {
                 $b_url = \URL::to('/');
            if($student->deleted_at == null){ 
                return "
                <a href=".$b_url."/student/".Crypt::encrypt($student->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='view!'> View</a>
                <a href=".$b_url."/student/".Crypt::encrypt($student->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'> Edit </a>
                <button onclick=delStudent(".$student->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'> Deactivate</button>
                
                ";
            }else{                   
                return "
                <button onclick=activateStudent(".$student->id.") class='btn btn-xs btn-success' data-toggle='tooltip' title='Ativate!'><i class='fas fa-check'></i> Ativate</button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }

    //EDIT STUDENT DETAILS
    public function edit(Request $request)
    {
        $decrypted = Crypt::decrypt($request->id); 
        $student = Student::find($decrypted);
        $latitude= $student->latitude;
        $longitude=$student->longitude;          
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
            $output = json_decode($geocodeFromLatLong);         
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //Return address of the given latitude and longitude            
            $location=$address;
        }
        else
        {
              $location="";
        }
        $client_id = \Auth::user()->client->id;
        $classes=SchoolClass::select('id','name')
                ->where('client_id',$client_id)
                ->get();
        $route_batches=RouteBatch::select('id','name')
                ->where('client_id',$client_id)
                ->get();      
        if($student == null)
        {
           return view('Student::404');
        }
        return view('Student::student-edit',['student' => $student,'location' => $location,'route_batches' => $route_batches,'classes' => $classes]);
    }

    //update Student details
    public function update(Request $request)
    {
        $student = Student::where('id', $request->id)->first();
        $did = encrypt($student->id);
        if($student == null){
           return view('Student::404');
        } 
        $rules = $this->studentUpdateRules($student);
        $this->validate($request, $rules);  
        $location_lat=$request->latitude;
        $location_lng=$request->longitude;  
        if($location_lat==null){
            $placeLatLng=$this->getPlaceLatLng($request->student_location); 
            if($placeLatLng==null){
                  $request->session()->flash('message', 'Enter correct location'); 
                  $request->session()->flash('alert-class', 'alert-danger'); 
                  return redirect(route('student.edit',$did));        
            }
            $location_lat=$placeLatLng['latitude'];
            $location_lng=$placeLatLng['longitude'];  
        }

        $student->latitude= $location_lat;
        $student->longitude=$location_lng;
        $student->code = $request->code;     
        $student->name = $request->name;
        $student->class_id = $request->class_id;
        $student->division_id = $request->division_id;
        $student->parent_name = $request->parent_name;
        $student->email = $request->email;
        $student->route_batch_id = $request->route_batch_id;
        $student->nfc = $request->nfc;
        $student->address = $request->address;
        $student->mobile = $request->mobile;
        $student->save();      
        $did = encrypt($student->id);
        $request->session()->flash('message', 'Student details updated successfully!');
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('student.edit',$did));  
    }

    
    // details page
    public function details(Request $request)
    {
        $decrypted_id = Crypt::decrypt($request->id);
        $student=Student::find($decrypted_id);
        $latitude= $student->latitude;
        $longitude=$student->longitude;          
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
            $output = json_decode($geocodeFromLatLong);         
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //Return address of the given latitude and longitude            
            $location=$address;
        }
        else
        {
              $location="";
        }
        if($student==null){
            return view('Student::404');
        } 
        return view('Student::student-details',['student' => $student,'location' => $location]);
    }

  
    //deactivated Student details from table
    public function deleteStudent(Request $request)
    {
        $student = Student::find($request->id);
        if($student == null){
            return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'student does not exist'
            ]);
        }
        $student->delete();
        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'student deleted successfully'
        ]);
    }


    // restore Student
    public function activateStudent(Request $request)
    {
        $student = Student::withTrashed()->find($request->id);
        if($student==null){
             return response()->json([
                'status' => 0,
                'title' => 'Error',
                'message' => 'student does not exist'
             ]);
        }

        $student->restore();

        return response()->json([
            'status' => 1,
            'title' => 'Success',
            'message' => 'Student restored successfully'
        ]);
    }

/////////////////////////////PLACE NAME/////////////////////////////////////////
    function getPlaceLatLng($address){

        $data = urlencode($address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $data . "&sensor=false&key=AIzaSyCOae8mIIP0hzHTgFDnnp5mQTw-SkygJbQ";
        $geocode_stats = file_get_contents($url);
        $output_deals = json_decode($geocode_stats);
        if ($output_deals->status != "OK") {
            return null;
        }
        if ($output_deals) {
            $latLng = $output_deals->results[0]->geometry->location;
            $lat = $latLng->lat;
            $lng = $latLng->lng;
            $locationData = ["latitude" => $lat, "longitude" => $lng];
            return $locationData;
        } else {
            return null;
        }
    }

//////////////////////////////////////////////////////////////////////////////////

    public function studentCreateRules()
    {
        $rules = [
            'code' => 'required|unique:students',
            'name' => 'required',
            'gender' => 'required',
            'class_id' => 'required',
            'division_id' => 'required',
            'parent_name' => 'required',
            'email' => 'required|string|email|max:255|unique:students',
            'route_batch_id' => 'required',
            'nfc' => 'required|unique:students',
            'address' => 'required',
            'password' => 'required',
            'mobile' => 'required|string|min:10|max:10|unique:students',
            'student_location' => 'required'
            
        ];
        return  $rules;
    }
     //validation for student updation
    public function studentUpdateRules($student)
    {
        $rules = [
            'code' => 'required|unique:students,code,'.$student->id,
            'name' => 'required',
            'class_id' => 'required',
            'division_id' => 'required',
            'parent_name' => 'required',
            'email' => 'required|string|email|max:255|unique:students,email,'.$student->id,
            'route_batch_id' => 'required',
            'nfc' => 'required|unique:students,nfc,'.$student->id,
            'address' => 'required',
            'mobile' => 'required|string|min:10|max:10|unique:students,mobile,'.$student->id,
            'student_location' => 'required',
            
        ];
        return  $rules;
    }
}
