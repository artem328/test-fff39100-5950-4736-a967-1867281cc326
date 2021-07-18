<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Wallet;

interface WalletRepositoryInterface
{
    /**
     * @returns Wallet[]
     */
    public function getWallets(): array;
}