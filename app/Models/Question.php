<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'subject_id',
        'question_type',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'marks',
        'negative_marks',
        'explanation',
        'image_path',
        'status',
        'created_by',
    ];

    protected $casts = [
        'marks' => 'decimal:2',
        'negative_marks' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function getOptionsAttribute(): array
    {
        return [
            'a' => $this->option_a,
            'b' => $this->option_b,
            'c' => $this->option_c,
            'd' => $this->option_d,
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Question belongs to subject
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Question creator
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Exams using this question
     */
    public function exams(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class, 'exam_questions')
            ->withPivot(['id', 'sort_order', 'marks'])
            ->withTimestamps();
    }

    /**
     * Pivot rows
     */
    public function examQuestions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class);
    }

    /**
     * Answers submitted by students
     */
    public function studentAnswers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
