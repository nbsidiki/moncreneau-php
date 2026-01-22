# Moncreneau PHP SDK

Official Moncreneau API client for PHP.

[![Packagist](https://img.shields.io/packagist/v/moncreneau/moncreneau-php.svg)](https://packagist.org/packages/moncreneau/moncreneau-php)
[![PHP Version](https://img.shields.io/packagist/php-v/moncreneau/moncreneau-php.svg)](https://packagist.org/packages/moncreneau/moncreneau-php)
[![License](https://img.shields.io/packagist/l/moncreneau/moncreneau-php.svg)](https://github.com/moncreneau/moncreneau-php/blob/main/LICENSE)

## Installation

```bash
composer require moncreneau/moncreneau-php
```

## Quick Start

```php
<?php
require_once 'vendor/autoload.php';

use Moncreneau\Moncreneau;

$client = new Moncreneau('mk_live_YOUR_API_KEY');

// Create an appointment
$appointment = $client->appointments->create([
    'departmentId' => 'dept_123',
    'dateTime' => '2026-01-20T10:00:00',
    'userName' => 'Jean Dupont',
    'userPhone' => '+224621234567',
    'userEmail' => 'jean.dupont@example.com'
]);

echo $appointment['id']; // appt_abc123
```

## Documentation

Full documentation: [https://moncreneau-docs.vercel.app/docs/v1/sdks/php](https://moncreneau-docs.vercel.app/docs/v1/sdks/php)

## Features

- ✅ PSR-4 autoloading
- ✅ Guzzle HTTP client
- ✅ Full error handling
- ✅ Webhook verification
- ✅ PHP 7.4+ support

## Usage

### Configuration

```php
$client = new Moncreneau('mk_live_...', [
    'baseUrl' => 'https://mc.duckdns.org/api/v1', // optional
    'timeout' => 30 // optional
]);
```

### Appointments

```php
// Create
$appointment = $client->appointments->create([
    'departmentId' => 'dept_123',
    'dateTime' => '2026-01-20T10:00:00',
    'userName' => 'Jean Dupont',
    'userPhone' => '+224621234567'
]);

// List
$appointments = $client->appointments->list([
    'page' => 0,
    'size' => 20,
    'status' => 'SCHEDULED'
]);

// Retrieve
$appointment = $client->appointments->retrieve('appt_abc123');

// Cancel
$client->appointments->cancel('appt_abc123');
```

### Departments

```php
// List
$departments = $client->departments->list();

// Get availability
$availability = $client->departments->getAvailability('dept_123', [
    'startDate' => '2026-01-20',
    'endDate' => '2026-01-27'
]);
```

### Error Handling

```php
use Moncreneau\Exceptions\MoncreneauException;

try {
    $appointment = $client->appointments->create([...]);
} catch (MoncreneauException $e) {
    echo 'Code: ' . $e->getErrorCode();
    echo 'Message: ' . $e->getMessage();
    echo 'Status: ' . $e->getStatusCode();
    print_r($e->getDetails());
}
```

### Webhooks

```php
use Moncreneau\Moncreneau;

// In your webhook endpoint
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_WEBHOOK_SIGNATURE'];
$secret = getenv('WEBHOOK_SECRET');

if (!Moncreneau::verifyWebhookSignature($payload, $signature, $secret)) {
    http_response_code(401);
    die('Invalid signature');
}

$event = json_decode($payload, true);
echo "Event: " . $event['type'];
```

## Laravel Example

```php
use Moncreneau\Moncreneau;
use Moncreneau\Exceptions\MoncreneauException;

class AppointmentController extends Controller
{
    private $client;
    
    public function __construct()
    {
        $this->client = new Moncreneau(env('MONCRENEAU_API_KEY'));
    }
    
    public function store(Request $request)
    {
        try {
            $appointment = $this->client->appointments->create([
                'departmentId' => $request->input('departmentId'),
                'dateTime' => $request->input('dateTime'),
                'userName' => $request->input('userName'),
                'userPhone' => $request->input('userPhone')
            ]);
            
            return response()->json($appointment);
        } catch (MoncreneauException $e) {
            return response()->json([
                'error' => $e->getErrorCode(),
                'message' => $e->getMessage()
            ], $e->getStatusCode());
        }
    }
}
```

## Support

- **Documentation**: [https://moncreneau-docs.vercel.app](https://moncreneau-docs.vercel.app)
- **Issues**: [GitHub Issues](https://github.com/nbsidiki/moncreneau-php/issues)
- **Email**: moncreneau.rdv@gmail.com

## License

MIT © Moncreneau
