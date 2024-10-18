<?php

namespace App\Repositories\Interfaces;

interface ParticipantRepositoryInterface
{
    public function getAll($params);
    public function getParticipantByUuid($uuid);
    public function store($payload);
    public function update($payload, $id);
    public function destroy($uuid);
}