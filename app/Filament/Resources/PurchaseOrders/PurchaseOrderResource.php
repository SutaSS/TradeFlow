<?php

namespace App\Filament\Resources\PurchaseOrders;

use App\Filament\Resources\PurchaseOrders\Pages;
use App\Filament\Resources\PurchaseOrders\RelationManagers\DetailsRelationManager;
use App\Models\PurchaseOrder;
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

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static string|null $navigationLabel = 'Purchase Orders';
    protected static string|\UnitEnum|null $navigationGroup = 'Purchase';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('pr_id')
                    ->relationship('purchaseRequisition', 'pr_id')
                    ->required()
                    ->searchable()
                    ->preload(),
                DatePicker::make('po_date')
                    ->required()
                    ->label('PO Date'),
                DatePicker::make('required_date')
                    ->required()
                    ->label('Required Date'),
                Select::make('supplier_id')
                    ->relationship('supplier', 'name')
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
                Hidden::make('approved_by')
                    ->default(fn() => auth()->id()),
                Select::make('status')
                    ->required()
                    ->options([
                        'Draft' => 'Draft',
                        'Confirmed' => 'Confirmed',
                        'Received' => 'Received',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->default('Draft'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('po_id')
                    ->sortable()
                    ->label('PO #'),
                TextColumn::make('po_date')
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
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Draft' => 'gray',
                        'Confirmed' => 'info',
                        'Approved' => 'primary',
                        'Received' => 'success',
                        'Cancelled' => 'danger',
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

    public static function getRelations(): array
    {
        return [
            DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}