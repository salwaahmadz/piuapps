<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peserta';

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

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'kategori_id', 'id');
    }

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'peserta_id', 'id');
    }
}
