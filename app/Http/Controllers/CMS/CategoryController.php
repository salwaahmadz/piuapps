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
        return view('cms.pages.category.index');
    }

    public function list()
    {
        $params = [];

        $categories = $this->categoryRepository->getAll($params);
        return DataTables::eloquent($categories)
            ->addColumn('action', 'cms.pages.category.table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        $category = [];

        return view('cms.pages.category.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:24',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $payload = [
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->status,
            'created_by' => auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $response = $this->categoryRepository->store($payload);

        if ($response == 'error') {
            return response()->json([
                "error" => true,
                "message" => "Failed to add category, please try again!",
            ], 400);
        }

        return response()->json([
            'error' => false,
            'message' => 'Category has been added!',
        ], 200);
    }

    public function edit($id)
    {

        $category = $this->categoryRepository->getCategoryById($id);

        return view('cms.pages.category.edit', compact('category'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:24',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $payload = [
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->status,
            'updated_at' => now(),
        ];

        $response = $this->categoryRepository->update($payload, $request->id);

        if ($response == 'error') {
            return response()->json([
                "error" => true,
                "message" => "Failed to update category, please try again!",
            ], 400);
        }

        return response()->json([
            'error' => false,
            'message' => 'Category has been updated!',
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $this->categoryRepository->destroy($id);

        return response()->json([
            "error" => false,
            "message" => "category has been deleted!",
        ], 200);
    }
}
