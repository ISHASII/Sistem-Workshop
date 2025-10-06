<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialMasuk extends Model
{
    use HasFactory;

    protected $table = 'material_masuks';

    protected $fillable = [
        'tanggal',
        'material',
        'spesifikasi',
        'jumlah',
        'safety_stock',
        'satuan_id',
        'kategori_id',
    ];

    /**
     * Cast tanggal to a date instance so ->format() works in views
     */
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
