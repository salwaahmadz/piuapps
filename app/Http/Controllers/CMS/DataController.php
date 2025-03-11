<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ParticipantRepositoryInterface;
use Illuminate\Http\Request;

class DataController extends Controller
{
    private $categoryRepository;
    private $participantRepository;

    function __construct(
        CategoryRepositoryInterface $categoryRepo,
        ParticipantRepositoryInterface $participantRepo
    ) {
        $this->categoryRepository = $categoryRepo;
        $this->participantRepository = $participantRepo;
    }

    public function categories(Request $request)
    {
        $params = [
            'name' => $request->kategori
        ];

        return $this->categoryRepository->getAll($params)->get();
    }

    public function participants(Request $request)
    {
        $params = [
            'name' => $request->nama
        ];

        return $this->participantRepository->getAll($params)->get();
    }
}
