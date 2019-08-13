<?php
namespace App\Modules\Student\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Student\Models\Student;
use App\Modules\School\Models\School;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class StudentController extends Controller {
   
    //student creation page
    public function create()
    {
        $schools=School::select('id','name')
                ->get();
       return view('Student::student-create',['schools'=>$schools]);
    }
    //upload student details to database table
    public function save(Request $request)
    {    
        $rules = $this->studentCreateRules();
        $this->validate($request, $rules);  
        $placeLatLng=$this->getPlaceLatLng($request->student_location); 
        if($placeLatLng==null){
              $request->session()->flash('message', 'Enter correct location'); 
              $request->session()->flash('alert-class', 'alert-danger'); 
              return redirect(route('student.create'));        
        }
        $location_lat=$placeLatLng['latitude'];
        $location_lng=$placeLatLng['longitude'];      
        $student = Student::create([ 
            'code' => $request->code,           
            'name' => $request->name,            
            'address' => $request->address,
            'mobile' => $request->mobile, 
            'latitude' => $location_lat,
            'longitude' => $location_lng,
            'school_id' => $request->school_id,       
        ]);
        $eid= encrypt($student->id);
        $request->session()->flash('message', 'New student created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('student'));        
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
            'address',
            'mobile',
            'school_id',
            'deleted_at')
            ->withTrashed()
            ->with('school:id,name')
            ->get();
            return DataTables::of($student)
            ->addIndexColumn()
            ->addColumn('action', function ($student) {
                 $b_url = \URL::to('/');
            if($student->deleted_at == null){ 
                return "
                <button onclick=delStudent(".$student->id.") class='btn btn-xs btn-danger' data-toggle='tooltip' title='Deactivate!'><i class='fas fa-trash'></i> Deactivate</button>
                <a href=".$b_url."/student/".Crypt::encrypt($student->id)."/edit class='btn btn-xs btn-primary' data-toggle='tooltip' title='edit!'><i class='fa fa-edit'></i> Edit </a>
                 <a href=".$b_url."/student/".Crypt::encrypt($student->id)."/details class='btn btn-xs btn-info' data-toggle='tooltip' title='view!'><i class='fas fa-eye'></i> View</a>
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
        $schools=School::select('id','name')
                ->get();       
        if($student == null)
        {
           return view('Student::404');
        }
        return view('Student::student-edit',['student' => $student,'schools' => $schools,'location' => $location]);
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
        $placeLatLng=$this->getPlaceLatLng($request->student_location);
        if($placeLatLng==null){
              $request->session()->flash('message', 'Enter correct location'); 
              $request->session()->flash('alert-class', 'alert-danger'); 
              return redirect(route('student.edit',$did));        
        }

        $location_lat=$placeLatLng['latitude'];
        $location_lng=$placeLatLng['longitude'];
        $student->latitude= $location_lat;
        $student->longitude=$location_lng;
        $student->code = $request->code;     
        $student->name = $request->name;
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
            'address' => 'required',
            'mobile' => 'required|string|min:10|max:10|unique:students',
            'student_location' => 'required',
            'school_id' => 'required',
            
        ];
        return  $rules;
    }
     //validation for student updation
    public function studentUpdateRules($student)
    {
        $rules = [
            'code' => 'required|unique:students,code,'.$student->id,
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required|string|min:10|max:10|unique:students,mobile,'.$student->id,
            'student_location' => 'required',
            'school_id' => 'required',
            
        ];
        return  $rules;
    }
}
