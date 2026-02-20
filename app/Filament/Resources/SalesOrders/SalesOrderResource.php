<?php

namespace App\Filament\Resources\SalesOrders;

use App\Filament\Resources\SalesOrders\Pages;
use App\Filament\Resources\SalesOrders\RelationManagers\DetailsRelationManager;
use App\Models\SalesOrder;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class SalesOrderResource extends Resource
{
    protected static ?string $model = SalesOrder::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static string|null $navigationLabel = 'Sales Orders';
    protected static string|\UnitEnum|null $navigationGroup = 'Sales';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('so_date')
                    ->required()
                    ->label('Order Date'),
                Select::make('customer_id')
                    ->relationship('customer', 'name')
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
                Select::make('status')
                    ->required()
                    ->options([
                        'Draft' => 'Draft',
                        'Confirmed' => 'Confirmed',
                        'Approved' => 'Approved',
                        'Delivered' => 'Delivered',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->default('Draft'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('so_id')
                    ->sortable()
                    ->label('SO #'),
                TextColumn::make('so_date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable()
                    ->label('Customer'),
                TextColumn::make('total_amount')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
                    ->sortable()
                    ->money('IDR'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Draft' => 'gray',
                        'Confirmed' => 'info',
                        'Approved' => 'primary',
                        'Delivered' => 'success',
                        'Cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created'),
            ])
            ->filters([
                Filter::make('status')
                    ->form([
                        Select::make('status')
                            ->options([
                                'Draft' => 'Draft',
                                'Confirmed' => 'Confirmed',
                                'Approved' => 'Approved',
                                'Delivered' => 'Delivered',
                                'Cancelled' => 'Cancelled',
                            ]),
                    ])
                    ->query(fn ($query, array $data) => $query->when(
                        $data['status'],
                        fn ($q) => $q->where('status', $data['status'])
                    )),
                Filter::make('so_date')
                    ->form([
                        DatePicker::make('from')
                            ->label('From'),
                        DatePicker::make('until')
                            ->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('so_date', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('so_date', '<=', $data['until']));
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                Action::make('markAsPaid')
                    ->label('Mark as Paid')
                    ->icon('heroicon-o-check-circle')
                    ->action(function ($record) {
                        $record->update(['status' => 'Paid']);
                    })
                    ->requiresConfirmation()
                    ->color('success'),
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
            'index' => Pages\ListSalesOrders::route('/'),
            'create' => Pages\CreateSalesOrder::route('/create'),
            'edit' => Pages\EditSalesOrder::route('/{record}/edit'),
        ];
    }
}