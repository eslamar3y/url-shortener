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
            Stat::make('👥 إجمالي المستخدمين', User::count())
                ->description('Pro: ' . User::whereHas('subscriptions', fn($q) => $q->where('stripe_status', 'active'))->count())
                ->color('info'),

            Stat::make('🔗 إجمالي الروابط', Link::count())
                ->description('اليوم: ' . Link::whereDate('created_at', today())->count())
                ->color('success'),

            Stat::make('👆 إجمالي النقرات', LinkClick::count())
                ->description('اليوم: ' . LinkClick::whereDate('clicked_at', today())->count())
                ->color('warning'),

            Stat::make('💰 المشتركين Pro',
                User::whereHas('subscriptions', fn($q) => $q->where('stripe_status', 'active'))->count())
                ->color('danger'),
        ];
    }
}