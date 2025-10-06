<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'type',
        'tanggal',
        'jumlah',
        'seksi',
        'safety_stock',
        'movement_type',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
        'safety_stock' => 'decimal:2',
    ];

    /**
     * Relationship dengan Material
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Scope untuk movement masuk
     */
    public function scopeMasuk($query)
    {
        return $query->where('type', 'in');
    }

    /**
     * Scope untuk movement keluar
     */
    public function scopeKeluar($query)
    {
        return $query->where('type', 'out');
    }

    /**
     * Boot method untuk auto update stok material
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($movement) {
            $movement->material->updateStokCurrent();
        });

        static::updated(function ($movement) {
            $movement->material->updateStokCurrent();
        });

        static::deleted(function ($movement) {
            $movement->material->updateStokCurrent();
        });
    }
}
