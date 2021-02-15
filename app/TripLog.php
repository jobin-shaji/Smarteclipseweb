<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use \DB;

class TripLog extends Model
{

	 // from backup table 
	protected $table = 'trip_logs';

	public $timestamps = false;

	
    protected $fillable=[ 'lat','lng','ignition','mode','device_time','speed'];

    public function createTable($imei)
    {
    	$table = "trip-".$imei."-".mt_rand();

    	DB::select("create table `$table` like trip_logs");

    	$this->table = $table;

    	echo "created table $this->table for trips creation "."\n";

    }

    public function dropTable()
    {
    	echo "dropping table $this->table"."\n";
    	$table = $this->table;
    	DB::select("drop table `$table`");
    	echo "table dropped successfully"."\n";
    }

}
