<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function getAll($params)
    {
        return Category::query()
            ->when(!empty($params['kategori']), function ($q) use ($params) {
                $q->where('categories.kategori', 'LIKE', '%'.$params['kategori'].'%');
            });
    }

}