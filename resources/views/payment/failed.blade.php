<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - TradeFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 to-orange-50 px-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Failed Header -->
            <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-8 text-center">
                <div class="inline-block mb-4">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white">Payment Failed</h1>
            </div>

            <!-- Content -->
            <div class="px-6 py-8">
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="text-red-800">
                        <strong>✗ Your payment could not be processed.</strong>
                    </p>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-gray-600 text-sm">
                        <span>Payment Status:</span>
                        <span class="font-semibold text-red-600">FAILED</span>
                    </div>
                    <div class="border-t pt-4">
                        <p class="text-gray-700 text-sm">
                            @if(request('reason'))
                                <strong>Reason:</strong> {{ request('reason') }}
                            @else
                                The payment transaction was declined or cancelled. Please verify your payment details and try again.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <button onclick="history.back()" 
                       class="block w-full bg-gradient-to-r from-orange-500 to-red-600 text-white font-semibold py-3 px-4 rounded-lg hover:shadow-lg transform hover:scale-105 transition text-center cursor-pointer">
                        Try Again
                    </button>
                    <a href="{{ url('/admin/sales-invoices') }}" 
                       class="block w-full border-2 border-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-50 transition text-center">
                        Back to Invoices
                    </a>
                    <a href="{{ url('/admin') }}" 
                       class="block w-full bg-gray-100 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-200 transition text-center">
                        Go to Dashboard
                    </a>
                </div>

                <!-- Help Section -->
                <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-blue-800">
                        <strong>Need help?</strong> If the problem persists, please contact our support team or try a different payment method.
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t text-center text-sm text-gray-500">
                <p>Please try your payment again</p>
            </div>
        </div>
    </div>
</body>
</html>
