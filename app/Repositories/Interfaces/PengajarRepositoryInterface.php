<?php

namespace App\Repositories\Interfaces;

interface PengajarRepositoryInterface
{
    public function getAll($params);

    public function store($payload);

    public function destroy($id);
}