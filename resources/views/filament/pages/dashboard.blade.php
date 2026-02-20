<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="rounded-lg bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="mt-2 text-gray-600">
                        @switch(auth()->user()->role)
                            @case('admin')
                                You have access to both Sales and Purchase modules.
                                @break
                            @case('sales')
                                Here's your Sales module overview.
                                @break
                            @case('purchase')
                                Here's your Purchase module overview.
                                @break
                            @default
                                Welcome to TradeFlow Dashboard.
                        @endswitch
                    </p>
                </div>
                <div class="text-4xl">👋</div>
            </div>
        </div>

        <!-- Widgets Section -->
        @if($widgets)
            <div class="space-y-4">
                @foreach ($widgets as $widget)
                    @livewire($widget)
                @endforeach
            </div>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Quick Links</h3>
                <div class="mt-4 space-y-2">
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'sales')
                        <a href="{{ route('filament.admin.resources.sales-orders.index') }}" 
                           class="block text-blue-600 hover:text-blue-700">
                            → View Sales Orders
                        </a>
                        <a href="{{ route('filament.admin.resources.sales-invoices.index') }}" 
                           class="block text-blue-600 hover:text-blue-700">
                            → View Sales Invoices
                        </a>
                    @endif
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'purchase')
                        <a href="{{ route('filament.admin.resources.purchase-orders.index') }}" 
                           class="block text-blue-600 hover:text-blue-700">
                            → View Purchase Orders
                        </a>
                        <a href="{{ route('filament.admin.resources.purchase-invoices.index') }}" 
                           class="block text-blue-600 hover:text-blue-700">
                            → View Purchase Invoices
                        </a>
                    @endif
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900">Account Information</h3>
                <div class="mt-4 space-y-2 text-gray-600">
                    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p><strong>Role:</strong> <span class="inline-block rounded bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-800">{{ ucfirst(auth()->user()->role) }}</span></p>
                    <p><strong>Last Login:</strong> {{ auth()->user()->updated_at?->diffForHumans() ?? 'New Account' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
