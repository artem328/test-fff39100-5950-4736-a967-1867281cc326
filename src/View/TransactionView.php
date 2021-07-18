<?php

declare(strict_types=1);

namespace App\View;

use OpenApi\Annotations as OA;

class TransactionView
{
    /**
     * @OA\Property(type="string", example="b5a97b41-d791-4dd8-9a1c-76fb4e7e6ca5", description="Transaction ID")
     */
    private string $id;

    /**
     * @OA\Property(type="int", example=10000, description="Amount of transaction in cents")
     */
    private int $amount;

    /**
     * @OA\Property(type="string", example="050eac74-e549-4db1-9ae1-bd83a8827d13", description="Wallet ID")
     */
    private string $wallet;

    /**
     * @OA\Property(type="string", example="2020-02-16T14:30:00+00:00", description="Transaction creation timestamp")
     */
    private string $createdAt;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getWallet(): string
    {
        return $this->wallet;
    }

    public function setWallet(string $wallet): void
    {
        $this->wallet = $wallet;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}