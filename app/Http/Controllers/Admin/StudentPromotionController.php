<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StudentPromotionRequest;
use App\Services\Admin\StudentPromotionService;

class StudentPromotionController extends BaseController
{
    /**
     * Constructor
     */
    public function __construct(
        protected StudentPromotionService $promotionService
    ) {
        
    }

    /**
     * Promotion Page
     */
    public function index()
    {
        return view(
            'admin.student_promotions.index',
            [
                'academicSessions' => academic_session_options(),
                'classes' => class_options(),
                'sections' => section_options(),
            ]
        );
    }

    /**
     * Load Students
     */
    public function students(Request $request) {

        $students = $this->promotionService->students(
            $request->only([
                'academic_session_id',
                'class_id',
                'section_id'
            ])
        );

        return $this->success(
            'Students loaded successfully.',
            $students
        );
    }

    /**
     * Promote Students
     */
    public function promote(
        StudentPromotionRequest $request
    ) {
        $result = $this->promotionService->promote(
            $request->validated()
        );

        return $this->success(
            'Students promoted successfully.',
            $result,
        );
    }
}
