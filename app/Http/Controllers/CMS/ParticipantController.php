<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ParticipantRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'name' => 'required|string|max:100',
            'category' => 'required|integer',
            'birthdate' => 'required|date',
            'phone_number' => 'nullable|numeric',
        ]);

        $payload = [
            'uuid' => Str::uuid(),
            'category_id' => $request->category,
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'phone_number' => $request->phone_number,
            'is_active' => $request->status,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $response = $this->participantRepository->store($payload);

        if ($response == 'error') {
            return response()->json([
                "error" => true,
                "message" => "Gagal menambahkan peserta, silahkan coba lagi!",
            ], 400);
        }

        return response()->json([
            "error" => false,
            "message" => "Peserta berhasil ditambahkan!",
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
            'name' => 'required|string|max:100',
            'category' => 'required|integer',
            'birthdate' => 'required|date',
            'phone_number' => 'nullable|numeric',
        ]);

        $payload = [
            'uuid' => Str::uuid(),
            'category_id' => $request->category,
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'phone_number' => $request->phone_number,
            'is_active' => $request->status,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $response = $this->participantRepository->update($payload, $request->id);

        if ($response == 'error') {
            return response()->json([
                "error" => true,
                "message" => "Gagal mengupdate peserta, silahkan coba lagi!",
            ], 400);
        }

        return response()->json([
            'error' => false,
            "message" => "Peserta berhasil diupdate!",
        ], 200);
    }

    public function destroy(Request $request)
    {
        $uuid = $request->uuid;
        $this->participantRepository->destroy($uuid);

        return response()->json([
            "error"   => false,
            "message" => "Peserta berhasil dihapus!",
        ], 200);
    }
}
