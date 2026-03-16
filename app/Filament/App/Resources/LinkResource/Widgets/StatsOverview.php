<?php

namespace App\Filament\App\Widgets;

use App\Models\Link;
use App\Models\LinkClick;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        $myLinkIds = Link::where('user_id', $user->id)->pluck('id');

        $totalClicks = LinkClick::whereIn('link_id', $myLinkIds)->count();

        $clicksToday = LinkClick::whereIn('link_id', $myLinkIds)
            ->whereDate('clicked_at', today())
            ->count();

        $totalLinks = $myLinkIds->count();
        $limit = $user->isPro() ? '∞' : '10';

        return [
            Stat::make('🔗 روابطي', "{$totalLinks} / {$limit}")
                ->color($user->linksLimitReached() ? 'danger' : 'success'),

            Stat::make('👆 إجمالي النقرات', $totalClicks)
                ->color('info'),

            Stat::make('📅 نقرات اليوم', $clicksToday)
                ->color('warning'),

            Stat::make('💎 الخطة', $user->isPro() ? 'Pro ✅' : 'Free')
                ->color($user->isPro() ? 'success' : 'gray')
                ->description($user->isPro() ? 'إدارة الاشتراك' : '⚡ Upgrade للـ Pro')
                ->url($user->isPro() ? '/app/billing/portal' : '/app/billing/checkout'),
        ];
    }
}
