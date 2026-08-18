<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AcademicClassRepository;
use App\Repositories\Admin\StaffRepository;
use App\Repositories\Admin\StudentRepository;
use App\Repositories\Admin\SubjectRepository;
use App\Repositories\Admin\TeacherRepository;

class DashboardService
{
    public function __construct(
        protected StudentRepository $studentRepository,
        protected TeacherRepository $teacherRepository,
        protected AcademicClassRepository $classRepository,
        protected SubjectRepository $subjectRepository,
        protected StaffRepository $staffRepository,
    ) {}

    public function stats(): array
    {
        return [
            'students' => $this->studentRepository->query()->count(),
            'teachers' => $this->teacherRepository->query()->count(),
            'classes' => $this->classRepository->query()->count(),
            'subjects' => $this->subjectRepository->query()->count(),
            'admins' => $this->staffRepository->query()->count(),
            'exams' => 0,
            'results' => 0,
            'contacts' => 0,
        ];
    }
}
