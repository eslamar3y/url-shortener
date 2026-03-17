<?php

namespace App\Filament\App\Resources\LinkResource\Pages;

use App\Filament\App\Resources\LinkResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateLink extends CreateRecord
{
    protected static string $resource = LinkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // لو مكتبش short_code، يتولد أوتوماتيك
        if (empty($data['short_code'])) {
            $data['short_code'] = Str::random(6);
        }

        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function mount(): void
{
    $user = auth()->user();

    if ($user->linksLimitReached()) {
        \Filament\Notifications\Notification::make()
            ->title('وصلت للحد المجاني!')
            ->body('اشترك في Pro عشان تضيف روابط غير محدودة.')
            ->warning()
            ->persistent()
            ->actions([
                \Filament\Notifications\Actions\Action::make('upgrade')
                    ->label('Upgrade to Pro')
                    ->url('/app/billing/checkout'),
            ])
            ->send();

        $this->redirect(LinkResource::getUrl('index'));
    }

    parent::mount();
}
}