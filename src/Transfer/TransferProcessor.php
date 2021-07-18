<?php

declare(strict_types=1);

namespace App\Transfer;

use App\Entity\Transaction;
use App\Request\CreateTransferRequest;
use Doctrine\ORM\EntityManagerInterface;

final class TransferProcessor implements TransferProcessorInterface
{
    private const MINIMUM_COMMISSION_FEE = 50;
    private const TRANSFER_COMMISSION_FEE_PERCENT = 0.015;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function process(CreateTransferRequest $request): Transaction
    {
        $amount = $request->getAmount();
        $commissionFee = (int)ceil($amount * self::TRANSFER_COMMISSION_FEE_PERCENT);

        if ($commissionFee < self::MINIMUM_COMMISSION_FEE) {
            $commissionFee = self::MINIMUM_COMMISSION_FEE;
        }

        $senderWallet = $request->getSenderWallet();

        if ($senderWallet->getBalance() < $amount + $commissionFee) {
            throw new TransferException('Insufficient funds');
        }

        $recipientWallet = $request->getRecipientWallet();

        $outgoingTransaction = new Transaction($senderWallet, -$amount);
        $outgoingTransaction->setDescription('Transfer between wallets');
        $commissionFeeTransaction = new Transaction($senderWallet, -$commissionFee);
        $commissionFeeTransaction->setDescription('Commission fee');
        $ingoingTransaction = new Transaction($recipientWallet, $amount);
        $ingoingTransaction->setDescription('Transfer between wallets');

        $senderWallet->setBalance($senderWallet->getBalance() - $amount - $commissionFee);
        $recipientWallet->setBalance($recipientWallet->getBalance() + $amount);

        $outgoingTransaction->setInverseTransaction($ingoingTransaction);
        $ingoingTransaction->setInverseTransaction($outgoingTransaction);

        $this->entityManager->persist($outgoingTransaction);
        $this->entityManager->persist($commissionFeeTransaction);
        $this->entityManager->persist($ingoingTransaction);
        $this->entityManager->persist($senderWallet);
        $this->entityManager->persist($recipientWallet);

        $this->entityManager->flush();

        return $outgoingTransaction;
    }
}