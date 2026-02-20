<?php

namespace App\Services;

use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\PaymentMethod\PaymentMethodApi; // Untuk VA (versi baru pakai Payment Method)
use Exception;

class XenditService
{
    public function __construct()
    {
        // Set API Key dengan secret key dari config
        Configuration::setXenditKey(config('services.xendit.secret_key'));
    }

    /**
     * Create Invoice
     */
    public function createInvoice($invoiceId, $amount, $description, $customer)
    {
        try {
            // PERUBAHAN 2: Harus inisialisasi API Instance
            $apiInstance = new InvoiceApi();
            
            // PERUBAHAN 3: Parameter harus dibungkus dalam Object Request
            $create_invoice_request = new CreateInvoiceRequest([
                'external_id' => 'invoice-' . $invoiceId,
                'amount' => (float)$amount, // Pastikan float/number
                'description' => $description,
                'customer' => [
                    'given_names' => $customer['name'],
                    'email' => $customer['email'],
                    'mobile_number' => $customer['phone'] ?? '',
                ],
                // Pastikan route ini ada di web.php kamu
                'success_redirect_url' => route('payment.success'),
                'failure_redirect_url' => route('payment.failed'),
            ]);

            // Panggil API
            $result = $apiInstance->createInvoice($create_invoice_request);

            return $result;

        } catch (Exception $e) {
            // Error handling Xendit v7
            throw new Exception('Xendit Error: ' . $e->getMessage());
        }
    }

    /**
     * Get Invoice Status
     */
    public function getInvoice($invoiceId)
    {
        try {
            $apiInstance = new InvoiceApi();
            // Di v7 methodnya getInvoiceById
            return $apiInstance->getInvoiceById($invoiceId);
        } catch (Exception $e) {
            throw new Exception('Xendit Error: ' . $e->getMessage());
        }
    }

    /**
     * Create Virtual Account
     * CATATAN: Di Xendit v7, cara membuat VA berubah drastis menjadi "Payment Method".
     * Ini contoh implementasi sederhana untuk membuat VA Fixed.
     */
    public function createVirtualAccount($bankCode, $name, $amount = null)
    {
        // Code untuk VA di v7 jauh lebih kompleks karena menggunakan PaymentRequest/PaymentMethod.
        // Jika kamu hanya butuh Invoice dulu, fokus ke Invoice saja.
        // Jika butuh VA, kabari lagi karena butuh library tambahan "xendit/payment-request".
        
        throw new Exception("Fitur VA di Xendit v7 membutuhkan implementasi PaymentMethodApi yang berbeda dari v3.");
    }
}