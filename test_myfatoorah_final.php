<?php

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

try {
    $client = new Client();
    
    $apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5ThW3O7erRs1xQ3Unylg6m0vgaH9RXQjLJoTDB95HKTknLuKZR1XQbBse1T3PBlk3H3JVWX9cJR7Df4TVLmtQHfIzSYlnqHI4JTn5RqB2VvG9SvodzAr1xQNwvbFaHCkRr3RjBQIDAQAB';
    $baseUrl = 'https://api-sa.myfatoorah.com';
    
    // البيانات المحدثة مع NotificationOption
    $payload = [
        'CustomerName' => 'Test User',
        'CustomerEmail' => 'test@example.com',
        'CustomerMobile' => '501234567',
        'InvoiceValue' => 100,
        'DisplayCurrencyIso' => 'SAR',
        'CallBackUrl' => 'https://example.com/success',
        'ErrorUrl' => 'https://example.com/error',
        'NotificationOption' => 'LNK', // مطلوب من MyFatoorah
        'CustomerReference' => 'ORDER-' . time(), // مرجع العميل
    ];
    
    echo "Testing MyFatoorah with complete data...\n";
    echo "URL: " . $baseUrl . "\n";
    echo "Payload: " . json_encode($payload, JSON_PRETTY_PRINT) . "\n";
    
    $response = $client->post($baseUrl . '/v2/SendPayment', [
        'headers' => [
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ],
        'json' => $payload,
    ]);
    
    $result = json_decode($response->getBody(), true);
    
    echo "Success! Response: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";
    
    if (isset($result['Data']['InvoiceURL'])) {
        echo "Payment URL: " . $result['Data']['InvoiceURL'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    
    if ($e->hasResponse()) {
        $response = $e->getResponse();
        $body = $response->getBody()->getContents();
        echo "Response Body: " . $body . "\n";
        echo "Status Code: " . $response->getStatusCode() . "\n";
    }
}
