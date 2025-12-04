<?php

namespace App\Filament\Resources\InviteeResource\Pages;

use App\Enums\InviteeStatus;
use App\Filament\Resources\InviteeResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListInvitees extends ListRecords
{
    protected static string $resource = InviteeResource::class;

    protected function getHeaderActions(): array
    {
        // No create action - invitees are imported via CSV
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InviteeStatus::Pending))
                ->badge(fn () => \App\Models\Invitee::where('status', InviteeStatus::Pending)->count()),
            'sent' => Tab::make('Sent')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InviteeStatus::Sent))
                ->badge(fn () => \App\Models\Invitee::where('status', InviteeStatus::Sent)->count()),
            'accepted' => Tab::make('Accepted')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InviteeStatus::Accepted))
                ->badge(fn () => \App\Models\Invitee::where('status', InviteeStatus::Accepted)->count()),
            'failed' => Tab::make('Failed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', InviteeStatus::Failed))
                ->badge(fn () => \App\Models\Invitee::where('status', InviteeStatus::Failed)->count()),
        ];
    }
}
