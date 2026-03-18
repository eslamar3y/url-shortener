<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Link;
use App\Models\LinkClick;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('👥 Total Users', User::count())
                ->description('Pro: ' . User::whereHas('subscriptions', fn($q) => $q->where('stripe_status', 'active'))->count())
                ->color('info'),

            Stat::make('🔗 Total Links', Link::count())
                ->description('Today: ' . Link::whereDate('created_at', today())->count())
                ->color('success'),

            Stat::make('👆 Total Clicks', LinkClick::count())
                ->description('Today: ' . LinkClick::whereDate('clicked_at', today())->count())
                ->color('warning'),

            Stat::make('💰 Pro Subscribers',
                User::whereHas('subscriptions', fn($q) => $q->where('stripe_status', 'active'))->count())
                ->color('danger'),
        ];
    }
}