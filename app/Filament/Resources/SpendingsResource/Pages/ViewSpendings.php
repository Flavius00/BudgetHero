<?php

namespace App\Filament\Resources\SpendingsResource\Pages;

use App\Filament\Resources\SpendingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSpendings extends ViewRecord
{
    protected static string $resource = SpendingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
