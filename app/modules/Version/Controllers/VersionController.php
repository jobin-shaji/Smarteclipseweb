<?php
namespace App\Modules\Version\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Version\Models\ApplicationVersion;
use DataTables;
class VersionController extends Controller {

    // version  list
    public function versionRuleList()
    {
    return view('Version::version-rule-list'); 
    }
    //version rule page
    public function createVersionType()
    {
        return view('Version::version-type-create');
    }

    // save version
    public function saveVersion(Request $request)
        {
           
                $rules = $this->versionRuleCreateRules();
                $this->validate($request, $rules);
                
                $version_rule = ApplicationVersion::create([
                    'name' => $request->name,
                    'android_version' => $request->android_version,
                    'ios_version' => $request->ios_version,
                    'description' => $request->description,
                    'android_version_code' => $request->android_version_code,
                    'android_version_priority' => $request->android_version_priority,
                    'ios_version_code' => $request->ios_version_code,
                    'ios_version_priority' => $request->ios_version_priority,

                   ]);

                $request->session()->flash('message', 'New  Version created successfully!'); 
                $request->session()->flash('alert-class', 'alert-success'); 
                return redirect(route('version.rule'));
        }
    
       // version  list table
    public function getVersionRuleList()
            {
                $version_rule = ApplicationVersion::select(
                            'id',
                            'name',
                            'android_version',
                            'ios_version',
                            'description',
                            'android_version_code'
                            ,
                            'android_version_priority',
                            'ios_version_code','ios_version_priority'
                        )
                            ->withTrashed()
                            ->get();

                return DataTables::of($version_rule)
                         ->addIndexColumn()
                         ->make();
            }
            // version rule create rules

    public function versionRuleCreateRules()
        {
            $rules = [
                'name' => 'required',
                'android_version' => 'required',
                'ios_version' => 'required',

                'description' => 'required',
                'android_version_code' => 'required',
                 'android_version_priority' =>'required',
                'ios_version_code' =>'required',
                'ios_version_priority' =>'required'
            ];
            return  $rules;
        }


}
