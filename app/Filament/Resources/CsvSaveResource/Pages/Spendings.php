<?php

namespace App\Filament\Resources\CsvSaveResource\Pages;

use App\Filament\Resources\CsvSaveResource;
use Filament\Resources\Pages\Page;

class Spendings extends Page
{
    protected static string $resource = CsvSaveResource::class;

    protected static string $view = 'filament.resources.csv-save-resource.pages.spendings';
}
