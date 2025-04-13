<?php

namespace App\Filament\Resources\CsvSaveResource\Pages;

use App\Filament\Resources\CsvSaveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCsvSave extends EditRecord
{
    protected static string $resource = CsvSaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
