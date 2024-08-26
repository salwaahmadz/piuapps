<?php

namespace App\Repositories;

use App\Repositories\Interfaces\KeuanganRepositoryInterface;
use App\Models\Peserta;
use App\Models\Keuangan;
use Illuminate\Support\Facades\DB;

class KeuanganRepository implements KeuanganRepositoryInterface
{

    public function getAll($params)
    {
        return Peserta::query()->with('kategori', 'kategori')
            ->when(!empty($params['kategori_id']), function ($q) use ($params) {
                $q->where('peserta.kategori_id', $params['kategori_id']);
            })
            ->when(!empty($params['nama']), function ($q) use ($params) {
                $q->where('peserta.nama', 'LIKE', '%' . $params['nama'] . '%');
            });
    }

    public function getKurban($params)
    {
        return Keuangan::query()->with('peserta')
            ->when(!empty($params['peserta_id']), function ($q) use ($params) {
                $q->where('keuangan.peserta_id', $params['peserta_id']);
            })
            ->where('type', 'kurban')
            ->select('peserta_id', DB::raw('SUM(nominal) as total_nominal'))
            ->groupBy('peserta_id');
    }

    public function storeKurban($payload)
    {
        try {
            DB::beginTransaction();

            $keuangan = Keuangan::create($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }
        return $keuangan;
    }

    public function getKas($params) {}

    public function store($payload)
    {
        try {
            DB::beginTransaction();

            $peserta = Peserta::create($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }

        return $peserta;
    }

    public function destroy($id)
    {
        return Peserta::where('id', $id)->delete();
    }
}
