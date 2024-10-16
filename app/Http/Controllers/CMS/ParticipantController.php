<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Repositories\Interfaces\ParticipantRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ParticipantController extends Controller
{
    private $participantRepository;

    public function __construct(ParticipantRepositoryInterface $participantRepo)
    {
        $this->participantRepository = $participantRepo;
    }

    public function index()
    {
        return view('cms.pages.participant.index');
    }

    public function list()
    {
        $params = [];

        $participants = $this->participantRepository->getAll($params);
        return DataTables::eloquent($participants)
            ->addColumn('action', 'cms.pages.participant.table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        $participant = [];
        return view('cms.pages.participant.create', compact('participant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:36',
            'category' => 'required|integer',
            'birthdate' => 'required|date',
            'phone_number' => 'nullable|numeric',
        ]);

        $payload = [
            'uuid' => Str::uuid(),
            'nama' => $request->name,
            'kategori_id' => $request->category,
            'tgl_lahir' => $request->birthdate,
            'nomor_hp' => $request->phone_number,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $response = $this->participantRepository->store($payload);

        if ($response == 'error') {
            return response()->json([
                "error" => true,
                "message" => "Failed to add participant, please try again!",
                "data" => $payload
            ], 400);
        }

        return response()->json([
            "error" => false,
            "message" => "Participant has been added!"
        ], 200);
    }

    public function edit($uuid)
    {
        $participant = $this->participantRepository->getParticipantByUuid($uuid);

        if (empty($participant)) {
            Session::flash('error', 'Participant not found!');
            return redirect()->route('apps.participant.index');
        }

        return view('cms.pages.participant.edit', compact('participant'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:36',
            'category' => 'required|integer',
            'birthdate' => 'required|date',
            'phone_number' => 'nullable|numeric',
        ]);

        $payload = [
            'uuid' => Str::uuid(),
            'nama' => $request->name,
            'kategori_id' => $request->category,
            'tgl_lahir' => $request->birthdate,
            'nomor_hp' => $request->phone_number,
            'status' => $request->status,
            'updated_at' => now(),
        ];

        $response = $this->participantRepository->update($payload, $request->id);

        if ($response == 'error') {
            return response()->json([
                "error" => true,
                "message" => "Failed to update participant, please try again!",
            ], 400);
        }

        return response()->json([
            'error' => false,
            "message" => "Participant has been updated!",
        ], 200);
    }

    public function destroy(Request $request)
    {
        $uuid = $request->uuid;
        $this->participantRepository->destroy($uuid);

        return response()->json([
            "error"   => false,
            "message" => "Participant has been deleted!",
        ], 200);
    }
}
