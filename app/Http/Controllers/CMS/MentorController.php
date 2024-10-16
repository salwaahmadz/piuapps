<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MentorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use illuminate\Support\Str;

class MentorController extends Controller
{

    private $mentorRepository;

    public function __construct(MentorRepositoryInterface $mentorRepo)
    {
        $this->mentorRepository = $mentorRepo;
    }

    public function index()
    {
        return view('cms.pages.mentor.index');
    }

    public function list()
    {
        $params = [];

        $mentors = $this->mentorRepository->getAll($params);

        return DataTables::eloquent($mentors)
            ->addColumn('action', 'cms.pages.mentor.table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        $mentor = [];
        return view('cms.pages.mentor.create', compact('mentor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:36',
            'birthdate' => 'required|date',
            'phone_number' => 'nullable|numeric',
        ]);

        $payload = [
            'uuid' => Str::uuid(),
            'nama' => $request->name,
            'tgl_lahir' => $request->birthdate,
            'nomor_hp' => $request->phone_number,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $reponse = $this->mentorRepository->store($payload);

        if ($reponse == 'error') {
            return response()->json([
                'error' => true,
                'message' => 'Failed to add mentor, please try again!'
            ], 400);
        }

        return response()->json([
            'error' => false,
            'message' => 'Mentor has been added!'
        ], 200);
    }

    public function edit($uuid)
    {
        $mentor = $this->mentorRepository->getMentorByUuid($uuid);

        if (empty($mentor)) {
            Session::flash('error', 'Mentor not found!');
            return redirect()->route('apps.mentor.index');
        }

        return view('cms.pages.mentor.edit', compact('mentor'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:36',
            'birthdate' => 'required|date',
            'phone_number' => 'nullable|numeric',
        ]);

        $payload = [
            'uuid' => Str::uuid(),
            'nama' => $request->name,
            'tgl_lahir' => $request->birthdate,
            'nomor_hp' => $request->phone_number,
            'status' => $request->status,
            'updated_at' => now(),
        ];

        $reponse = $this->mentorRepository->update($payload, $request->id);

        if ($reponse == 'error') {
            return response()->json([
                'error' => true,
                'message' => 'Failed to update mentor, please try again!'
            ], 400);
        }
        
        return response()->json([
            'error' => false,
            'message' => 'Mentor has been updated!'
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $this->mentorRepository->destroy($id);

        return response()->json([
            "error" => false,
            "message" => "Mentor has been deleted!",
        ], 200);
    }
}
