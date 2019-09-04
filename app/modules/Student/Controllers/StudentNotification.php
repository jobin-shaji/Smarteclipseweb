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

class StudentNotifiationController extends Controller {
   
    //student creation page
    public function create()
    {
        $client_id = \Auth::user()->client->id;
       
        $route_batches=RouteBatch::select('id','name')
                ->where('client_id',$client_id)
                ->get();
        $students=Student::select('id','name','code','route_batch_id')
                ->where('client_id',$client_id)
                ->get();



        return view('Student::student-notification-create',['route_batches'=>$route_batches,'students'=>$students]);
    }

  public function getStudentFromBatch(Request $request){
     $client_id = \Auth::user()->client->id;
     $students=Student::select('id','name','code','route_batch_id')
               ->where('client_id',$client_id)
               ->where('route_batch_id',$request->batch)
               ->get();
     $student_ids=[];
     foreach ($students as $student) {
       array_push($student_ids,$student->id);
      }

       
  }

    
}
