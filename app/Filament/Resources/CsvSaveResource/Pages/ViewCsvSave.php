<?php

namespace App\Filament\Resources\CsvSaveResource\Pages;

use App\Filament\Resources\CsvSaveResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCsvSave extends ViewRecord
{
    protected static string $resource = CsvSaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
