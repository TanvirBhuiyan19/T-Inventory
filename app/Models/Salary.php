<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    
    //This field is reverse of $fillable
    protected $guarded = [];

    public function employee() {
        return $this->belongsTo('App\Models\Employee','employee_id');
    }


}
