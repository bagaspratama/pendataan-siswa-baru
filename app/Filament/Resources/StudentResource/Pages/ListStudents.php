<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah PD'),
            ExportAction::make('export'),
        ];
    }
}
