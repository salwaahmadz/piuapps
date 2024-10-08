<?php

namespace App\Repositories\Interfaces;

interface PesertaRepositoryInterface
{
    public function getAll($params);
    public function getPesertaByUuid($uuid);
    public function store($payload);
    public function destroy($id);
}