<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SalesOrder;
use App\Models\SalesInvoice;
use App\Models\PurchaseOrder;
use App\Models\PurchaseInvoice;

class DashboardAdminWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Sales Data
        $salesOrders = SalesOrder::count();
        $salesInvoices = SalesInvoice::count();
        $salesRevenue = SalesInvoice::sum('total_amount') ?? 0;

        // Purchase Data
        $purchaseOrders = PurchaseOrder::count();
        $purchaseInvoices = PurchaseInvoice::count();
        $purchaseCosts = PurchaseInvoice::sum('total_amount') ?? 0;

        // Pending
        $pendingSalesOrders = SalesOrder::where('status', 'pending')->count();
        $pendingPurchaseOrders = PurchaseOrder::where('status', 'pending')->count();

        return [
            // Sales Section
            Stat::make('Sales Orders', $salesOrders)
                ->description('Total sales orders')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('success')
                ->icon('heroicon-o-shopping-cart'),

            Stat::make('Sales Invoices', $salesInvoices)
                ->description('Total sales invoices')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->icon('heroicon-o-document-text'),

            Stat::make('Total Revenue', 'IDR ' . number_format($salesRevenue, 0, ',', '.'))
                ->description('All sales amounts')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Pending Sales', $pendingSalesOrders)
                ->description('Waiting for approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            // Purchase Section
            Stat::make('Purchase Orders', $purchaseOrders)
                ->description('Total purchase orders')
                ->descriptionIcon('heroicon-m-square-3-stack-3d')
                ->color('primary')
                ->icon('heroicon-o-square-3-stack-3d'),

            Stat::make('Purchase Invoices', $purchaseInvoices)
                ->description('Total purchase invoices')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('primary')
                ->icon('heroicon-o-document-check'),

            Stat::make('Total Costs', 'IDR ' . number_format($purchaseCosts, 0, ',', '.'))
                ->description('All purchase amounts')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Pending Purchase', $pendingPurchaseOrders)
                ->description('Waiting for approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),
        ];
    }
}
