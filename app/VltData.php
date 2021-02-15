<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class VltData extends Model
{

    // from backup table 
	protected $table = 'vlt_data_annamma';

    public $timestamps = false;

    protected $fillable=[ 
    	'vltdata',
    	'is_processed',
    	'is_login',
    	'header',
    	'imei',
    	'created_at',
    	'updated_at'
    ];

    public function selectTable($table)
    {
        $this->table = $table;
    }

}
