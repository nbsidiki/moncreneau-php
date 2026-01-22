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
     * Get availability for a department
     */
    public function getAvailability(string $id, array $params): array
    {
        return $this->http->get("/departments/{$id}/availability", $params);
    }
}
