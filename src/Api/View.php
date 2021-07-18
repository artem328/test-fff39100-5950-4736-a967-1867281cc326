<?php

declare(strict_types=1);

namespace App\Api;

use Symfony\Component\HttpFoundation\Response;

final class View
{
    /**
     * @var mixed
     */
    private $data;

    private int $statusCode;

    private array $headers;

    public function __construct($data, int $statusCode = Response::HTTP_OK, array $headers = []) {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}