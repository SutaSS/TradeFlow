<?php

namespace App\Filament\Resources\GoodsReceipts;

use App\Filament\Resources\GoodsReceipts\Pages;
use App\Filament\Resources\GoodsReceipts\RelationManagers\DetailsRelationManager;
use App\Models\GoodsReceipt;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GoodsReceiptResource extends Resource
{
    protected static ?string $model = GoodsReceipt::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-inbox-stack';
    protected static string|null $navigationLabel = 'Goods Receipts';
    protected static string|\UnitEnum|null $navigationGroup = 'Purchase';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('gr_date')
                    ->required()
                    ->label('GR Date'),
                Select::make('po_id')
                    ->relationship('purchaseOrder', 'po_id')
                    ->required()
                    ->searchable()
                    ->preload(),
                Hidden::make('received_by')
                    ->default(fn() => auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('gr_id')
                    ->sortable()
                    ->label('GR #'),
                TextColumn::make('gr_date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                TextColumn::make('purchaseOrder.po_id')
                    ->sortable()
                    ->label('PO #'),
                TextColumn::make('receivedBy.name')
                    ->sortable()
                    ->label('Received By'),
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
            'index' => Pages\ListGoodsReceipts::route('/'),
            'create' => Pages\CreateGoodsReceipt::route('/create'),
            'edit' => Pages\EditGoodsReceipt::route('/{record}/edit'),
        ];
    }
}