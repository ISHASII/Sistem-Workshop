<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'spesifikasi',
        'jumlah',
        'safety_stock',
        'satuan_id',
        'kategori_id'
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'safety_stock' => 'decimal:2'
    ];

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
     * Get current stock including movements
     */
    public function getCurrentStok()
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
        return $this->getCurrentStok() < $this->safety_stock;
    }

    /**
     * Recalculate and persist current stock if a column exists.
     * MaterialMovement hooks call this after create/update/delete.
     */
    public function updateStokCurrent(): void
    {
        $current = $this->getCurrentStok();

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
