<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\KeuanganRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class KeuanganController extends Controller
{
    private $keuanganRepository;

    public function __construct(KeuanganRepositoryInterface $keuanganRepo)
    {
        $this->keuanganRepository = $keuanganRepo;
    }

    // Kuangan Kurban
    public function indexkr()
    {
        return view('cms.pages.kurban.index');
    }

    public function listkr()
    {
        $params = [];

        $kurban = $this->keuanganRepository->getKurban($params)->get();

        foreach ($kurban as $row) {
            $row->type = 'kurban';
        }

        return DataTables::of($kurban)
            ->addColumn('action', 'cms.pages.kurban.table_action')
            ->addIndexColumn()
            ->toJson();
    }

    public function createkr()
    {
        $kurban = [];
        return view('cms.pages.kurban.create', compact('kurban'));
    }

    public function storekr(Request $request)
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
    public function indexks()
    {
        return view('cms.pages.kas.index');
    }
}
