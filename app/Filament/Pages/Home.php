<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Home extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Home';
    protected static ?string $slug = 'home';
    protected static string $view = 'filament.pages.home';

}
