<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class Courses extends ListRecords
{
    protected static string $resource = CourseResource::class;
}
