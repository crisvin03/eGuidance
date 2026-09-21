<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'user_1_id',
        'user_2_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the first user in the conversation
     */
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_1_id');
    }

    /**
     * Get the second user in the conversation
     */
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_2_id');
    }

    /**
     * Get all messages in this conversation
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest message
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Get the other user in the conversation
     */
    public function getOtherUser($userId)
    {
        return $this->user_1_id == $userId ? $this->user2 : $this->user1;
    }

    /**
     * Get unread messages count for a specific user
     */
    public function unreadCount($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Find or create a conversation between two users
     */
    public static function findOrCreate($user1Id, $user2Id)
    {
        // Ensure consistent ordering (lower ID first)
        $minId = min($user1Id, $user2Id);
        $maxId = max($user1Id, $user2Id);

        return static::firstOrCreate([
            'user_1_id' => $minId,
            'user_2_id' => $maxId,
        ]);
    }
}
