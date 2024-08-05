<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PesertaRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PesertaController extends Controller
{
    private $pesertaRepository;

    public function __construct(PesertaRepositoryInterface $pesertaRepo)
    {
        $this->pesertaRepository = $pesertaRepo;
    }

    public function index()
    {
        return view('cms.pages.peserta.index');
    }

    public function list()
    {
        $params = [];

        $peserta = $this->pesertaRepository->getAll($params);
        return DataTables::eloquent($peserta)
            ->addColumn('action', 'cms.pages.peserta.table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        $peserta = [];
        return view('cms.pages.peserta.create', compact('peserta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:36',
            'kategori' => 'required|integer',
            'tgl_lahir' => 'required|date',
        ]);

        $payload = [
            'uuid' => Str::uuid(),
            'nama' => $request->nama,
            'kategori_id' => $request->kategori,
            'tgl_lahir' => $request->tgl_lahir,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $response = $this->pesertaRepository->store($payload);

        if ($response == 'error') {
            return response()->json([
                "error" => true,
                "message" => "Gagal menambahkan peserta, silahkan coba lagi!"
            ], 400);
        }

        return response()->json([
            "error" => false,
            "message" => "Peserta baru berhasil ditambahkan!"
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $this->pesertaRepository->destroy($id);

        return response()->json([
            "error"   => false,
            "message" => "Peserta berhasil dihapus",
            "data"    => $id
        ]);
    }
}
