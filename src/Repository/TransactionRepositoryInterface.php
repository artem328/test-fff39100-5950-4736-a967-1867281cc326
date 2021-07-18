<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\Wallet;

interface TransactionRepositoryInterface
{
    /**
     * @return Transaction[]
     */
    public function getTransactionsByWallet(Wallet $wallet): array;
}