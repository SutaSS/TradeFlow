<?php

namespace App\Filament\Resources\PurchaseReturns;

use App\Filament\Resources\PurchaseReturns\Pages;
use App\Filament\Resources\PurchaseReturns\RelationManagers\DetailsRelationManager;
use App\Models\PurchaseReturn;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchaseReturnResource extends Resource
{
    protected static ?string $model = PurchaseReturn::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-uturn-right';
    protected static string|null $navigationLabel = 'Purchase Returns';
    protected static string|\UnitEnum|null $navigationGroup = 'Purchase';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('return_date')
                    ->required()
                    ->label('Return Date'),
                Select::make('purchase_invoice_id')
                    ->relationship('purchaseInvoice', 'purchase_invoice_id')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('subtotal')
                    ->default(0)
                    ->numeric()
                    ->inputMode('decimal')
                    ->live()
                    ->afterStateUpdated(function ($get, $set) {
                        $set('total_amount', floatval($get('subtotal') ?? 0) + floatval($get('tax') ?? 0));
                    }),
                TextInput::make('tax')
                    ->default(0)
                    ->numeric()
                    ->inputMode('decimal')
                    ->live()
                    ->afterStateUpdated(function ($get, $set) {
                        $set('total_amount', floatval($get('subtotal') ?? 0) + floatval($get('tax') ?? 0));
                    }),
                TextInput::make('total_amount')
                    ->default(0)
                    ->numeric()
                    ->inputMode('decimal')
                    ->readOnly(),
                Hidden::make('signed_by')
                    ->default(fn() => auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('return_id')
                    ->sortable()
                    ->label('Return #'),
                TextColumn::make('return_date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                TextColumn::make('purchaseInvoice.purchase_invoice_id')
                    ->sortable()
                    ->label('Invoice #'),
                TextColumn::make('total_amount')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
                    ->sortable()
                    ->money('IDR'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseReturns::route('/'),
            'create' => Pages\CreatePurchaseReturn::route('/create'),
            'edit' => Pages\EditPurchaseReturn::route('/{record}/edit'),
        ];
    }
}