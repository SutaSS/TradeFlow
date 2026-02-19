<?php

namespace App\Filament\Resources\PurchaseRequisitions;

use App\Filament\Resources\PurchaseRequisitions\Pages;
use App\Filament\Resources\PurchaseRequisitions\RelationManagers\DetailsRelationManager;
use App\Models\PurchaseRequisition;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class PurchaseRequisitionResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-plus';
    protected static string|null $navigationLabel = 'Purchase Requisitions';
    protected static string|\UnitEnum|null $navigationGroup = 'Purchase';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('pr_date')
                    ->required()
                    ->label('PR Date'),
                DatePicker::make('required_date')
                    ->required()
                    ->label('Required Date'),
                Select::make('requested_by')
                    ->relationship('requestedBy', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('approved_by')
                    ->relationship('approvedBy', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('status')
                    ->required()
                    ->options([
                        'Draft' => 'Draft',
                        'Pending' => 'Pending',
                        'Approved' => 'Approved',
                        'Rejected' => 'Rejected',
                    ])
                    ->default('Draft'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pr_id')
                    ->sortable()
                    ->label('PR #'),
                TextColumn::make('pr_date')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                TextColumn::make('requestedBy.name')
                    ->searchable()
                    ->sortable()
                    ->label('Requested By'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Draft' => 'gray',
                        'Pending' => 'info',
                        'Approved' => 'success',
                        'Rejected' => 'danger',
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
                                'Pending' => 'Pending',
                                'Approved' => 'Approved',
                                'Rejected' => 'Rejected',
                            ]),
                    ])
                    ->query(fn ($query, array $data) => $query->when(
                        $data['status'],
                        fn ($q) => $q->where('status', $data['status'])
                    )),
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
            'index' => Pages\ListPurchaseRequisitions::route('/'),
            'create' => Pages\CreatePurchaseRequisition::route('/create'),
            'edit' => Pages\EditPurchaseRequisition::route('/{record}/edit'),
        ];
    }
}