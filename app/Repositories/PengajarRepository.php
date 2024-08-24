<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PengajarRepositoryInterface;
use App\Models\Pengajar;
use Illuminate\Support\Facades\DB;

class PengajarRepository implements PengajarRepositoryInterface
{
    public function getAll($params)
    {
        return Pengajar::query()
            ->when(!empty($params['nama']), function ($q) use ($params) {
                $q->where('pengajar.nama', 'LIKE', '%' . $params['nama'] . '%');
            });
    }

    public function store($payload)
    {
        try {
            DB::beginTransaction();

            $pengajar = Pengajar::create($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }

        return $pengajar;
    }

    public function destroy($id)
    {
        return Pengajar::where('id', $id)->delete();
    }
}
