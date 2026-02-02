<?php

namespace App\Modules\Servicer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
  
    protected $table='cd_components';
    protected $fillable=['image_url','sub_units','min_quantity','box_no','assets_id','customer_order','product_id','store_id','invoice_name','name','description','price','gst','status','gst_percent','total','tax_type','stocks','units'];

    public function products()
    {
      return $this->belongsTo('App\Modules\Servicer\Models\Product','product_id','id');
    }

    public function stores()
      {
        return $this->belongsTo('App\Modules\Servicer\Models\ServiceStore','store_id','id');
      }

}
