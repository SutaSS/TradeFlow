<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->sales_invoice_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            color: #333;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }
        
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2563eb;
        }
        
        .company-info h1 {
            color: #2563eb;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .company-info p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .invoice-meta {
            text-align: right;
        }
        
        .invoice-meta h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .invoice-meta p {
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .invoice-meta .invoice-number {
            font-weight: bold;
            color: #2563eb;
            font-size: 16px;
        }
        
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .bill-to, .invoice-info {
            flex: 1;
        }
        
        .bill-to h3, .invoice-info h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        
        .bill-to p, .invoice-info p {
            font-size: 14px;
            line-height: 1.6;
        }
        
        .bill-to .customer-name {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }
        
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .invoice-table thead {
            background-color: #f3f4f6;
        }
        
        .invoice-table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .invoice-table th.text-right,
        .invoice-table td.text-right {
            text-align: right;
        }
        
        .invoice-table th.text-center,
        .invoice-table td.text-center {
            text-align: center;
        }
        
        .invoice-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }
        
        .invoice-table td {
            padding: 12px;
            font-size: 14px;
        }
        
        .invoice-table tbody tr:hover {
            background-color: #f9fafb;
        }
        
        .invoice-summary {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }
        
        .summary-table {
            width: 300px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }
        
        .summary-row.subtotal,
        .summary-row.tax {
            color: #666;
        }
        
        .summary-row.total {
            border-top: 2px solid #e5e7eb;
            padding-top: 12px;
            margin-top: 8px;
            font-weight: bold;
            font-size: 18px;
            color: #2563eb;
        }
        
        .invoice-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
        }
        
        .invoice-footer p {
            font-size: 12px;
            color: #666;
            line-height: 1.6;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-draft {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        
        .status-unpaid {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .status-paid {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .status-cancelled {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .invoice-container {
                max-width: 100%;
            }
            
            @page {
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>TradeFlow ERP</h1>
                <p>
                    Jl. Contoh No. 123<br>
                    Jakarta 12345, Indonesia<br>
                    Phone: (021) 1234-5678<br>
                    Email: info@tradeflow.com
                </p>
            </div>
            <div class="invoice-meta">
                <h2>INVOICE</h2>
                <p class="invoice-number">#{{ $invoice->sales_invoice_id }}</p>
                <p>
                    <strong>Date:</strong> {{ $invoice->invoice_date->format('d M Y') }}<br>
                    <strong>Due Date:</strong> {{ $invoice->due_date->format('d M Y') }}<br>
                    <strong>Status:</strong> 
                    <span class="status-badge status-{{ strtolower($invoice->status) }}">
                        {{ $invoice->status }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Bill To & Invoice Info -->
        <div class="invoice-details">
            <div class="bill-to">
                <h3>Bill To:</h3>
                <p class="customer-name">{{ $invoice->customer->name }}</p>
                <p>
                    {{ $invoice->customer->address }}<br>
                    Phone: {{ $invoice->customer->phone }}
                </p>
            </div>
            <div class="invoice-info">
                <h3>Invoice Details:</h3>
                <p>
                    <strong>Sales Order:</strong> #{{ $invoice->salesOrder->so_id }}<br>
                    <strong>SO Date:</strong> {{ $invoice->salesOrder->so_date->format('d M Y') }}
                </p>
            </div>
        </div>

        <!-- Items Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Product</th>
                    <th class="text-center" style="width: 100px;">Qty</th>
                    <th class="text-right" style="width: 120px;">Price</th>
                    <th class="text-right" style="width: 120px;">Discount</th>
                    <th class="text-right" style="width: 140px;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->product->name }}</td>
                    <td class="text-center">{{ number_format($detail->qty) }}</td>
                    <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->discount, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="invoice-summary">
            <div class="summary-table">
                <div class="summary-row subtotal">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row tax">
                    <span>Tax (11%):</span>
                    <span>Rp {{ number_format($invoice->tax, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <p>
                <strong>Payment Terms:</strong> Net {{ $invoice->due_date->diffInDays($invoice->invoice_date) }} days<br>
                Thank you for your business!
            </p>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
