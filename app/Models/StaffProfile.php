<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffProfile extends Model
{
    use SoftDeletes;
    
    protected $fillable = [

        'user_id',
        'employee_id',
        'designation',
        'department',
        'joining_date',
         'dob',
        'gender',
        'address','city', 'state', 'pincode'

    ];


    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

}
