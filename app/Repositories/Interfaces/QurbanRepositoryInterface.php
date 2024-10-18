<?php

namespace App\Repositories\Interfaces;

interface QurbanRepositoryInterface
{
    public function getAll($params);
    public function getParticipantQurbanDetail($id);
    public function getQurbanByUuid($uuid);
    public function store($payload);
    public function updateAmount($payload);
    public function destroy($id);
}