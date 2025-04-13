<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Courses';
    protected static ?string $pluralModelLabel = 'Courses';
    protected static ?string $modelLabel = 'Course';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Course Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Start Date')
                    ->required(),

                Forms\Components\DateTimePicker::make('end_date')
                    ->label('End Date')
                    ->required(),

                Forms\Components\TextInput::make('path')
                    ->label('Course Path')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('quiz_path')
                    ->label('Quiz Path')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Course Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->dateTime('d.m.Y H:i'),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->dateTime('d.m.Y H:i'),

                Tables\Columns\TextColumn::make('path')
                    ->label('Material'),

                Tables\Columns\TextColumn::make('quiz_path')
                    ->label('Quiz'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created at')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                // Adaugă filtre dacă vrei, ex. după dată
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
            // Dacă ai relații, le pui aici
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'view' => Pages\ViewCourse::route('/{record}'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
