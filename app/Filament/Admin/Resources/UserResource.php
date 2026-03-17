<?php

namespace App\Filament\Admin\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'المستخدمين';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('الاسم')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('الإيميل')
                ->email()
                ->required(),

            Forms\Components\Select::make('role')
                ->label('الدور')
                ->options([
                    'admin' => 'Admin',
                    'user'  => 'User',
                ])
                ->required(),

            Forms\Components\TextInput::make('password')
                ->label('كلمة المرور')
                ->password()
                ->dehydrateStateUsing(fn($state) => bcrypt($state))
                ->dehydrated(fn($state) => filled($state))
                ->required(fn(string $context) => $context === 'create'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('الإيميل')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('role')
                    ->label('الدور')
                    ->colors([
                        'danger'  => 'admin',
                        'success' => 'user',
                    ]),

                Tables\Columns\IconColumn::make('is_pro')
                    ->label('Pro؟')
                    ->boolean()
                    ->getStateUsing(fn($record) => $record->isPro()),

                Tables\Columns\TextColumn::make('links_count')
                    ->label('الروابط')
                    ->counts('links')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التسجيل')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options(['admin' => 'Admin', 'user' => 'User']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}