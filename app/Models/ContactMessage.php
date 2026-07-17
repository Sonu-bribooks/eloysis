<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [

        'name',

        'email',

        'phone',

        'subject',

        'message',

        'status',

        'ip_address',

        'user_agent',

    ];

     protected $casts = [

        'created_at'=>'datetime',

        'updated_at'=>'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status','pending');
    }

    public function scopeRead($query)
    {
        return $query->where('status','read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status','replied');
    }
}
