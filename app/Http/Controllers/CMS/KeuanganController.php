<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\KeuanganRepositoryInterface;
use App\Repositories\Interfaces\PesertaRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class KeuanganController extends Controller
{
    private $keuanganRepository;
    private $pesertaRepository;

    public function __construct(
        KeuanganRepositoryInterface $keuanganRepo,
        PesertaRepositoryInterface $pesertaRepo
    ) {
        $this->keuanganRepository = $keuanganRepo;
        $this->pesertaRepository = $pesertaRepo;
    }

    // Kuangan Kurban
    public function indexKurban()
    {
        return view('cms.pages.kurban.index');
    }

    public function listKurban()
    {
        $params = [];

        $kurban = $this->keuanganRepository->getKurban($params)->get();

        foreach ($kurban as $row) {
            $row->type = 'kurban';
            $row->uuid = $row->peserta->uuid;
        }

        return DataTables::of($kurban)
            ->addColumn('action', 'cms.pages.kurban.table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function detailKurban($uuid)
    {
        $peserta = $this->pesertaRepository->getPesertaByUuid($uuid);
        if (empty($peserta)) {
            return redirect()->route('apps.kurban.index');
        }

        return view('cms.pages.kurban.detail', compact('peserta'));
    }

    public function detailListKurban(Request $request)
    {
        $peserta = $this->pesertaRepository->getPesertaByUuid($request->peserta);
        $id = $peserta->id;

        $kurban = $this->keuanganRepository->getPesertaKurbanDetail($id);

        return DataTables::of($kurban)
            ->addColumn('action', 'cms.pages.kurban.detail_table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function updateNominalKurban(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric',
        ]);

        $payload = [
            'nominal' => $request->nominal,
            'updated_at' => now(),
        ];

        $response = $this->keuanganRepository->updateNominal($payload);

        if ($response == 'error') {
            return response()->json([
                'error' => true,
                'message' => 'Gagal memperbaharui nominal, silahkan coba lagi!'
            ], 400);
        }

        return response()->json([
            'error' => false,
            'message' => 'Nominal berhasil diperbaharui!'
        ], 200);
    }

    public function createKurban()
    {
        $kurban = [];
        return view('cms.pages.kurban.create', compact('kurban'));
    }

    public function storeKurban(Request $request)
    {
        $request->validate([
            'peserta' => 'required|integer',
            'nominal' => 'required|numeric',
            'tgl_nabung' => 'required|date',
        ]);

        $payload = [
            'uuid' => Str::uuid(),
            'peserta_id' => $request->peserta,
            'nominal' => $request->nominal,
            'type' => 'kurban',
            'tgl_nabung' => $request->tgl_nabung,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $response = $this->keuanganRepository->storeKurban($payload);

        if ($response == 'error') {
            return response()->json([
                'error' => true,
                'message' => 'Gagal menambahkan tabungan, silahkan coba lagi!'
            ], 400);
        }

        return response()->json([
            'error' => false,
            'message' => 'Tabungan berhasil ditambahkan!'
        ], 200);
    }

    // Kuangan Kas
    public function indexKas()
    {
        return view('cms.pages.kas.index');
    }
}
