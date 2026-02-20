<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - TradeFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-blue-50 px-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Success Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-8 text-center">
                <div class="inline-block mb-4">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white">Payment Successful!</h1>
            </div>

            <!-- Content -->
            <div class="px-6 py-8">
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <p class="text-green-800">
                        <strong>✓ Your payment has been processed successfully.</strong>
                    </p>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-gray-600 text-sm">
                        <span>Payment Status:</span>
                        <span class="font-semibold text-green-600">PAID</span>
                    </div>
                    <div class="border-t pt-4">
                        <p class="text-gray-700 text-sm">
                            Thank you for your payment! Your invoice has been marked as paid and you should receive a confirmation email shortly.
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <a href="{{ url('/admin/sales-invoices') }}" 
                       class="block w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold py-3 px-4 rounded-lg hover:shadow-lg transform hover:scale-105 transition text-center">
                        Back to Invoices
                    </a>
                    <a href="{{ url('/admin') }}" 
                       class="block w-full border-2 border-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-50 transition text-center">
                        Go to Dashboard
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t text-center text-sm text-gray-500">
                <p>Transaction has been recorded in your account</p>
            </div>
        </div>
    </div>
</body>
</html>
