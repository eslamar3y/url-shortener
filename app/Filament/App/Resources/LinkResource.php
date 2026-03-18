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
    protected static ?string $navigationLabel = 'My Links';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('original_url')
                ->label('Original URL')
                ->url()
                ->required()
                ->placeholder('https://example.com/very-long-url'),

            Forms\Components\TextInput::make('title')
                ->label('Title')
                ->placeholder('Example: My Personal Website'),

            Forms\Components\TextInput::make('short_code')
                ->label('Short Code')
                ->unique(ignoreRecord: true)
                ->maxLength(50)
                ->rules(['max:50', 'alpha_num'])
                ->placeholder('Will be generated automatically if left empty')
                ->helperText('Letters and numbers only, up to 50 characters'),

            Forms\Components\DateTimePicker::make('expires_at')
                ->label('Expiration Date')
                ->helperText('Leave empty if you don\'t want it to expire'),

            Forms\Components\Toggle::make('is_active')
                ->label('Activated?')
                ->default(true),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->default('No Title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('short_code')
                    ->label('Short Code')
                    ->badge()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->copyableState(fn($state) => url('/r/' . $state))
                    ->formatStateUsing(fn($state) => url('/r/' . $state)),

                Tables\Columns\TextColumn::make('total_clicks')
                    ->label('Total Clicks')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('clicks_today')
                    ->label('Today')
                    ->badge()
                    ->color('info'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activated')
                    ->boolean(),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->format('Y-m-d') : 'Never')
                    ->badge()
                    ->color(fn($state) => $state ? 'warning' : 'gray'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('analytics')
                    ->label('Analytics')
                    ->icon('heroicon-o-chart-bar')
                    ->url(fn($record) => LinkResource::getUrl('analytics', ['record' => $record])),
            ])
            ->emptyStateHeading('No links yet')
            ->emptyStateDescription('Get started by creating your first link!')
            ->emptyStateActions([
                Tables\Actions\Action::make('create')
                    ->label('+ Create Link')
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
