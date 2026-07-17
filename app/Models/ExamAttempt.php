<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamAttempt extends Model
{
    protected $fillable = [
        'exam_id',
        'student_id',
        'started_at',
        'submitted_at',
        'expires_at',
        'status',
        'total_questions',
        'attempted_questions',
        'correct_answers',
        'wrong_answers',
        'skipped_answers',
        'score',
        'percentage',
        'result_published_at',
    ];

    protected $casts = [
        'started_at'          => 'datetime',
        'submitted_at'        => 'datetime',
        'expires_at'          => 'datetime',
        'result_published_at' => 'datetime',
        'score'               => 'decimal:2',
        'percentage'          => 'decimal:2',
    ];

    /**
     * Attempt belongs to exam
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Attempt belongs to student user
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Attempt has many answers
     */
    public function answers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class, 'attempt_id');
    }
}
