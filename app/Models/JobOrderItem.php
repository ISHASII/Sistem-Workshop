<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_order_id', 'material_id', 'spesifikasi', 'jumlah', 'satuan'
    ];

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
