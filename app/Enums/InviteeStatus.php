<?php

namespace App\Enums;

enum InviteeStatus: string
{
    case Pending = 'pending';
    case Sent = 'sent';
    case Accepted = 'accepted';
    case Failed = 'failed';

    public function value(): string
    {
        return $this->value;
    }

    public function label(): string
    {
        return match($this) {
            self::Pending => 'Pending',
            self::Sent => 'Sent',
            self::Accepted => 'Accepted',
            self::Failed => 'Failed',
        };
    }
}
