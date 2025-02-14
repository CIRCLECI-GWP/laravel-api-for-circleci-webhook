<?php

use Dotenv\Dotenv;

// Load Composer's autoloader
require __DIR__ . '/vendor/autoload.php';

// Load environment variables manually
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Define the payload
$payload = '{}';

// Get the secret from the .env file
$secret = getenv('CIRCLE_CI_WEBHOOK_SECRET') ?: $_ENV['CIRCLE_CI_WEBHOOK_SECRET'] ?? '';

if (!$secret) {
    die("Error: CIRCLE_CI_WEBHOOK_SECRET is not set in the environment.\n");
}

// Generate the HMAC signature
$signature = hash_hmac('sha256', $payload, $secret);

echo "Generated Signature: sha256=$signature\n";

