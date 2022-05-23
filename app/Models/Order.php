<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    //This field is reverse of $fillable
    protected $guarded = [];

    public function customer() {
        return $this->belongsTo('App\Models\Customer','customer_id');
    }

    
}
