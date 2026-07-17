<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AcademicSessionRequest;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Services\Admin\AcademicSessionService;
use Carbon\Carbon;

class AcademicSessionController extends BaseController
{
    protected AcademicSessionService $academicSessionService;

    public function __construct(AcademicSessionService $academicSessionService)
    {
        $this->academicSessionService = $academicSessionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.academic_session.index');
    }

    public function list(Request $request)
    {
        $filters = $request->only([
            'search',
            'filter_status',
            'page'
        ]);

        $sessions = $this->academicSessionService->getAcademicSession($filters);
        return $this->success(
            'Session list fetched successfully.',
            $sessions
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicSessionRequest $request)
    {
        // dd($request->all());
        $this->academicSessionService->create(
            $request->validated()
        );

        return $this->success(
            'Academic Session created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicSession $academic)
    {
        return $this->success(
            'Academic Session fetched successfully.',
            $academic
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicSessionRequest $request, AcademicSession $academic)
    {
        //  dd($request->all());
        $this->academicSessionService->update(
            $academic->id,
            $request->validated()
        );

        return $this->success(
            'Academic Session updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicSession $academic)
    {
        
        if ($academic->is_current) {
            return $this->error(
                'Current academic session cannot be deleted.',
                [],
                400
            );
        }
        if ($academic->studentEnroll()->exists()) {

            return $this->error(
                'This Academic session is assigned to students and cannot be deleted.',
                [],
                422
            );

        }
        $this->academicSessionService->delete(
            $academic->id
        );

        return $this->success(
            'Academic Session deleted successfully.'
        );
    }

    /**
     * Change status
     */
    public function changeStatus(AcademicSession $academic)
    {
        $today = Carbon::today();

        if ($today->lt($academic->start_date) || $today->gt($academic->end_date)) {
            return $this->error(
                'Only the current academic session status can be changed.',
                [],
                422
            );
        }
        $this->academicSessionService->changeStatus($academic->id);

        return $this->success(
            'Academic Session updated successfully.'
        );
    }
}
