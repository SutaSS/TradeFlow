<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SalesOrder;
use App\Models\SalesInvoice;

class DashboardSalesWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalOrders = SalesOrder::count();
        $pendingOrders = SalesOrder::where('status', 'pending')->count();
        $totalInvoices = SalesInvoice::count();
        $unpaidInvoices = SalesInvoice::where('payment_status', 'unpaid')->count();
        $totalRevenue = SalesInvoice::sum('total_amount') ?? 0;
        $paidRevenue = SalesInvoice::where('payment_status', 'paid')->sum('total_amount') ?? 0;

        return [
            Stat::make('Total Sales Orders', $totalOrders)
                ->description('All sales orders')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('success')
                ->icon('heroicon-o-shopping-cart'),

            Stat::make('Pending Orders', $pendingOrders)
                ->description('Waiting for approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make('Total Invoices', $totalInvoices)
                ->description('All sales invoices')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->icon('heroicon-o-document-text'),

            Stat::make('Unpaid Invoices', $unpaidInvoices)
                ->description('Awaiting payment')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger')
                ->icon('heroicon-o-exclamation-circle'),

            Stat::make('Total Revenue', 'IDR ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('All invoiced amounts')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('primary')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Paid Revenue', 'IDR ' . number_format($paidRevenue, 0, ',', '.'))
                ->description('Successfully collected')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
