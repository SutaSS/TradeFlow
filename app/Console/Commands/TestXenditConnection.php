<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;

class TestXenditConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xendit:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Xendit API connection and configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🧪 Testing Xendit Connection...\n");

        // Test 1: Check config
        $this->line("1️⃣  Checking Configuration...");
        $secret_key = config('services.xendit.secret_key');
        
        if (!$secret_key) {
            $this->error("❌ XENDIT_SECRET_KEY not found in .env!");
            return 1;
        }

        if (!str_starts_with($secret_key, 'xnd_development_')) {
            $this->warn("⚠️  WARNING: Not using development key. Key starts with: " . substr($secret_key, 0, 20) . "...");
        } else {
            $this->info("✅ Using Development API Key");
        }

        // Test 2: Set API Key
        $this->line("\n2️⃣  Setting API Key...");
        try {
            Configuration::setXenditKey($secret_key);
            $this->info("✅ API Key configured");
        } catch (\Exception $e) {
            $this->error("❌ Error setting API key: " . $e->getMessage());
            return 1;
        }

        // Test 3: Create test invoice
        $this->line("\n3️⃣  Creating Test Invoice...");
        try {
            $apiInstance = new InvoiceApi();
            
            $external_id = 'test-' . time();
            $amount = 50000; // 50k IDR

            $create_invoice_request = new \Xendit\Invoice\CreateInvoiceRequest([
                'external_id' => $external_id,
                'amount' => (float)$amount,
                'description' => 'Test Invoice from Laravel',
                'customer' => [
                    'given_names' => 'Test User',
                    'email' => 'test@tradeflow.local',
                ],
                'success_redirect_url' => 'http://localhost:8000/payment/success',
                'failure_redirect_url' => 'http://localhost:8000/payment/failed',
            ]);

            $result = $apiInstance->createInvoice($create_invoice_request);

            $this->info("✅ Test Invoice Created Successfully!");
            $this->info("");
            $this->line("📋 Invoice Details:");
            $this->line("  ID: " . $result['id']);
            $this->line("  External ID: " . $result['external_id']);
            $this->line("  Amount: IDR " . number_format($result['amount'], 2));
            $this->line("  Status: " . $result['status']);
            $this->line("");
            $this->line("🔗 Payment URL: {$result['invoice_url']}");
            $this->info("");
            $this->info("✅ XENDIT IS WORKING! You can use development key for testing.");

            return 0;

        } catch (\Exception $e) {
            $this->error("❌ Error creating test invoice:");
            $this->error($e->getMessage());
            $this->line("");
            $this->error("Troubleshooting:");
            $this->line("1. Make sure XENDIT_SECRET_KEY in .env starts with 'xnd_development_'");
            $this->line("2. Check that you've installed: composer require xendit/xendit-php");
            $this->line("3. Run: php artisan config:clear");

            return 1;
        }
    }
}
