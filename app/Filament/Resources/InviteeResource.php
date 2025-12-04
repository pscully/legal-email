<?php

namespace App\Filament\Resources;

use App\Enums\InviteeStatus;
use App\Filament\Imports\InviteeImporter;
use App\Filament\Resources\InviteeResource\Pages;
use App\Models\Invitee;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use UnitEnum;
use BackedEnum;

class InviteeResource extends Resource
{
    protected static ?string $model = Invitee::class;

    /**
     * Navigation icon for the resource. Filament's base `Resource` defines the
     * property as `BackedEnum|string|null`, so match that union here.
     *
     * @var BackedEnum|string|null
     */
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-users';

    /**
     * Navigation group for the resource. Filament's base `Resource` defines the
     * property as `UnitEnum|string|null`, so we must match that union to avoid
     * a property type mismatch error when booting the app.
     *
     * @var UnitEnum|string|null
     */
    protected static UnitEnum|string|null $navigationGroup = 'Invitations';

    public static function form(Schema $form): Schema
    {
        // Read-only resource - no form needed
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('first_name', $direction)
                            ->orderBy('last_name', $direction);
                    }),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('signup_code')
                    ->label('Signup Code')
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (InviteeStatus $state): string => match ($state) {
                        InviteeStatus::Pending => 'gray',
                        InviteeStatus::Sent => 'info',
                        InviteeStatus::Accepted => 'success',
                        InviteeStatus::Failed => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('sent_at')
                    ->label('Sent At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('accepted_at')
                    ->label('Accepted At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(InviteeStatus::class)
                    ->multiple(),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('mark_as_sent')
                        ->label('Mark as Sent')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('info')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each->markAsSent();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('mark_as_failed')
                        ->label('Mark as Failed')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each->markAsFailed();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('mark_as_pending')
                        ->label('Mark as Pending')
                        ->icon('heroicon-o-clock')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each->update(['status' => InviteeStatus::Pending]);
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(InviteeImporter::class),
            ])
            ->searchable();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvitees::route('/'),
            'view' => Pages\ViewInvitee::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
