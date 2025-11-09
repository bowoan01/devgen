<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

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
        'meta' => 'array',
        'responded_at' => 'datetime',
    ];

    public const STATUS_NEW = 'new';
    public const STATUS_READ = 'read';
    public const STATUS_ARCHIVED = 'archived';

    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }
}
