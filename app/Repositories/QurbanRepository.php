<?php

namespace App\Repositories;

use App\Models\Participant;
use App\Models\Qurban;
use App\Repositories\Interfaces\QurbanRepositoryInterface;
use Illuminate\Support\Facades\DB;

class QurbanRepository implements QurbanRepositoryInterface
{

    public function getAll($params)
    {
        return Qurban::query()->with('participant')
            ->when(!empty($params['participant_id']), function ($q) use ($params) {
                $q->where('keuangan.participant_id', $params['participant_id']);
            })
            ->select('participant_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('participant_id');
    }

    public function getParticipantQurbanDetail($id)
    {
        try {
            return Qurban::with('participant')->where('participant_id', $id)->get();
        } catch (\Throwable $th) {
            return 'null';
        }

        return $kurbanDetail;
    }

    public function getQurbanByUuid($uuid)
    {
        try {
            return Qurban::where('uuid', $uuid)->first();
        } catch (\Throwable $th) {
            return 'null';
        }
    }

    public function store($payload)
    {
        try {
            DB::beginTransaction();

            $qurban = Qurban::create($payload);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            return 'error';
        }
        return $qurban;
    }

    public function updateAmount($payload)
    {
        try {
            DB::beginTransaction();

            $amount = Qurban::where('id', $payload['id'])->update([
                'amount' => $payload['amount'],
                'updated_at' => $payload['updated_at'],
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return 'error';
        }

        return $amount;
    }

    public function destroy($id)
    {
        return Qurban::where('id', $id)->delete();
    }
}
