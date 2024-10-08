<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keuangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'keuangan';

    protected $fillable = [
        'uuid',
        'peserta_id',
        'nominal',
        'type',
        'tgl_nabung',
        'created_by'
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}
