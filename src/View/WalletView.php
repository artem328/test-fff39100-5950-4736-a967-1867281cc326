<?php

declare(strict_types=1);

namespace App\View;

use OpenApi\Annotations as OA;

final class WalletView
{
    /**
     * @OA\Property(type="string", example="050eac74-e549-4db1-9ae1-bd83a8827d13", description="Wallet ID")
     */
    private string $id;

    /**
     * @OA\Property(type="integer", example=10000, description="Wallet balance in cents")
     */
    private int $balance;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }
}