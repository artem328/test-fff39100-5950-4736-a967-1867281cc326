<?php

declare(strict_types=1);

namespace App\View;

use OpenApi\Annotations as OA;

final class ErrorView
{
    /**
     * @OA\Property(type="int", example=500, description="HTTP code")
     */
    private int $code;

    /**
     * @OA\Property(type="string", example="Internal Server Error", description="HTTP status message")
     */
    private string $message;

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}