<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ParticipantRepositoryInterface;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

class ParticipantRepository implements ParticipantRepositoryInterface
{

    public function getAll($params)
    {
        return Participant::query()->with('category', 'category')
            ->when(!empty($params['kategori_id']), function ($q) use ($params) {
                $q->where('peserta.kategori_id', $params['kategori_id']);
            })
            ->when(!empty($params['nama']), function ($q) use ($params) {
                $q->where('peserta.nama', 'LIKE', '%' . $params['nama'] . '%');
            });
    }

    // public function getPesertaByUuid($uuid)
    // {
    //     try {
    //         $peserta = Participant::with(['kategori', 'keuangan' => function ($query) {
    //             $query->select('peserta_id', 'nominal');
    //         }])->where('uuid', $uuid)->first();
    //     } catch (\Throwable $th) {
    //         return 'null';
    //     }

    //     return $peserta;
    // }

    public function getParticipantByUuid($uuid)
    {
        try {
            $participant = Participant::with('category')->where('uuid', $uuid)->first();
        } catch (\Throwable $th) {
            return 'null';
        }

        return $participant;
    }

    public function store($payload)
    {
        try {
            DB::beginTransaction();

            $participant = Participant::create($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }

        return $participant;
    }

    public function update($payload, $id)
    {
        try {
            DB::beginTransaction();

            $participant = Participant::find($id);
            
            $participant->update($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }

        return $participant;
    }

    public function destroy($uuid)
    {
        return Participant::where('uuid', $uuid)->delete();
    }
}
