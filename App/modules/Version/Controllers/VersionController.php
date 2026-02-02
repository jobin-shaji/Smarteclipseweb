<?php
namespace App\Modules\Version\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Modules\Version\Models\ApplicationVersion;
use App\Modules\Version\Models\ServiceEngineerApplication;
use DataTables;
class VersionController extends Controller {

    // version  list
    public function versionRuleList()
    {
    return view('Version::version-rule-list'); 
    }
    public function servicerversionRuleList()
    {
    return view('Version::servicer-version-list'); 
    }
    //version rule page
    public function createVersionType()
    {
        return view('Version::version-type-create');
    }

    public function servicercreateVersionType()
    {
        return view('Version::servicer-version-type-create');
    }

    // save version
    public function saveVersion(Request $request)
        {
           
                $rules          =   $this->versionRuleCreateRules();
                $this->validate($request, $rules);
                
                $version_rule   =   ApplicationVersion::create([
                    'name'                      => $request->name,
                    'android_version'           => $request->android_version,
                    'ios_version'               => $request->ios_version,
                    'description'               => $request->description,
                    'android_version_code'      => $request->android_version_code,
                    'android_version_priority'  => $request->android_version_priority,
                    'ios_version_code'          => $request->ios_version_code,
                    'ios_version_priority'      => $request->ios_version_priority,

                   ]);

                $request->session()->flash('message', 'New  Version created successfully!'); 
                $request->session()->flash('alert-class', 'alert-success'); 
                return redirect(route('version.rule'));
        }
    public function servicersaveVersion(Request $request)
    {
        $custom_messages = [
            'file.required' => 'file cannot be blank',
        ];
        $rules              =   $this->serviceversionRuleCreateRules();
        $this->validate($request, $rules,$custom_messages);
        $file               =   $request->file;
       // dd($file->getClientMimeType());
        //Move Uploaded File
        $destinationPath    =   'service_engineer_application';
        $getFileExt         =   $file->getClientOriginalExtension();
        $uploadedFile       =   'service_engineer'.time().'.'.$getFileExt;
        $file->move($destinationPath,$uploadedFile);
        $current_base_url   =   url('/');
        $version_rule       =   ServiceEngineerApplication::create([
            'name'          =>  $request->name,
            'version'       =>  $request->version,
            'description'   =>  $request->description,
            'priority'      =>  $request->priority,
            'file'          =>  $current_base_url.'/service_engineer_application/'.$uploadedFile,
        ]);
        $request->session()->flash('message', 'New Servicer Version created successfully!'); 
        $request->session()->flash('alert-class', 'alert-success'); 
        return redirect(route('servicer-version.rule'));
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
    public function getServiceVersionList()
    {
        $service_version = ServiceEngineerApplication::select(
                'id',
                'name',
                'version',
                'description',
                'priority',
                'file'
            )
            ->withTrashed()
            ->get();

        return DataTables::of($service_version)
            ->addIndexColumn()
            ->make();
    }
    public function versionRuleCreateRules()
        {
            $rules = [
                'name'                          =>  'required',
                'android_version'               =>  'required',
                'ios_version'                   =>  'required',
                'description'                   =>  'required',
                'android_version_code'          =>  'required',
                 'android_version_priority'     =>  'required',
                'ios_version_code'              =>  'required',
                'ios_version_priority'          =>  'required'
            ];
            return  $rules;
        }
    public function serviceversionRuleCreateRules()
    {
        $rules = [
            'name'          =>  'required',
            'version'       =>  'required|numeric',
            'description'   =>  'required',
            'priority'      =>  'required|numeric',
            'file'          =>  'required|mimes:apk,zip'
        ];
        return  $rules;
    }

}