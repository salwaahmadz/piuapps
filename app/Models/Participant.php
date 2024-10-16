<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
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

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id', 'id');
    }

    public function finance()
    {
        return $this->hasOne(Finance::class);
    }
}
