<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class CommonController extends BaseController
{
    

    public function byClass(int $classId)
    {
        
        $sections = class_section_options($classId);
        $subjects  = class_subject_options($classId);
        return $this->success(
            'Section list fetched successfully.',
            $data=[
                'sections' => $sections,
                'subjects' => $subjects
                ],
        );
    }
}
