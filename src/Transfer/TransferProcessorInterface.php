<?php

declare(strict_types=1);

namespace App\Transfer;

use App\Entity\Transaction;
use App\Request\CreateTransferRequest;

interface TransferProcessorInterface
{
    /**
     * @throws TransferException
     */
    public function process(CreateTransferRequest $request): Transaction;
}