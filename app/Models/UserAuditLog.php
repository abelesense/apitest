<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAuditLog extends Model
{
    use HasFactory;

    /**
     * Attributes that can be assigned in bulk.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'performed_by',
        'action',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    /**
     * Attributes that must be cast to specific types.
     *
     * @var array
     */
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    /**
     * Get the user that has been modified.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who made the change.
     */
    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
