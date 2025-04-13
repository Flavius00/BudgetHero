<?php

namespace App\Filament\Pages;

use App\Models\Challenge;
use App\Models\User_Challenge;
use Filament\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Infolist;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Widgets\UserChallengesStatsWidget;
use Illuminate\Support\Facades\Storage;

class MyCompletedChallenges extends Page
{
    use InteractsWithInfolists;

    protected static string $view = 'filament.pages.my-completed-challenges';

    protected function getHeaderWidgets(): array
    {
        return [
            UserChallengesStatsWidget::class,
        ];
    }

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationLabel = 'My Challenges';
    protected static ?string $title = 'My Completed Challenges';
    protected static ?int $navigationSort = 3;

    public ?string $filter = 'all';
    public ?string $sortOrder = 'latest';

    protected function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\Select::make('filter')
                ->label('Filter')
                ->options([
                    'all' => 'All Challenges',
                    'recent' => 'Recent (Last 30 days)',
                ])
                ->default('all')
                ->live(),

            \Filament\Forms\Components\Select::make('sortOrder')
                ->label('Sort By')
                ->options([
                    'latest' => 'Latest First',
                    'oldest' => 'Oldest First',
                    'name_asc' => 'Name (A-Z)',
                    'name_desc' => 'Name (Z-A)',
                ])
                ->default('latest')
                ->live(),
        ];
    }

    public function completedChallengesInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record(Auth::user())
            ->schema([
                \Filament\Infolists\Components\Actions::make([
                    \Filament\Infolists\Components\Actions\Action::make('clear_filter')
                        ->label('Reset Filters')
                        ->icon('heroicon-o-arrow-path')
                        ->visible(fn() => $this->filter !== 'all' || $this->sortOrder !== 'latest')
                        ->action(function () {
                            $this->filter = 'all';
                            $this->sortOrder = 'latest';
                        }),
                ]),

                Section::make('My Completed Challenges')
                    ->description('Challenges you have successfully completed')
                    ->icon('heroicon-o-trophy')
                    ->collapsible()
                    ->persistCollapsed(false)
                    ->schema([
                        Grid::make(3)
                            ->schema($this->getChallengeCards()),
                    ]),

                $this->getSuggestedChallengesSection(),
            ]);
    }

    protected function getChallengeCards(): array
    {
        $userId = Auth::id();
        $query = User_Challenge::where('user_id', $userId);

        // Aplicăm filtrele
        if ($this->filter === 'recent') {
            $query->where('created_at', '>=', now()->subDays(30));
        }

        $userChallenges = $query->get();

        if ($userChallenges->isEmpty()) {
            return [
                TextEntry::make('no_challenges')
                    ->state('You have not completed any challenges yet. Complete activities to earn badges!')
                    ->columnSpanFull()
                    ->size('lg')
                    ->extraAttributes(['class' => 'text-center py-8']),
            ];
        }

        $challengeIds = $userChallenges->pluck('challenge_id');
        $challenges = Challenge::whereIn('id', $challengeIds);

        // Aplicăm sortarea
        switch ($this->sortOrder) {
            case 'oldest':
                $challenges = $challenges->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $challenges = $challenges->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $challenges = $challenges->orderBy('name', 'desc');
                break;
            default: // latest
                $challenges = $challenges->orderBy('created_at', 'desc');
                break;
        }

        $challenges = $challenges->get();

        $cards = [];

        foreach ($challenges as $challenge) {
            $cards[] = Section::make($challenge->name)
                ->description($challenge->description)
                ->icon('heroicon-o-check-badge')
                ->extraAttributes([
                    'class' => 'border border-primary-500 rounded-xl shadow-md hover:shadow-lg transition',
                ])
                ->schema([
                    Grid::make()
                        ->schema([
                            TextEntry::make('completed_at')
                                ->hiddenLabel()
                                ->formatStateUsing(function () use ($userId, $challenge) {
                                    $completed = User_Challenge::where('user_id', $userId)
                                        ->where('challenge_id', $challenge->id)
                                        ->first();

                                    return 'Completed on: ' . ($completed ? $completed->created_at->format('d.m.Y') : 'Unknown');
                                })
                                ->weight(FontWeight::Bold)
                                ->color('success')
                                ->icon('heroicon-o-calendar')
                                ->iconPosition(IconPosition::Before),
                        ]),
                ]);
        }

        // Verificăm dacă array-ul de carduri este gol - acest lucru este acum gestionat la începutul funcției

        return $cards;
    }

    protected function getSuggestedChallengesSection(): Section
    {
        $userId = Auth::id();
        $completedChallengeIds = User_Challenge::where('user_id', $userId)->pluck('challenge_id');
        $suggestedChallenges = Challenge::whereNotIn('id', $completedChallengeIds)->limit(3)->get();

        $suggestions = [];

        foreach ($suggestedChallenges as $challenge) {
            $suggestions[] = TextEntry::make('challenge_' . $challenge->id)
                ->label($challenge->name)
                ->state($challenge->description)
                ->color('gray')
                ->icon('heroicon-o-trophy');
        }

        if (empty($suggestions)) {
            $suggestions[] = TextEntry::make('all_completed')
                ->state('Congratulations! You have completed all available challenges!')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->size('lg');
        }

        return Section::make('Suggested Challenges')
            ->description('Complete these challenges to earn more badges')
            ->icon('heroicon-o-sparkles')
            ->collapsible()
            ->persistCollapsed(false)
            ->hidden(function () {
                return $this->filter === 'all' ? false : true;
            })
            ->schema($suggestions);
    }
}
