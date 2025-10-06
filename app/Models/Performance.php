<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $fillable = [
        'manpower_id','job_order_id','tanggal',
        'material_sesuai_jo','dimensi_sesuai_jo','item_sesuai_design','pengelasan_tidak_retak','item_bebas_spatter',
        'baut_terpasang_baik_lengkap','tidak_ada_bagian_tajam','finishing_standar','tidak_ada_kotoran','berfungsi_dengan_baik',
        'score','rating'
    ];

    protected $casts = [
        'material_sesuai_jo' => 'boolean',
        'dimensi_sesuai_jo' => 'boolean',
        'item_sesuai_design' => 'boolean',
        'pengelasan_tidak_retak' => 'boolean',
        'item_bebas_spatter' => 'boolean',
        'baut_terpasang_baik_lengkap' => 'boolean',
        'tidak_ada_bagian_tajam' => 'boolean',
        'finishing_standar' => 'boolean',
        'tidak_ada_kotoran' => 'boolean',
        'berfungsi_dengan_baik' => 'boolean',
    ];

    public function manpower()
    {
        return $this->belongsTo(Manpower::class);
    }

    public function jobOrder()
    {
        return $this->belongsTo(JobOrder::class);
    }
}
