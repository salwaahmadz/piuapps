<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mentor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengajar';

    protected $fillable = [
        'uuid',
        'nama',
        'kategori_id',
        'tgl_lahir',
        'nomor_hp',
        'status',
        'created_at',
        'updated_at'
    ];
}
