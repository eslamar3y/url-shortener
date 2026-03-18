<?php

namespace App\Filament\Admin\Resources;

use App\Models\Link;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\LinkResource\Pages;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;
    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationLabel = 'All Links';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('original_url')
                ->label('Original URL')
                ->url()
                ->required(),

            Forms\Components\TextInput::make('short_code')
                ->label('Short Code')
                ->required(),

            Forms\Components\Select::make('user_id')
                ->label('User')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Toggle::make('is_active')
                ->label('Activated?')
                ->default(true),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->default('—'),

                Tables\Columns\TextColumn::make('short_code')
                    ->label('Short Code')
                    ->badge()
                    ->copyable()
                    ->copyableState(fn($state) => url('/r/' . $state)),

                Tables\Columns\TextColumn::make('clicks_count')
                    ->label('Total Clicks')
                    ->counts('clicks')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activated')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creation Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Activated',
                        '0' => 'Deactivated',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'edit'   => Pages\EditLink::route('/{record}/edit'),
        ];
    }
}