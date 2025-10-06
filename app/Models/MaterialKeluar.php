<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialKeluar extends Model
{
    use HasFactory;

    protected $table = 'material_keluars';

    protected $fillable = [
        'seksi',
        'tanggal',
        'material',
        'spesifikasi',
        'jumlah',
        'satuan_id',
        'kategori_id',
        'type',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
