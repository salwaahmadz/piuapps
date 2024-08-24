<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    public function index()
    {
        return view('cms.pages.kategori.index');
    }

    public function list()
    {
        $params = [];

        $kategori = $this->categoryRepository->getAll($params);
        return DataTables::eloquent($kategori)
            ->addColumn('action', 'cms.pages.kategori.table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        $kategori = [];

        return view('cms.pages.kategori.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:16',
        ]);

        $payload = [
            'kategori' => $request->kategori,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $response = $this->categoryRepository->store($payload);

        if ($response == 'error') {
            return response()->json([
                "error" => true,
                "message" => "Gagal menambahkan kategori, silahkan coba lagi!"
            ], 400);
        }

        return response()->json([
            'error' => false,
            'message' => 'Kategori baru berhasil ditambahkan!'
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $this->categoryRepository->destroy($id);

        return response()->json([
            "error" => false,
            "message" => "Kategori berhasil dihapus",
            "data" => $id
        ]);
    }
}
