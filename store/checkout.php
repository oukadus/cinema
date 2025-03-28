<?php
require_once '../inc/functions.inc.php';
require_once '../vendor/autoload.php';
require_once 'secrets.php';
$pageTitle = "Paiement";

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$total = is_numeric($_POST['total']) ? (int)round($_POST['total'] * 100) : 0;

$YOUR_DOMAIN = RACINE_SITE;

$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => [[
        'price_data' => [
            'currency' => 'EUR',
            'unit_amount' => $total,
            'product_data' => [
                'name' => 'Film'
            ]

        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . 'store/success.php?total=' . $_POST['total'],
    'cancel_url' => $YOUR_DOMAIN . 'store/cancel.php',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
