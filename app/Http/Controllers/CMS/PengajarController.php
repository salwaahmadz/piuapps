<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PengajarRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use illuminate\Support\Str;

class PengajarController extends Controller
{

    private $pengajarRepository;

    public function __construct(PengajarRepositoryInterface $pengajarRepo)
    {
        $this->pengajarRepository = $pengajarRepo;
    }

    public function index()
    {
        return view('cms.pages.pengajar.index');
    }

    public function list()
    {
        $params = [];

        $pengajar = $this->pengajarRepository->getAll($params);

        return DataTables::eloquent($pengajar)
            ->addColumn('action', 'cms.pages.pengajar.table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        $peserta = [];
        return view('cms.pages.pengajar.create', compact('peserta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:36',
            'tgl_lahir' => 'required|date',
            'nomor_hp' => 'nullable|numeric',
        ]);

        $payload = [
            'uuid' => Str::uuid(),
            'nama' => $request->nama,
            'tgl_lahir' => $request->tgl_lahir,
            'nomor_hp' => $request->nomor_hp,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $reponse = $this->pengajarRepository->store($payload);

        if ($reponse == 'error') {
            return response()->json([
                'error' => true,
                'message' => 'Gagal menambahkan pengajar, silahkan coba lagi!'
            ], 400);
        }

        return response()->json([
            'error' => false,
            'message' => 'Pengajar baru berhasil ditambahkan!'
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $this->pengajarRepository->destroy($id);

        return response()->json([
            "error" => false,
            "message" => "Pengajar berhasil dihapus",
            "data" => $id
        ]);
    }
}
