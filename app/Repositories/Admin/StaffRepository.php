<?php

namespace App\Repositories\Admin;

use App\Models\StaffProfile;
use App\Repositories\BaseRepository;

class StaffRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(StaffProfile $model)
    {
        parent::__construct($model);
    }

    // public function query()
    // {
    //     return $this->model->newQuery();
    // }
}
