<?php

namespace App\Filament\Resources\DeliveryOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeliveryOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('do_id')
                    ->label('DO #')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('do_date')
                    ->label('Delivery Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('salesOrder.so_id')
                    ->label('SO #')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('salesOrder.customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('deliveredBy.name')
                    ->label('Delivered By')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
