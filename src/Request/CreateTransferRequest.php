<?php

declare(strict_types=1);

namespace App\Request;

use App\Entity\Wallet;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateTransferRequest
{
    private Wallet $senderWallet;

    /**
     * @Assert\NotBlank
     */
    private Wallet $recipientWallet;

    /**
     * @Assert\GreaterThan(0)
     */
    private int $amount;

    public function __construct(Wallet $senderWallet)
    {
        $this->senderWallet = $senderWallet;
    }

    public function getSenderWallet(): Wallet
    {
        return $this->senderWallet;
    }

    public function getRecipientWallet(): Wallet
    {
        return $this->recipientWallet;
    }

    public function setRecipientWallet(Wallet $wallet): void
    {
        $this->recipientWallet = $wallet;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}