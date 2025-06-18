<?php

namespace App\Filament\Resources\VietnameseRegistrationResource\Pages;

use App\Filament\Resources\VietnameseRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVietnameseRegistrations extends ListRecords
{
    protected static string $resource = VietnameseRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
