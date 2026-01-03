<?php

namespace App\Filament\Resources\ScheduledTransactionResource\Pages;

use App\Filament\Resources\ScheduledTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageScheduledTransactions extends ManageRecords
{
    protected static string $resource = ScheduledTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
