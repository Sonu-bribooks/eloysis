<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamQuestion extends Model
{
    protected $fillable = [
        'exam_id',
        'question_id',
        'sort_order',
        'marks',
    ];

    protected $casts = [
        'marks' => 'decimal:2',
    ];

    /**
     * Pivot belongs to exam
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Pivot belongs to question
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
