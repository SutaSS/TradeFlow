<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\PurchaseOrder;
use App\Models\PurchaseInvoice;

class DashboardPurchaseWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalOrders = PurchaseOrder::count();
        $pendingOrders = PurchaseOrder::where('status', 'pending')->count();
        $totalInvoices = PurchaseInvoice::count();
        $unpaidInvoices = 0; // PurchaseInvoice doesn't have payment_status yet
        $totalCosts = PurchaseInvoice::sum('total_amount') ?? 0;
        $paidCosts = 0; // No payment tracking for purchase invoices

        return [
            Stat::make('Total Purchase Orders', $totalOrders)
                ->description('All purchase orders')
                ->descriptionIcon('heroicon-m-square-3-stack-3d')
                ->color('success')
                ->icon('heroicon-o-square-3-stack-3d'),

            Stat::make('Pending Orders', $pendingOrders)
                ->description('Waiting for approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make('Total Invoices', $totalInvoices)
                ->description('All purchase invoices')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->icon('heroicon-o-document-text'),

            Stat::make('Awaiting Receipt', PurchaseOrder::where('status', 'pending')->count())
                ->description('Orders pending delivery')
                ->descriptionIcon('heroicon-m-truck')
                ->color('warning')
                ->icon('heroicon-o-truck'),

            Stat::make('Total Costs', 'IDR ' . number_format($totalCosts, 0, ',', '.'))
                ->description('All invoiced amounts')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('primary')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Average Invoice', 'IDR ' . number_format($totalInvoices > 0 ? $totalCosts / $totalInvoices : 0, 0, ',', '.'))
                ->description('Average per invoice')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info')
                ->icon('heroicon-o-chart-bar'),
        ];
    }
}
