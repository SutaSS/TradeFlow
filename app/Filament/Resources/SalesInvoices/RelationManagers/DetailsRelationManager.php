<?php

namespace App\Filament\Resources\SalesInvoices\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($get, $set, $state) {
                        $product = \App\Models\Product::find($state);
                        if ($product) {
                            $set('price', $product->price);
                            $qty = $get('qty') ?? 1;
                            $discount = $get('discount') ?? 0;
                            $set('total_price', ($product->price * $qty) - $discount);
                        }
                    }),
                TextInput::make('qty')
                    ->label('Quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->live()
                    ->afterStateUpdated(function ($get, $set, $state) {
                        $price = $get('price') ?? 0;
                        $discount = $get('discount') ?? 0;
                        $set('total_price', ($price * $state) - $discount);
                    }),
                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR')
                    ->live()
                    ->afterStateUpdated(function ($get, $set, $state) {
                        $qty = $get('qty') ?? 1;
                        $discount = $get('discount') ?? 0;
                        $set('total_price', ($state * $qty) - $discount);
                    }),
                TextInput::make('discount')
                    ->label('Discount')
                    ->numeric()
                    ->prefix('IDR')
                    ->default(0)
                    ->live()
                    ->afterStateUpdated(function ($get, $set, $state) {
                        $price = $get('price') ?? 0;
                        $qty = $get('qty') ?? 1;
                        $set('total_price', ($price * $qty) - $state);
                    }),
                TextInput::make('total_price')
                    ->label('Total Price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR')
                    ->readOnly(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('si_detail_id')
            ->columns([
                TextColumn::make('si_detail_id')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('qty')
                    ->label('Qty')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('discount')
                    ->label('Discount')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
