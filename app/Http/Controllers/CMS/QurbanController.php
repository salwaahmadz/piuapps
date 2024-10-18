<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\QurbanRepositoryInterface;
use App\Repositories\Interfaces\ParticipantRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class QurbanController extends Controller
{
    private $qurbanRepository;
    private $participantRepository;

    public function __construct(
        QurbanRepositoryInterface $qurbanRepo,
        ParticipantRepositoryInterface $participantRepo
    ) {
        $this->qurbanRepository = $qurbanRepo;
        $this->participantRepository = $participantRepo;
    }

    // Kuangan qurban
    public function index()
    {
        return view('cms.pages.qurban.index');
    }

    public function list()
    {
        $params = [];

        $qurban = $this->qurbanRepository->getAll($params)->get();

        foreach ($qurban as $row) {
            $row->uuid = $row->participant->uuid;
        }

        return DataTables::of($qurban)
            ->addColumn('action', 'cms.pages.qurban.table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function detail($uuid)
    {
        $participant = $this->participantRepository->getParticipantByUuid($uuid);

        if (empty($participant)) {
            return redirect()->route('apps.qurban.index');
        }

        return view('cms.pages.qurban.detail', compact('participant'));
    }

    public function detailList(Request $request)
    {
        $participant = $this->participantRepository->getParticipantByUuid($request->participant);
        $id = $participant->id;

        $qurban = $this->qurbanRepository->getParticipantQurbanDetail($id);

        return DataTables::of($qurban)
            ->addColumn('action', 'cms.pages.qurban.detail_table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        $qurban = [];
        return view('cms.pages.qurban.create', compact('qurban'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'participant' => 'required|integer',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $payload = [
            'uuid' => Str::uuid(),
            'participant_id' => $request->participant,
            'amount' => $request->amount,
            'date' => $request->date,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $response = $this->qurbanRepository->store($payload);

        if ($response == 'error') {
            return response()->json([
                'error' => true,
                'message' => 'Failed to add savings, please try again!'
            ], 400);
        }

        return response()->json([
            'error' => false,
            'message' => 'Savings has been added!'
        ], 200);
    }

    public function edit($uuid)
    {
        $qurban = $this->qurbanRepository->getQurbanByUuid($uuid);
        
        if (empty($qurban)) {
            Session::flash('error', 'Savings data not found!');
            return redirect()->route('apps.qurban.index');
        }

        return view('cms.pages.qurban.edit', compact('qurban'));
    }

    public function updateAmount(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $payload = [
            'id' => $request->id,
            'amount' => $request->amount,
            'updated_at' => now(),
        ];

        $response = $this->qurbanRepository->updateAmount($payload);

        if ($response == 'error') {
            return response()->json([
                'error' => true,
                'message' => 'Failed to update savings, please try again!'
            ], 400);
        }

        return response()->json([
            'error' => false,
            'message' => 'Savings has been updated!'
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $this->qurbanRepository->destroy($id);

        return response()->json([
            "error" => false,
            "message" => "Savings record has been deleted!",
        ], 200);
    }
}
