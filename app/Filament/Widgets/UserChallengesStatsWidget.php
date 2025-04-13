<?php

namespace App\Filament\Widgets;

use App\Models\Challenge;
use App\Models\User_Challenge;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class UserChallengesStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $userId = Auth::id();
        $totalChallenges = Challenge::count();
        $completedChallenges = User_Challenge::where('user_id', $userId)->count();
        $completionPercentage = $totalChallenges > 0
            ? round(($completedChallenges / $totalChallenges) * 100)
            : 0;

        $recentChallenges = User_Challenge::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->first();

        $latestChallengeName = null;
        if ($recentChallenges) {
            $latestChallenge = Challenge::find($recentChallenges->challenge_id);
            $latestChallengeName = $latestChallenge ? $latestChallenge->name : null;
        }

        return [
            Stat::make('Completed Challenges', $completedChallenges)
                ->description($completedChallenges > 0 ? 'Great job!' : 'Start completing challenges!')
                ->descriptionIcon($completedChallenges > 0 ? 'heroicon-o-check-badge' : 'heroicon-o-flag')
                ->color('success'),

            Stat::make('Completion Rate', $completionPercentage . '%')
                ->description($totalChallenges > 0 ? $completedChallenges . ' of ' . $totalChallenges . ' challenges completed' : 'No challenges available')
                ->color($completionPercentage >= 50 ? 'success' : ($completionPercentage > 0 ? 'warning' : 'danger'))
                ->chart([0, min(25, $completionPercentage), min(50, $completionPercentage), min(75, $completionPercentage), min(100, $completionPercentage)]),

            Stat::make('Latest Achievement', $latestChallengeName ?? 'None yet')
                ->description($latestChallengeName
                    ? 'Completed on ' . ($recentChallenges ? $recentChallenges->created_at->format('d.m.Y') : 'Unknown')
                    : 'Complete a challenge to see it here')
                ->color($latestChallengeName ? 'primary' : 'gray'),
        ];
    }
}
