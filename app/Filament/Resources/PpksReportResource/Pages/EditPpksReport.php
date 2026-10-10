<?php

namespace App\Filament\Resources\PpksReportResource\Pages;

use App\Filament\Resources\PpksReportResource;
use Filament\Resources\Pages\EditRecord;

class EditPpksReport extends EditRecord
{
    protected static string $resource = PpksReportResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return array_intersect_key($data, array_flip(['status', 'response']));
    }
}
