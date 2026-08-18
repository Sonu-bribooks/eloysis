<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicSession extends Model
{
    use SoftDeletes;

    protected $table = 'academic_sessions';

    protected $fillable = [
        'name',
        'start_year',
        'end_year',
        'start_date',
        'end_date',
        'is_current',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
        'is_current' => 'boolean',
    ];

    /**
     * Role has many users
     */
    public function studentEnroll(): HasMany
    {
        return $this->hasMany(StudentEnrollment::class);
    }
}
