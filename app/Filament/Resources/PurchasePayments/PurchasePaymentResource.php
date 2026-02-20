<?php

namespace App\Filament\Resources\PurchasePayments;

use App\Filament\Resources\PurchasePayments\Pages;
use App\Models\PurchasePayment;
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

class PurchasePaymentResource extends Resource
{
    protected static ?string $model = PurchasePayment::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';
    protected static string|null $navigationLabel = 'Purchase Payments';
    protected static string|\UnitEnum|null $navigationGroup = 'Purchase';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('payment_date')
                    ->required()
                    ->label('Payment Date'),
                Select::make('purchase_invoice_id')
                    ->relationship('purchaseInvoice', 'purchase_invoice_id')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('amount_paid')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal'),
                Select::make('status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'failed' => 'Failed',
                    ])
                    ->default('pending'),
                Hidden::make('paid_by')
                    ->default(fn() => auth()->id()),
                Hidden::make('received_by')
                    ->default(fn() => auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_id')
                    ->sortable()
                    ->label('Payment #'),
                TextColumn::make('payment_date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                TextColumn::make('purchaseInvoice.purchase_invoice_id')
                    ->sortable()
                    ->label('Invoice #'),
                TextColumn::make('amount_paid')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
                    ->sortable()
                    ->money('IDR'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchasePayments::route('/'),
            'create' => Pages\CreatePurchasePayment::route('/create'),
            'edit' => Pages\EditPurchasePayment::route('/{record}/edit'),
        ];
    }
}