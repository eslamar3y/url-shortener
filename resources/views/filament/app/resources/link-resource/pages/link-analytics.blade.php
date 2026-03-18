<x-filament-panels::page>
<div class="space-y-6">

    {{-- Header --}}
<x-filament::section>
    <div class="space-y-3">
        <div class="flex items-start justify-between gap-4">
            <h2 class="text-xl font-bold">{{ $record->title ?? $record->short_code }}</h2>
            <x-filament::badge color="{{ $record->is_active ? 'success' : 'danger' }}" class="shrink-0">
                {{ $record->is_active ? 'Activated' : 'Deactivated' }}
            </x-filament::badge>
        </div>
        <div class="space-y-2 overflow-hidden">
            <div class="overflow-hidden">
                <p class="text-xs text-gray-500 mb-1">Original URL:</p>
                <p class="text-sm text-gray-400" style="word-break: break-all; overflow-wrap: anywhere;">
                    {{ $record->original_url }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Short URL:</p>
                <p class="text-sm text-primary-400" style="word-break: break-all; overflow-wrap: anywhere;">
                    {{ url('/r/' . $record->short_code) }}
                </p>
            </div>
        </div>
    </div>
</x-filament::section>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-center">
        <x-filament::section>
            <p class="text-3xl font-bold text-primary-500">{{ $totalClicks }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Clicks</p>
        </x-filament::section>
        <x-filament::section>
            <p class="text-3xl font-bold text-success-500">{{ $clicksToday }}</p>
            <p class="text-sm text-gray-500 mt-1">Today</p>
        </x-filament::section>
        <x-filament::section>
            <p class="text-3xl font-bold text-info-500">{{ $clicksThisWeek }}</p>
            <p class="text-sm text-gray-500 mt-1">This Week</p>
        </x-filament::section>
        <x-filament::section>
            <p class="text-3xl font-bold text-warning-500">{{ $clicksThisMonth }}</p>
            <p class="text-sm text-gray-500 mt-1">This Month</p>
        </x-filament::section>
    </div>

    {{-- Chart آخر 7 أيام --}}
    {{-- Chart آخر 7 أيام --}}
<x-filament::section heading="📈 Last 7 Days">
    @php $maxCount = max(array_column($byDay, 'count') ?: [1]); @endphp
    <div class="flex items-end gap-2" style="height: 180px;">
        @foreach($byDay as $day)
            @php $barHeight = $maxCount > 0 ? max(($day['count'] / $maxCount) * 120, $day['count'] > 0 ? 20 : 4) : 4; @endphp
            <div class="flex-1 flex flex-col items-center justify-end gap-1" style="height: 180px;">
                {{-- العدد --}}
                <span style="font-size: 11px; color: #9ca3af;">{{ $day['count'] }}</span>
                {{-- الـ Bar --}}
                <div style="
                    width: 100%;
                    height: {{ $barHeight }}px;
                    background-color: {{ $day['count'] > 0 ? '#f59e0b' : '#374151' }};
                    border-radius: 4px 4px 0 0;
                    min-height: 4px;
                "></div>
                {{-- التاريخ --}}
                <div style="text-align: center; height: 36px; display: flex; flex-direction: column; justify-content: center;">
                    <span style="font-size: 10px; color: #6b7280; display: block; line-height: 1.4;">
                        {{ explode(' ', $day['date'])[0] }}
                    </span>
                    <span style="font-size: 10px; color: #6b7280; display: block; line-height: 1.4;">
                        {{ explode(' ', $day['date'])[1] }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</x-filament::section>

    {{-- Device + Browser + Country --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        <x-filament::section heading="📱 Devices">
            @forelse($byDevice as $device => $count)
                <div class="flex justify-between items-center py-2 border-b border-gray-700 last:border-0">
                    <span class="capitalize text-sm">{{ $device ?? 'Unknown' }}</span>
                    <x-filament::badge color="primary">{{ $count }}</x-filament::badge>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No data available</p>
            @endforelse
        </x-filament::section>

        <x-filament::section heading="🌐 Browsers">
            @forelse($byBrowser as $browser => $count)
                <div class="flex justify-between items-center py-2 border-b border-gray-700 last:border-0">
                    <span class="text-sm">{{ $browser ?? 'Unknown' }}</span>
                    <x-filament::badge color="info">{{ $count }}</x-filament::badge>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No data available</p>
            @endforelse
        </x-filament::section>

        <x-filament::section heading="🌍 countries">
            @forelse($byCountry as $country => $count)
                <div class="flex justify-between items-center py-2 border-b border-gray-700 last:border-0">
                    <span class="text-sm">{{ $country ?? 'Unknown' }}</span>
                    <x-filament::badge color="success">{{ $count }}</x-filament::badge>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No data available</p>
            @endforelse
        </x-filament::section>

    </div>

</div>
</x-filament-panels::page>