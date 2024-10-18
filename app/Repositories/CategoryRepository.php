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
            ->when(!empty($params['kategori']), function ($q) use ($params) {
                $q->where('categories.kategori', 'LIKE', '%' . $params['kategori'] . '%');
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
