<?php

namespace App\Filament\Resources\UserChallengeResource\Pages;

use App\Filament\Resources\UserChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserChallenge extends ViewRecord
{
    protected static string $resource = UserChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
