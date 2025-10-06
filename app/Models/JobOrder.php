<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'seksi','status','project','start','end','progress','actual','evaluasi'
    ];

    protected $casts = [
        'actual' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(JobOrderItem::class);
    }
}
