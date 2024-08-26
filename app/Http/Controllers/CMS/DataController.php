<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\PesertaRepositoryInterface;
use Illuminate\Http\Request;

class DataController extends Controller
{
    private $categoryRepository;
    private $pesertaRepository;
    
    function __construct(
        CategoryRepositoryInterface $categoryRepo,
        PesertaRepositoryInterface $pesertaRepo
    )
    {
        $this->categoryRepository = $categoryRepo;  
        $this->pesertaRepository = $pesertaRepo;      
    }

    public function kategori(Request $request)
    {
        $params = [
            'kategori' => $request->kategori
        ];

        return $this->categoryRepository->getAll($params)->get();
    }

    public function peserta(Request $request)
    {
        $params = [
            'nama' => $request->nama
        ];

        return $this->pesertaRepository->getAll($params)->get();
    }
}
