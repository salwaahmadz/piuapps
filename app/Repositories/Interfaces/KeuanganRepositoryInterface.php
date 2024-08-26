<?php

namespace App\Repositories\Interfaces;

interface KeuanganRepositoryInterface
{
    public function getAll($params);
    public function getKurban($params);
    public function storeKurban($payload);
    public function getKas($params);
    public function store($payload);
    public function destroy($id);
}