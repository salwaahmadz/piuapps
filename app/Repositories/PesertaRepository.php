<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PesertaRepositoryInterface;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;

class PesertaRepository implements PesertaRepositoryInterface
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
