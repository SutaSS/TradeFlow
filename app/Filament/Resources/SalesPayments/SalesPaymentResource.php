<?php

namespace App\Filament\Resources\SalesPayments;

use App\Filament\Resources\SalesPayments\Pages;
use App\Models\SalesPayment;
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

class SalesPaymentResource extends Resource
{
    protected static ?string $model = SalesPayment::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static string|null $navigationLabel = 'Sales Payments';
    protected static string|\UnitEnum|null $navigationGroup = 'Sales';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('payment_date')
                    ->required()
                    ->label('Payment Date'),
                Select::make('sales_invoice_id')
                    ->relationship('salesInvoice', 'sales_invoice_id')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('amount_paid')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal'),
                Select::make('payment_method')
                    ->required()
                    ->options([
                        'manual' => 'Manual',
                        'xendit' => 'Xendit',
                    ])
                    ->default('manual'),
                TextInput::make('external_id')
                    ->maxLength(255)
                    ->label('External ID'),
                TextInput::make('reference_id')
                    ->maxLength(255)
                    ->label('Reference ID'),
                TextInput::make('payment_channel')
                    ->maxLength(255),
                TextInput::make('gateway_status')
                    ->maxLength(255),
                Select::make('status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'failed' => 'Failed',
                    ])
                    ->default('pending'),
                Hidden::make('received_by')
                    ->default(fn() => auth()->id()),
                Hidden::make('paid_by')
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
                TextColumn::make('salesInvoice.sales_invoice_id')
                    ->sortable()
                    ->label('Invoice #'),
                TextColumn::make('amount_paid')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
                    ->sortable()
                    ->money('IDR'),
                TextColumn::make('payment_method')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manual' => 'info',
                        'xendit' => 'success',
                        default => 'gray',
                    }),
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
            'index' => Pages\ListSalesPayments::route('/'),
            'create' => Pages\CreateSalesPayment::route('/create'),
            'edit' => Pages\EditSalesPayment::route('/{record}/edit'),
        ];
    }
}