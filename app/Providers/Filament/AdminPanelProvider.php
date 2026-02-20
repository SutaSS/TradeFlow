<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Widgets\DashboardAdminWidget;
use App\Filament\Widgets\DashboardSalesWidget;
use App\Filament\Widgets\DashboardPurchaseWidget;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $widgets = [];

        // Configure widgets based on user role
        if (auth()->check()) {
            $role = auth()->user()->role;

            if ($role === 'admin') {
                $widgets = [DashboardAdminWidget::class];
            } elseif ($role === 'sales') {
                $widgets = [DashboardSalesWidget::class];
            } elseif ($role === 'purchase') {
                $widgets = [DashboardPurchaseWidget::class];
            }
        }

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName(config('app.name', 'TradeFlow'))
            ->colors([
                'primary' => Color::Amber,
            ])
            ->resources([
                \App\Filament\Resources\Customers\CustomerResource::class,
                \App\Filament\Resources\Products\ProductResource::class,
                \App\Filament\Resources\SalesOrders\SalesOrderResource::class,
                \App\Filament\Resources\SalesInvoices\SalesInvoiceResource::class,
                \App\Filament\Resources\SalesPayments\SalesPaymentResource::class,
                \App\Filament\Resources\SalesReturns\SalesReturnResource::class,
                \App\Filament\Resources\DeliveryOrders\DeliveryOrderResource::class,
                \App\Filament\Resources\PurchaseRequisitions\PurchaseRequisitionResource::class,
                \App\Filament\Resources\PurchaseOrders\PurchaseOrderResource::class,
                \App\Filament\Resources\GoodsReceipts\GoodsReceiptResource::class,
                \App\Filament\Resources\PurchaseInvoices\PurchaseInvoiceResource::class,
                \App\Filament\Resources\PurchasePayments\PurchasePaymentResource::class,
                \App\Filament\Resources\PurchaseReturns\PurchaseReturnResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                ...$widgets,
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

