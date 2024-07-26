<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Imports\UserImport;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExportAction::make()->exports([
                ExcelExport::make()->withColumns([
                    Column::make('name')->heading(__('Nama Karyawan')),
                    Column::make('username')->heading(__('Kode Karyawan / Username')),
                    Column::make('roles')->heading(__('Jenis Karyawan'))
                        ->formatStateUsing(fn ($record) => $record->roles->pluck('name')->join(',')),
                ])
                    ->withFilename(fn ($resource) => $resource::getLabel()),
            ]),
            ExcelImportAction::make()
                ->icon('heroicon-o-arrow-up-tray')
                ->use(UserImport::class),
        ];
    }
}
