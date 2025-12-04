<?php

namespace App\Filament\Imports;

use App\Enums\InviteeStatus;
use App\Models\Invitee;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class InviteeImporter extends Importer
{
    protected static ?string $model = Invitee::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('signup_code')
                ->requiredMapping()
                ->rules(['required', 'max:255', 'unique:invitees,signup_code']),
            ImportColumn::make('first_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('last_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255', 'unique:invitees,email']),
        ];
    }

    public function resolveRecord(): ?Invitee
    {
        return new Invitee([
            'status' => InviteeStatus::Pending,
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your invitee import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }



    /**
     * Filament Importer expects a method named `getExampleRows` (depending on Filament version).
     * Provide the example rows under that canonical name. Keep `getExampleCsvData`
     * for backward compatibility (it delegates to this method).
     *
     * Each row is an associative array with keys: `signup_code`, `first_name`,
     * `last_name`, and `email`.
     *
     * NOTE: This importer includes unique validation rules against the database
     * for `signup_code` and `email`. Intra-file duplicate detection (duplicates
     * within the same uploaded CSV) is NOT enforced by default here. If you need
     * to detect duplicates inside the uploaded file before attempting DB
     * insertion, you can extend this class to track seen values per-import and
     * add a custom validation rule. Example (conceptual):
     *
     * protected static array $seenSignupCodes = [];
     * protected static array $seenEmails = [];
     *
     * // In a validation closure for the 'signup_code' column:
     * function ($attribute, $value, $fail) {
     *     if (in_array($value, self::$seenSignupCodes, true)) {
     *         $fail('Duplicate signup_code in uploaded file.');
     *     }
     *     self::$seenSignupCodes[] = $value;
     * }
     *
     * Be sure to reset the "seen" arrays at the start of each import. Depending
     * on Filament's importer lifecycle hooks you may implement a hook like
     * `beforeImport()` to clear them. Alternatively, rely on database unique
     * constraints (and the existing `unique:invitees,...` rules) to detect
     * conflicts with existing records.
     */
    public static function getExampleRows(): array
    {
        return [
            ['signup_code' => 'ABC123', 'first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john.doe@example.com'],
            ['signup_code' => 'XYZ789', 'first_name' => 'Jane', 'last_name' => 'Smith', 'email' => 'jane.smith@example.com'],
            ['signup_code' => 'DEF456', 'first_name' => 'Bob', 'last_name' => 'Johnson', 'email' => 'bob.johnson@example.com'],
        ];
    }

    // Backwards-compatible alias for older Filament versions/plugins that expect
    // `getExampleCsvData`.
    public static function getExampleCsvData(): array
    {
        return self::getExampleRows();
    }
}
