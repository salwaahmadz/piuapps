<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function getAll($params)
    {
        return Category::query()
            ->when(!empty($params['name']), function ($q) use ($params) {
                $q->where('categories.name', '=', '%' . $params['name'] . '%');
            });
    }

    public function getCategoryById($id)
    {
        $category = Category::where('id', $id)->first();

        return $category;
    }

    public function store($payload)
    {
        try {
            DB::beginTransaction();

            $kategori = Category::create($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }

        return $kategori;
    }

    public function update($payload, $id)
    {
        $category = Category::where('id', $id);

        $category->update($payload);

        return $category;
    }
    
    public function destroy($id)
    {
        return Category::where('id', $id)->delete();
    }
}
