<?php

namespace App\Filament\Resources\VietnameseRegistrationResource\Pages;

use App\Filament\Resources\VietnameseRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVietnameseRegistration extends EditRecord
{
    protected static string $resource = VietnameseRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
