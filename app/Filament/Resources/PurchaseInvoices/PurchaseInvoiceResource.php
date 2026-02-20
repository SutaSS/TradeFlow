<?php

namespace App\Filament\Resources\PurchaseInvoices;

use App\Filament\Resources\PurchaseInvoices\Pages;
use App\Filament\Resources\PurchaseInvoices\RelationManagers\DetailsRelationManager;
use App\Models\PurchaseInvoice;
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

class PurchaseInvoiceResource extends Resource
{
    protected static ?string $model = PurchaseInvoice::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-receipt-refund';
    protected static string|null $navigationLabel = 'Purchase Invoices';
    protected static string|\UnitEnum|null $navigationGroup = 'Purchase';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('invoice_date')
                    ->required()
                    ->label('Invoice Date'),
                DatePicker::make('due_date')
                    ->required()
                    ->label('Due Date'),
                Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('gr_id')
                    ->relationship('goodsReceipt', 'gr_id')
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
                TextColumn::make('purchase_invoice_id')
                    ->sortable()
                    ->label('Invoice #'),
                TextColumn::make('invoice_date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                TextColumn::make('supplier.name')
                    ->searchable()
                    ->sortable()
                    ->label('Supplier'),
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
            'index' => Pages\ListPurchaseInvoices::route('/'),
            'create' => Pages\CreatePurchaseInvoice::route('/create'),
            'edit' => Pages\EditPurchaseInvoice::route('/{record}/edit'),
        ];
    }
}