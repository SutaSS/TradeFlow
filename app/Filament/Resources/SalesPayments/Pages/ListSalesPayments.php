<?php

namespace App\Filament\Resources\SalesPayments\Pages;

use App\Filament\Resources\SalesPayments\SalesPaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSalesPayments extends ListRecords
{
    protected static string $resource = SalesPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
