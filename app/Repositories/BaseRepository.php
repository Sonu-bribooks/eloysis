<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     */
    public function all()
    {
        return $this->model->latest()->get();
    }

    /**
     * Paginate records.
     */
    public function paginate($perPage = 10)
    {
        return $this->model->latest()->paginate($perPage);
    }

    /**
     * Find by id.
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create record.
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update record.
     */
    public function update($id, array $data)
    {
        $record = $this->find($id);

        $record->update($data);

        return $record;
    }

    /**
     * Delete record.
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Change record Status.
     */
    public function changeStatus(int $id)
    {
        $role = $this->findOrFail($id);

        $role->status = ! $role->status;

        return $role->save();
    }
}