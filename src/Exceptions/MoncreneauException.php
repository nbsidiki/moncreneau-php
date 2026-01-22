<?php

namespace Moncreneau\Exceptions;

class MoncreneauException extends \Exception
{
    private string $errorCode;
    private int $statusCode;
    private ?array $details;

    public function __construct(array $error, int $statusCode)
    {
        $this->errorCode = $error['code'] ?? 'UNKNOWN_ERROR';
        $this->statusCode = $statusCode;
        $this->details = $error['details'] ?? null;
        
        parent::__construct($error['message'] ?? 'An error occurred', $statusCode);
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }
}
