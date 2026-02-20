<?php

namespace App\Filament\Resources\DeliveryOrders;

use App\Filament\Resources\DeliveryOrders\Pages;
use App\Filament\Resources\DeliveryOrders\RelationManagers\DetailsRelationManager;
use App\Models\DeliveryOrder;
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

class DeliveryOrderResource extends Resource
{
    protected static ?string $model = DeliveryOrder::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-truck';
    protected static string|null $navigationLabel = 'Delivery Orders';
    protected static string|\UnitEnum|null $navigationGroup = 'Sales';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('so_id')
                    ->relationship('salesOrder', 'so_id')
                    ->required()
                    ->searchable()
                    ->preload(),
                DatePicker::make('do_date')
                    ->required()
                    ->label('Delivery Date'),
                Hidden::make('delivered_by')
                    ->default(fn() => auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('do_id')
                    ->sortable()
                    ->label('DO #'),
                TextColumn::make('do_date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                TextColumn::make('salesOrder.so_id')
                    ->sortable()
                    ->label('SO #'),
                TextColumn::make('deliveredBy.name')
                    ->sortable()
                    ->label('Delivered By'),
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
            'index' => Pages\ListDeliveryOrders::route('/'),
            'create' => Pages\CreateDeliveryOrder::route('/create'),
            'edit' => Pages\EditDeliveryOrder::route('/{record}/edit'),
        ];
    }
}