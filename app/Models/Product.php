<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    //This field is reverse of $fillable
    protected $guarded = [];
    
    public function category() {
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier','supplier_id');
    }

}
