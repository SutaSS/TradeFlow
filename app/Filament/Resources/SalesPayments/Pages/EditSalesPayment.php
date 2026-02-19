<?php

namespace App\Filament\Resources\SalesPayments\Pages;

use App\Filament\Resources\SalesPayments\SalesPaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSalesPayment extends EditRecord
{
    protected static string $resource = SalesPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
