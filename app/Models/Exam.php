<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = [
        'class_id',
        'subject_id',
        'title',
        'description',
        'instructions',
        'duration_minutes',
        'total_marks',
        'passing_marks',
        'total_questions',
        'start_at',
        'end_at',
        'max_attempts',
        'negative_marking',
        'negative_marks_per_wrong',
        'shuffle_questions',
        'shuffle_options',
        'show_result_immediately',
        'status',
        'created_by',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'negative_marking' => 'boolean',
        'shuffle_questions' => 'boolean',
        'shuffle_options' => 'boolean',
        'show_result_immediately' => 'boolean',
        'total_marks' => 'decimal:2',
        'passing_marks' => 'decimal:2',
        'negative_marks_per_wrong' => 'decimal:2',
    ];

    /**
     * Exam belongs to class
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Exam belongs to subject
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Exam creator admin/teacher
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Pivot rows
     */
    public function examQuestions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class);
    }

    /**
     * Questions attached to this exam
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'exam_questions')
            ->withPivot(['id', 'sort_order', 'marks'])
            ->withTimestamps();
    }

    /**
     * Student attempts
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }

    /**
     * Student answers
     */
    public function studentAnswers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeActiveNow($query)
    {
        return $query
            ->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('start_at')
                    ->orWhere('start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_at')
                    ->orWhere('end_at', '>=', now());
            });
    }
}
