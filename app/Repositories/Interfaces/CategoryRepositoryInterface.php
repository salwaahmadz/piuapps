<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAll($params);

    public function store($payload);

    public function destroy($id);
}