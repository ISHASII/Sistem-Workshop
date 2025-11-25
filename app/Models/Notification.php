<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'data',
        'read_at',
        'user_id',
        'job_order_id',
        'action_by'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification (admin)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job order related to the notification
     */
    public function jobOrder(): BelongsTo
    {
        return $this->belongsTo(JobOrder::class);
    }

    /**
     * Get the user who performed the action
     */
    public function actionBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'action_by');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): bool
    {
        return $this->update(['read_at' => now()]);
    }

    /**
     * Check if notification is read
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope for read notifications
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope for specific type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}