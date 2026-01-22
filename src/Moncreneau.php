<?php

namespace Moncreneau;

use Moncreneau\Resources\Appointments;
use Moncreneau\Resources\Departments;

class Moncreneau
{
    public Appointments $appointments;
    public Departments $departments;

    /**
     * Initialize Moncreneau client
     *
     * @param string $apiKey Your Moncreneau API key
     * @param array $config Optional configuration (baseUrl, timeout)
     */
    public function __construct(string $apiKey, array $config = [])
    {
        $baseUrl = $config['baseUrl'] ?? 'https://mc-prd.duckdns.org/api/v1';
        $timeout = $config['timeout'] ?? 30;

        $http = new HttpClient($apiKey, $baseUrl, $timeout);

        $this->appointments = new Appointments($http);
        $this->departments = new Departments($http);
    }

    /**
     * Verify webhook signature using HMAC-SHA256
     *
     * @param string $payload Webhook payload (JSON string)
     * @param string $signature Signature from X-Webhook-Signature header
     * @param string $secret Your webhook secret
     * @return bool True if signature is valid
     */
    public static function verifyWebhookSignature(string $payload, string $signature, string $secret): bool
    {
        $computed = hash_hmac('sha256', $payload, $secret);
        return hash_equals($computed, $signature);
    }
}
