<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'seksi','status','project','start','end','progress','actual','evaluasi',
        'area','latar_belakang','tujuan','target','images','created_by'
    ];

    protected $casts = [
        'actual' => 'date',
        'images' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(JobOrderItem::class);
    }

    /**
     * Get the user who created this job order
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}