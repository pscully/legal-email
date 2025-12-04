<?php

namespace App\Filament\Resources\InviteeResource\Pages;

use App\Enums\InviteeStatus;
use App\Filament\Resources\InviteeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TextEntry;
use Filament\Schemas\Schema;

class ViewInvitee extends ViewRecord
{
    protected static string $resource = InviteeResource::class;

    public function infolist(Schema $infolist): Schema
    {
        return $infolist
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        TextEntry::make('first_name')
                            ->label('First Name'),
                        TextEntry::make('last_name')
                            ->label('Last Name'),
                        TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),
                    ])
                    ->columns(3),
                Section::make('Invitation Details')
                    ->schema([
                        TextEntry::make('signup_code')
                            ->label('Signup Code')
                            ->copyable(),
                        TextEntry::make('signup_url')
                            ->label('Signup URL')
                            ->url(fn ($record) => $record->signup_url)
                            ->openUrlInNewTab()
                            ->copyable(),
                    ])
                    ->columns(2),
                Section::make('Status Information')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (InviteeStatus $state): string => match ($state) {
                                InviteeStatus::Pending => 'gray',
                                InviteeStatus::Sent => 'info',
                                InviteeStatus::Accepted => 'success',
                                InviteeStatus::Failed => 'danger',
                            }),
                        TextEntry::make('sent_at')
                            ->label('Sent At')
                            ->dateTime()
                            ->placeholder('Not sent yet'),
                        TextEntry::make('accepted_at')
                            ->label('Accepted At')
                            ->dateTime()
                            ->placeholder('Not accepted yet'),
                    ])
                    ->columns(3),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('mark_as_sent')
                ->label('Mark as Sent')
                ->icon('heroicon-o-paper-airplane')
                ->color('info')
                ->visible(fn ($record) => $record->status !== InviteeStatus::Sent)
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->markAsSent();
                    $record->refresh();
                    $this->record = $this->getRecord();
                }),
            Actions\Action::make('mark_as_failed')
                ->label('Mark as Failed')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn ($record) => $record->status !== InviteeStatus::Failed)
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->markAsFailed();
                    $record->refresh();
                    $this->record = $this->getRecord();
                }),
            Actions\Action::make('mark_as_pending')
                ->label('Mark as Pending')
                ->icon('heroicon-o-clock')
                ->color('gray')
                ->visible(fn ($record) => $record->status !== InviteeStatus::Pending)
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['status' => InviteeStatus::Pending]);
                    $record->refresh();
                    $this->record = $this->getRecord();
                }),
        ];
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
