<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAll($params);
    public function getCategoryById($id);
    public function store($payload);
    public function update($payload, $id);
    public function destroy($id);
}