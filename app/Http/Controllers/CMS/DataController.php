<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class DataController extends Controller
{
    private $categoryRepository;
    
    function __construct(
        CategoryRepositoryInterface $categoryRepo
    )
    {
        $this->categoryRepository = $categoryRepo;        
    }

    public function kategori(Request $request)
    {
        $params = [
            'kategori' => $request->kategori
        ];

        return $this->categoryRepository->getAll($params)->get();
    }
}
