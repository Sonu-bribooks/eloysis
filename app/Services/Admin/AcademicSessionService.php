<?php

namespace App\Services\Admin;

use App\Repositories\Admin\AcademicSessionRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class AcademicSessionService
{
    protected AcademicSessionRepository $academicSessionRepository;

    public function __construct(AcademicSessionRepository $academicSessionRepository)
    {
        $this->academicSessionRepository = $academicSessionRepository;
    }

    /**
     * Get sessions
     */
    public function getAcademicSession(
        array $filters = [],
        int $perPage = 10,
        int $page = 1,
        ?int $orderColumn = null,
        string $orderDirection = 'asc'
    ) {
        return $this->academicSessionRepository->getAcademicSessions($filters, $perPage, $page, $orderColumn, $orderDirection);
    }

    /**
     * Create Academic session
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $today = Carbon::today();
            $is_current = ($today->gt($data['start_date']) && $today->lt($data['end_date'])) ? true : false;
            $data['name'] = $data['session_name'];
            $data['is_current'] = $is_current;
            // dd('final',$data);
            $sessions = $this->academicSessionRepository->create($data);

            DB::commit();

            return $sessions;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Update Sessions
     */
    public function update(int $id, array $data)
    {
        DB::beginTransaction();

        try {
            $today = Carbon::today();
            $is_current = ($today->gt($data['start_date']) && $today->lt($data['end_date'])) ? true : false;
            $data['name'] = $data['session_name'];
            $data['is_current'] = $is_current;
            $session = $this->academicSessionRepository->update($id, $data);

            DB::commit();

            return $session;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Delete Session
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {

            $this->academicSessionRepository->delete($id);

            DB::commit();

            return true;

        } catch (Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Change Session Status
     */
    public function changeStatus(int $id)
    {
        $this->academicSessionRepository->changeStatus($id);

        return $this->academicSessionRepository->academicStatus($id);
    }
}
