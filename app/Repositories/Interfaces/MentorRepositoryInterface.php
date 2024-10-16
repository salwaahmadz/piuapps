<?php

namespace App\Repositories\Interfaces;

interface MentorRepositoryInterface
{
    public function getAll($params);
    public function getMentorByUuid($uuid);
    public function store($payload);
    public function update($payload, $id);
    public function destroy($uuid);
}