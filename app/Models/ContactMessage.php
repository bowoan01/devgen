<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_READ = 'read';
    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'name',
        'email',
        'company',
        'phone',
        'message',
        'status',
        'responded_at',
        'meta',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'meta' => 'array',
    ];

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
