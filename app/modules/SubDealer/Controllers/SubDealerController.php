<?php

namespace App\Modules\SubDealer\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\SubDealer\Models\Dealer;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class SubDealerController extends Controller {
    //Display employee details 
    public function subdealerListPage()
    {
        return view('SubDealer::dealer-list');
    }
    //returns employees as json 
    public function getDealers()
    {
        $dealers = Dealer::select(
                    'id',
                    
                    'name',                   
                    'address',                    
                    'phone_number',
                    'username',
                    'deleted_at',
                    'password')
                    ->withTrashed()
                   ->get();
        return DataTables::of($dealers)
            ->addIndexColumn()
            ->addColumn('action', function ($dealers) {
                if($dealers->deleted_at == null){ 
                
                    return "
                     <a href=/dealers/".Crypt::encrypt($dealers->id)."/change-password class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Change Password </a>
                     <a href=/dealers/".Crypt::encrypt($dealers->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <a href=/dealers/".Crypt::encrypt($dealers->id)."/edit class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                   
                    <button onclick=delDealers(".$dealers->id.") class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-remove'></i> Deactivate </button>";
                 }else{ 
                  
                    return "
                  
                    <a href=/dealers/".Crypt::encrypt($dealers->id)."/details class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                    <button onclick=activateDealer(".$dealers->id.") class='btn btn-xs btn-success'><i class='glyphicon glyphicon-remove'></i> Activate </button>";
                }
            })
            ->rawColumns(['link', 'action'])
            ->make();
    }



}
