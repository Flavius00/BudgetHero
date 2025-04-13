<?php

namespace App\Filament\Resources\SpendingsResource\Pages;

use App\Filament\Resources\SpendingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpendings extends EditRecord
{
    protected static string $resource = SpendingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
