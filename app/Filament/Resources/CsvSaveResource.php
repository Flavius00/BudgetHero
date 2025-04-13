<?php
namespace App\Filament\Resources;

use App\Filament\Resources\CsvSaveResource\Pages;
use App\Filament\Resources\CsvSaveResource\RelationManagers;
use App\Models\CsvSave;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CsvSaveResource extends Resource
{
    protected static ?string $model = CsvSave::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';
    protected static ?string $navigationLabel = 'Analysis';
    protected static ?string $pluralModelLabel = 'Analysis';
    protected static ?string $modelLabel = 'Analysis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([/* Form schema here */]);
    }

    public static function table(Table $table): Table
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $year = 2025; // Dynamically set year
        $month = 4;   // Dynamically set month

        // Retrieve spendings grouped by category for the specified year and month
        $spendingsByCategory = CsvSave::whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->where('is_income', 0)
            ->with('store') // Ensure related store is eager-loaded
            ->get()
            ->groupBy(function ($csvSave) {
                return $csvSave->store->category; // Group by store category
            })
            ->map(function ($group) {
                // Sum the total spendings per category
                return $group->sum('amount');
            });

        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('transaction_date')->dateTime(),
                TextColumn::make('store.name')->label('Store Name'),
                TextColumn::make('amount'),
                TextColumn::make('is_income'),
                // TextColumn::make('created_at')->dateTime(),
                // TextColumn::make('updated_at')->dateTime(),
                // TextColumn::make('category')->label('Category'),
                TextColumn::make('total_spent')->label('Estimated Spendings This Month')
                    ->getStateUsing(function($record) use ($spendingsByCategory) {
                        // Get the total spending for the store's category
                        $category = $record->store->category;
                        return $spendingsByCategory->get($category, 0); // Default to 0 if category is not found
                    }),
            ])
            ->filters([
                Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Start Date'),
                        Forms\Components\DatePicker::make('until')->label('End Date'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('transaction_date', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('transaction_date', '<=', $data['until']));
                    }),
            ]);
    }


    public static function getRelations(): array
    {
        return [/* Relations here */];
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

    public static function getCategorySpendings(int $year = null, int $month = null): array
{
    $year = $year ?? now()->year;
    $month = $month ?? now()->month;

    return CsvSave::whereYear('transaction_date', $year)
        ->whereMonth('transaction_date', $month)
        ->where('is_income', 0)
        ->with('store')
        ->get()
        ->groupBy(fn($csvSave) => $csvSave->store->category)
        ->map(fn($group) => [
            'category' => $group->first()->store->category,
            'total_spent' => $group->sum('amount'),
        ])
        ->values()
        ->toArray();
}

}
