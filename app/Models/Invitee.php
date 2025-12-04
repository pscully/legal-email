<?php

namespace App\Models;

use App\Enums\InviteeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Invitee extends Model
{
    use HasFactory;

    protected $table = 'invitees';

    protected $fillable = [
        'signup_code',
        'first_name',
        'last_name',
        'email',
        'status',
        'sent_at',
        'accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => InviteeStatus::class,
            'sent_at' => 'datetime',
            'accepted_at' => 'datetime',
        ];
    }

    public function isPending(): bool
    {
        return $this->status === InviteeStatus::Pending;
    }

    public function isSent(): bool
    {
        return $this->status === InviteeStatus::Sent;
    }

    public function isAccepted(): bool
    {
        return $this->status === InviteeStatus::Accepted;
    }

    public function isFailed(): bool
    {
        return $this->status === InviteeStatus::Failed;
    }

    public function markAsSent(): void
    {
        $this->update([
            'status' => InviteeStatus::Sent,
            'sent_at' => now(),
        ]);
    }

    public function markAsAccepted(): void
    {
        $this->update([
            'status' => InviteeStatus::Accepted,
            'accepted_at' => now(),
        ]);
    }

    public function markAsFailed(): void
    {
        $this->update([
            'status' => InviteeStatus::Failed,
        ]);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getSignupUrlAttribute(): string
    {
        return "https://nclawyers4theruleoflaw.org/signup/?code={$this->signup_code}";
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', InviteeStatus::Pending);
    }

    public function scopeSent(Builder $query): Builder
    {
        return $query->where('status', InviteeStatus::Sent);
    }

    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('status', InviteeStatus::Accepted);
    }

    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', InviteeStatus::Failed);
    }
}
