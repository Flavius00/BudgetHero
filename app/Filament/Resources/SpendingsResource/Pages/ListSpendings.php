<?php

namespace App\Filament\Resources\SpendingsResource\Pages;

use App\Filament\Resources\SpendingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpendings extends ListRecords
{
    protected static string $resource = SpendingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
