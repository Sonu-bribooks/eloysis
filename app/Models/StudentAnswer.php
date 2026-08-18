<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAnswer extends Model
{
    protected $fillable = [
        'attempt_id',
        'exam_id',
        'student_id',
        'question_id',
        'selected_option',
        'is_correct',
        'marks_awarded',
        'answered_at',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'marks_awarded' => 'decimal:2',
        'answered_at' => 'datetime',
    ];

    /**
     * Answer belongs to attempt
     */
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class, 'attempt_id');
    }

    /**
     * Answer belongs to exam
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Answer belongs to student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Answer belongs to question
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
