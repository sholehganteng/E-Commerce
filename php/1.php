<?php
// Load Midtrans PHP Library
require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php';

// Set konfigurasi Midtrans
\Midtrans\Config::$serverKey = 'SB-Mid-server-Noam25zj4dDmECEfKp_aJOOz';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Validasi data dari form
if (!isset($_POST['total']) || !isset($_POST['items'])) {
    http_response_code(400);
    echo "Invalid input";
    exit;
}

// Data order ID (harus unik)
$order_id = "ORDER-" . time() . "-" . rand(1000, 9999);

// Ambil item detail dari POST dan pastikan isinya benar
$items = json_decode($_POST['items'], true);
$clean_items = [];

foreach ($items as $item) {
    $clean_items[] = array(
        'id' => $item['id'],
        'price' => (int)$item['price'],
        'quantity' => (int)$item['quantity'],
        'name' => $item['name']
    );
}

// Buat parameter transaksi
$params = array(
    'transaction_details' => array(
        'order_id' => $order_id,
        'gross_amount' => (int) $_POST['total'],
    ),
    'item_details' => $clean_items,
    'customer_details' => array(
        'first_name' => $_POST['name'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'billing_address' => array(
            'address' => $_POST['addres'],
        ),
        'shipping_address' => array(
            'address' => $_POST['addres'],
        ),
    ),
);

// Ambil Snap Token dari Midtrans
try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo $snapToken;
} catch (Exception $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>
