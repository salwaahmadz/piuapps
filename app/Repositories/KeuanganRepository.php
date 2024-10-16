<?php

namespace App\Repositories;

use App\Models\Finance;
use App\Repositories\Interfaces\KeuanganRepositoryInterface;
use App\Models\Participant;
use App\Models\Keuangan;
use Illuminate\Support\Facades\DB;

class KeuanganRepository implements KeuanganRepositoryInterface
{

    public function getAll($params)
    {
        return Participant::query()->with('kategori', 'kategori')
            ->when(!empty($params['kategori_id']), function ($q) use ($params) {
                $q->where('peserta.kategori_id', $params['kategori_id']);
            })
            ->when(!empty($params['nama']), function ($q) use ($params) {
                $q->where('peserta.nama', 'LIKE', '%' . $params['nama'] . '%');
            });
    }

    public function getKurban($params)
    {
        return Finance::query()->with('peserta')
            ->when(!empty($params['peserta_id']), function ($q) use ($params) {
                $q->where('keuangan.peserta_id', $params['peserta_id']);
            })
            ->where('type', 'kurban')
            ->select('peserta_id', DB::raw('SUM(nominal) as total_nominal'))
            ->groupBy('peserta_id');
    }

    public function getPesertaKurbanDetail($id)
    {
        try {
            return Finance::with('peserta')->where('peserta_id', $id)->get();
        } catch (\Throwable $th) {
            return 'null';
        }

        return $kurbanDetail;
    }

    public function storeKurban($payload)
    {
        try {
            DB::beginTransaction();

            $keuangan = Finance::create($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }
        return $keuangan;
    }

    public function updateNominal($payload)
    {
        try {
            DB::beginTransaction();

            $nominal = Finance::where('id', $payload['id'])->update($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }

        return $nominal;
    }

    public function getKas($params) {}

    public function store($payload)
    {
        try {
            DB::beginTransaction();

            $peserta = Finance::create($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }

        return $peserta;
    }

    public function destroy($id)
    {
        return Participant::where('id', $id)->delete();
    }
}
