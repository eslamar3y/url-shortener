<?php

namespace App\Filament\App\Resources;

use App\Models\Link;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Filament\App\Resources\LinkResource\Pages;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;
    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationLabel = 'روابطي';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('original_url')
                ->label('الرابط الأصلي')
                ->url()
                ->required()
                ->placeholder('https://example.com/very-long-url'),

            Forms\Components\TextInput::make('title')
                ->label('اسم الرابط')
                ->placeholder('مثال: موقعي الشخصي'),

            Forms\Components\TextInput::make('short_code')
                ->label('الكود المختصر')
                ->unique(ignoreRecord: true)
                ->maxLength(50)
                ->rules(['max:50', 'alpha_num'])
                ->placeholder('يتولد أوتوماتيك لو تركته فاضي')
                ->helperText('حروف وأرقام بس، 50 حرف كحد أقصى'),

            Forms\Components\DateTimePicker::make('expires_at')
                ->label('تاريخ الانتهاء')
                ->helperText('اتركه فاضي لو مش عايز ينتهي'),

            Forms\Components\Toggle::make('is_active')
                ->label('مفعّل؟')
                ->default(true),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('الاسم')
                    ->default('بدون اسم')
                    ->searchable(),

                Tables\Columns\TextColumn::make('short_code')
                    ->label('الرابط القصير')
                    ->badge()
                    ->copyable()
                    ->copyMessage('تم النسخ!')
                    ->copyableState(fn($state) => url('/r/' . $state))
                    ->formatStateUsing(fn($state) => url('/r/' . $state)),

                Tables\Columns\TextColumn::make('total_clicks')
                    ->label('النقرات')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('clicks_today')
                    ->label('اليوم')
                    ->badge()
                    ->color('info'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('مفعّل')
                    ->boolean(),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('ينتهي')
                    ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->format('Y-m-d') : 'لا ينتهي')
                    ->badge()
                    ->color(fn($state) => $state ? 'warning' : 'gray'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('analytics')
                    ->label('إحصائيات')
                    ->icon('heroicon-o-chart-bar')
                    ->url(fn($record) => LinkResource::getUrl('analytics', ['record' => $record])),
            ])
            ->emptyStateHeading('لا توجد روابط بعد')
            ->emptyStateDescription('ابدأ بإضافة رابطك الأول!')
            ->emptyStateActions([
                Tables\Actions\Action::make('create')
                    ->label('+ أضف رابط')
                    ->url(LinkResource::getUrl('create')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'edit'   => Pages\EditLink::route('/{record}/edit'),
            'analytics' => Pages\LinkAnalytics::route('/{record}/analytics'),
        ];
    }
}
