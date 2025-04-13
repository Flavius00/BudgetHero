<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserChallengeResource\Pages;
use App\Models\User_Challenge;
use App\Models\User;
use App\Models\Challenge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserChallengeResource extends Resource
{
    protected static ?string $model = User_Challenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'User Challenges';
    protected static ?string $pluralModelLabel = 'User Challenges';
    protected static ?string $modelLabel = 'User Challenge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required(),

                Forms\Components\Select::make('challenge_id')
                    ->label('Challenge')
                    ->options(Challenge::all()->pluck('name', 'id'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('challenge.name')
                    ->label('Challenge')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserChallenges::route('/'),
            'create' => Pages\CreateUserChallenge::route('/create'),
            'view' => Pages\ViewUserChallenge::route('/{record}'),
            'edit' => Pages\EditUserChallenge::route('/{record}/edit'),
        ];
    }
}
