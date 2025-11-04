<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status',
        'admin_reply',
        'replied_by',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function isUnread(): bool
    {
        return $this->status === 'unread';
    }

    public function isRead(): bool
    {
        return $this->status === 'read';
    }

    public function isReplied(): bool
    {
        return $this->status === 'replied';
    }

    public function markAsRead(): void
    {
        $this->status = 'read';
        $this->save();
    }

    public function markAsReplied(string $reply, int $adminId): void
    {
        $this->admin_reply = $reply;
        $this->replied_by = $adminId;
        $this->replied_at = now();
        $this->status = 'replied';
        $this->save();
    }
}