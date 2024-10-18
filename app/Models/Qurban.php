<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qurban extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'participant_id',
        'amount',
        'date',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
