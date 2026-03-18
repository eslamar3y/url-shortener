<?php

namespace App\Filament\App\Resources\LinkResource\Pages;

use App\Filament\App\Resources\LinkResource;
use App\Models\LinkClick;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;

class LinkAnalytics extends Page
{
    protected static string $resource = LinkResource::class;
    protected static string $view = 'filament.app.resources.link-resource.pages.link-analytics';

    public $record;
    public $totalClicks;
    public $clicksToday;
    public $clicksThisWeek;
    public $clicksThisMonth;
    public $byDevice;
    public $byBrowser;
    public $byCountry;
    public $byDay;

    public function mount(int|string $record): void
    {
        $this->record = \App\Models\Link::findOrFail($record);

        // تأكد إن الرابط تبع المستخدم الحالي
        abort_if($this->record->user_id !== auth()->id(), 403);

        $clicks = LinkClick::where('link_id', $this->record->id);

        $this->totalClicks      = $clicks->count();
        $this->clicksToday      = (clone $clicks)->whereDate('clicked_at', today())->count();
        $this->clicksThisWeek   = (clone $clicks)->whereBetween('clicked_at', [now()->startOfWeek(), now()])->count();
        $this->clicksThisMonth  = (clone $clicks)->whereMonth('clicked_at', now()->month)->count();

        // حسب الجهاز
        $this->byDevice = (clone $clicks)
            ->selectRaw('device, count(*) as count')
            ->groupBy('device')
            ->pluck('count', 'device')
            ->toArray();

        // حسب المتصفح
        $this->byBrowser = (clone $clicks)
            ->selectRaw('browser, count(*) as count')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->pluck('count', 'browser')
            ->toArray();

        // حسب الدولة
        $this->byCountry = (clone $clicks)
            ->selectRaw('country, count(*) as count')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'country')
            ->toArray();

        // آخر 7 أيام
        $this->byDay = collect(range(6, 0))->map(function ($daysAgo) use ($clicks) {
            $date = now()->subDays($daysAgo);
            return [
                'date'  => $date->format('M d'),
                'count' => (clone $clicks)->whereDate('clicked_at', $date)->count(),
            ];
        })->toArray();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to Links')
                ->icon('heroicon-o-arrow-right')
                ->url(LinkResource::getUrl('index')),
        ];
    }
}
