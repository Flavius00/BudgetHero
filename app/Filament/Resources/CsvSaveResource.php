<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CsvSaveResource\Pages;
use App\Filament\Resources\CsvSaveResource\RelationManagers;
use App\Models\CsvSave;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Store;

class CsvSaveResource extends Resource
{
    protected static ?string $model = CsvSave::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('transaction_date')->dateTime(),
            Tables\Columns\TextColumn::make('store_id'),
            Tables\Columns\TextColumn::make('amount'),
            Tables\Columns\TextColumn::make('is_income'),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
            Tables\Columns\TextColumn::make('updated_at')->dateTime(),
        ])
        ->filters([
            //
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
            'index' => Pages\ListCsvSaves::route('/'),
            'create' => Pages\CreateCsvSave::route('/create'),
            'view' => Pages\ViewCsvSave::route('/{record}'),
            'edit' => Pages\EditCsvSave::route('/{record}/edit'),
        ];
    }

    public function store()
    {
        return $this->belongsTo(Store::class); // or ->belongsTo(Store::class, 'store_id') if column name differs
    }
}
