<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'jabatan_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the notifications for this user
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get unread notifications count
     */
    public function unreadNotificationsCount()
    {
        return $this->notifications()->unread()->count();
    }

    /**
     * Get job orders created by this user
     */
    public function createdJobOrders()
    {
        return $this->hasMany(JobOrder::class, 'created_by');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'department_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function isManagementCustomer(): bool
    {
        $jabatanName = strtolower(trim((string) optional($this->jabatan)->name));
        $normalized = str_replace([' ', '_', '-'], '', $jabatanName);

        return in_array($normalized, [
            'managementcustomer',
            'manajemencustomer',
            'manajementcustomer',
        ], true);
    }
}
