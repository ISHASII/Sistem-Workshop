<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'seksi','status','project','start','end','progress','actual','evaluasi',
        'area','latar_belakang','tujuan','target','images','created_by',
        'approval_status','approval_requested_at','approved_by','approved_at','rejected_by','rejected_at','rejection_reason',
        'epp_approval_status', 'epp_approved_by', 'epp_approved_at'
    ];

    protected $casts = [
        'actual' => 'date',
        'approval_requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'epp_approved_at' => 'datetime',
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

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function eppApprovedBy()
    {
        return $this->belongsTo(User::class, 'epp_approved_by');
    }

    public function scopePendingApproval($query)
    {
        return $query->where('approval_status', 'pending');
    }

    public function scopeApprovedApproval($query)
    {
        return $query->where('approval_status', 'approved')->where('epp_approval_status', 'approved');
    }

    public function scopeRejectedApproval($query)
    {
        return $query->where('approval_status', 'rejected');
    }
}
