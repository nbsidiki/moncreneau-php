<?php

namespace Moncreneau\Resources;

use Moncreneau\HttpClient;

class Departments
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * List all departments
     */
    public function list(): array
    {
        return $this->http->get('/departments');
    }

    /**
     * Retrieve a department by ID
     */
    public function retrieve(string $id): array
    {
        return $this->http->get("/departments/{$id}");
    }

    /**
     * Check availability for a single slot. The backend only accepts one
     * dateTime, not a date range.
     */
    public function getAvailability(string $id, string $dateTime): array
    {
        return $this->http->get("/departments/{$id}/availability", ['dateTime' => $dateTime]);
    }
}
