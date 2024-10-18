<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MentorRepositoryInterface;
use App\Models\Mentor;
use Illuminate\Support\Facades\DB;

class MentorRepository implements MentorRepositoryInterface
{
    public function getAll($params)
    {
        return Mentor::query()
            ->when(!empty($params['nama']), function ($q) use ($params) {
                $q->where('pengajar.nama', 'LIKE', '%' . $params['nama'] . '%');
            });
    }

    public function getMentorByUuid($uuid)
    {
        try {
            $mentor = Mentor::where('uuid', $uuid)->first();
        } catch (\Throwable $th) {
            return 'null';
        }

        return $mentor;
    }

    public function store($payload)
    {
        try {
            DB::beginTransaction();

            $pengajar = Mentor::create($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }

        return $pengajar;
    }

    public function update($payload, $id)
    {
        try {
            DB::beginTransaction();

            $mentor = Mentor::find($id);

            $mentor->update($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }

        return $mentor;
    }

    public function destroy($uuid)
    {
        return Mentor::where('uuid', $uuid)->delete();
    }
}
