<?php

namespace Moncreneau\Resources;

use Moncreneau\HttpClient;

class Appointments
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create a new appointment
     */
    public function create(array $data): array
    {
        return $this->http->post('/appointments', $data);
    }

    /**
     * Retrieve an appointment by ID
     */
    public function retrieve(string $id): array
    {
        return $this->http->get("/appointments/{$id}");
    }

    /**
     * List appointments with pagination and filters
     */
    public function list(array $params = []): array
    {
        return $this->http->get('/appointments', $params);
    }

    /**
     * Cancel an appointment
     */
    public function cancel(string $id): void
    {
        $this->http->delete("/appointments/{$id}");
    }
}
