<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ToyyibPayService
{
    protected string $secretKey;
    protected string $categoryCode;
    protected string $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('services.toyyibpay.secret');
        $this->categoryCode = config('services.toyyibpay.category');
        $this->baseUrl = config('services.toyyibpay.url');
    }

    public function createBill(array $params): array
    {
        $payload = [
            'userSecretKey' => $this->secretKey,
            'categoryCode' => $this->categoryCode,
            'billName' => $params['bill_name'],
            'billDescription' => $params['bill_description'],
            'billPriceSetting' => 1,
            'billPayorInfo' => 0,
            'billAmount' => $params['amount'] * 100,
            'billReturnUrl' => $params['return_url'],
            'billCallbackUrl' => $params['callback_url'],
            'billExternalReferenceNo' => $params['reference_no'],
            'billTo' => $params['customer_name'] ?? 'Customer',
            'billEmail' => $params['customer_email'] ?? '',
            'billPhone' => $params['customer_phone'] ?? '',
            'billPaymentChannel' => 0,
            'billDisplayPayorInfo' => 0,
            'billChargeToCustomer' => 0,
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billContentEmail' => '',
            'billExpiryDate' => '',
            'billExpiryDays' => 1,
        ];

        $response = Http::withoutVerifying()->asForm()->post("{$this->baseUrl}/index.php/api/createBill", $payload);

        Log::debug('ToyyibPay createBill response', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if ($response->failed()) {
            Log::error('ToyyibPay createBill failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \Exception('Failed to create ToyyibPay bill: ' . $response->body());
        }

        $result = $response->json();
        return $result[0] ?? [];
    }

    public function getPaymentStatus(string $billCode): array
    {
        $response = Http::withoutVerifying()->get("{$this->baseUrl}/index.php/api/getBillTransactions", [
            'userSecretKey' => $this->secretKey,
            'billCode' => $billCode,
        ]);

        if ($response->failed()) {
            Log::error('ToyyibPay getBillTransactions failed', [
                'billCode' => $billCode,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \Exception('Failed to get bill transactions: ' . $response->body());
        }

        return $response->json();
    }

    public function getPaymentUrl(string $billCode): string
    {
        return "{$this->baseUrl}/{$billCode}";
    }
}
