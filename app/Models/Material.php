<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'spesifikasi',
        'jumlah',
        'safety_stock',
        'satuan_id',
        'kategori_id',
        'stok_current'
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'safety_stock' => 'decimal:2',
        'stok_current' => 'decimal:2'
    ];

    /**
     * Boot method for Material model to keep stok_current perfectly synced
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($material) {
            $material->stok_current = $material->jumlah;
        });

        static::updating(function ($material) {
            $material->stok_current = $material->calculateDynamicStok();
        });
    }

    /**
     * Relationship dengan Satuan
     */
    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    /**
     * Relationship dengan Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Relationship dengan MaterialMovement
     */
    public function movements()
    {
        return $this->hasMany(MaterialMovement::class);
    }

    /**
     * Get current stock including movements (checks stok_current cache first with self-healing fallback)
     */
    public function getCurrentStok()
    {
        if (isset($this->stok_current)) {
            // Self-heal: If stok_current is 0 but base jumlah > 0 and no movements exist, it is out of sync
            if ((float)$this->stok_current === 0.0 && $this->jumlah > 0 && !$this->movements()->exists()) {
                $calculated = (float) $this->calculateDynamicStok();
                $this->updateStokCurrent();
                return $calculated;
            }
            return (float) $this->stok_current;
        }

        return (float) $this->calculateDynamicStok();
    }

    /**
     * Dynamically calculate stock from movements history directly from DB
     */
    public function calculateDynamicStok()
    {
        $stokMasuk = $this->movements()
            ->where('type', 'in')
            ->sum('jumlah');

        $stokKeluar = $this->movements()
            ->where('type', 'out')
            ->sum('jumlah');

        return $this->jumlah + $stokMasuk - $stokKeluar;
    }

    /**
     * Check apakah stok di bawah safety stock
     */
    public function isStokKurang()
    {
        return $this->getCurrentStok() <= $this->safety_stock;
    }

    /**
     * Recalculate and persist current stock if a column exists.
     * MaterialMovement hooks call this after create/update/delete.
     */
    public function updateStokCurrent(): void
    {
        $current = $this->calculateDynamicStok();

        // If the table has a 'stok_current' or 'current_stok' column, persist it for faster reads.
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        if (in_array('stok_current', $columns)) {
            $this->forceFill(['stok_current' => $current])->saveQuietly();
        } elseif (in_array('current_stok', $columns)) {
            $this->forceFill(['current_stok' => $current])->saveQuietly();
        } else {
            // If no column for caching stock, simply touch the model to update timestamps
            // so any cache layers or observers can react.
            $this->touch();
        }
    }
}
