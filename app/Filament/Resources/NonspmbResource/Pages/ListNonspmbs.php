<?php

namespace App\Filament\Resources\NonspmbResource\Pages;

use App\Filament\Resources\NonspmbResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
class ListNonspmbs extends ListRecords
{
    protected static string $resource = NonspmbResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah PD Non SPMB'),
            ExportAction::make('export'),
        ];
    }
}
