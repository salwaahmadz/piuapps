<?php

namespace App\Repositories\Interfaces;

interface KeuanganRepositoryInterface
{
    public function getAll($params);
    public function getKurban($params);
    public function getPesertaKurbanDetail($id);
    public function updateNominal($payload);
    public function storeKurban($payload);
    public function getKas($params);
    public function store($payload);
    public function destroy($id);
}