<?php

namespace App\Filament\Resources\NonspmbResource\Pages;

use App\Filament\Resources\NonspmbResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNonspmb extends EditRecord
{
    protected static string $resource = NonspmbResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
