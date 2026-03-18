<?php

namespace App\Filament\App\Widgets;

use App\Models\Link;
use App\Models\LinkClick;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    
    // protected function getStats(): array
    // {
    //     $user = auth()->user();

    //     $myLinkIds = Link::where('user_id', $user->id)->pluck('id');

    //     $totalClicks = LinkClick::whereIn('link_id', $myLinkIds)->count();

    //     $clicksToday = LinkClick::whereIn('link_id', $myLinkIds)
    //         ->whereDate('clicked_at', today())
    //         ->count();

    //     $totalLinks = $myLinkIds->count();
    //     $limit = $user->isPro() ? '∞' : '10';

    //     return [
    //         Stat::make('🔗 روابطي', $myLinkIds->count() . ' / ' . $limit)
    //             ->color($user->linksLimitReached() ? 'danger' : 'success')
    //             ->extraAttributes(['style' => 'text-align: center']),

    //         Stat::make('👆 إجمالي النقرات', $totalClicks)
    //             ->color('info')
    //             ->extraAttributes(['style' => 'text-align: center']),

    //         Stat::make('📅 نقرات اليوم', $clicksToday)
    //             ->color('warning')
    //             ->extraAttributes(['style' => 'text-align: center']),

    //         Stat::make('💎 الخطة', $user->isPro() ? 'Pro ✅' : 'Free')
    //             ->color($user->isPro() ? 'success' : 'gray')
    //             ->description($user->isPro() ? 'إدارة الاشتراك' : 'Upgrade للـ Pro')
    //             ->url($user->isPro() ? '/app/billing/portal' : '/app/billing/checkout')
    //             ->extraAttributes(['style' => 'text-align: center']),
    //     ];
    // }
    protected function getStats(): array
{
    $user = auth()->user();
    $myLinkIds = Link::where('user_id', $user->id)->pluck('id');
    $limit = $user->isPro() ? '∞' : '10';
    $totalClicks = LinkClick::whereIn('link_id', $myLinkIds)->count();
    $clicksToday = LinkClick::whereIn('link_id', $myLinkIds)
        ->whereDate('clicked_at', today())->count();

    return [
        Stat::make('🔗 My Links', $myLinkIds->count() . ' / ' . $limit)
            ->description('Number of links added')
            ->color($user->linksLimitReached() ? 'danger' : 'success'),

        Stat::make('👆 Total Clicks', $totalClicks)
            ->description('Total clicks across all links')
            ->color('info'),

        Stat::make('📅 Today', $clicksToday)
            ->description('Clicks since midnight')
            ->color('warning'),

        Stat::make('💎 Plan', $user->isPro() ? 'Pro ✅' : 'Free')
            ->description($user->isPro() ? 'Manage subscription' : 'Upgrade to Pro')
            ->url($user->isPro() ? '/app/billing/portal' : '/app/billing/checkout')
            ->color($user->isPro() ? 'success' : 'gray'),
    ];
}
}
