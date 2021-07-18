<?php

declare(strict_types=1);

namespace App\ViewFactory;

use App\Entity\Transaction;
use App\View\ExpandedTransactionView;
use App\View\TransactionView;

final class TransactionViewFactory
{
    public function createSingle(Transaction $transaction): TransactionView
    {
        $view = new TransactionView();
        $this->fillCommonViewData($view, $transaction);

        return $view;
    }


    public function createSingleExpanded(Transaction $transaction): ExpandedTransactionView {
        $view = new ExpandedTransactionView();

        $this->fillCommonViewData($view, $transaction);

        $view->setDescription($transaction->getDescription());

        $inverseTransaction = $transaction->getInverseTransaction();

        if (null !== $inverseTransaction) {
            $view->setReceivingWallet($inverseTransaction->getWallet()->getId()->toString());
        }

        return $view;
    }

    /**
     * @param Transaction[] $transactions
     * @return TransactionView[]
     */
    public function createCollection(array $transactions): array
    {
        return \array_map([$this, 'createSingle'], $transactions);
    }

    private function fillCommonViewData(TransactionView $view, Transaction $transaction): void {
        $view->setId($transaction->getId()->toString());
        $view->setAmount($transaction->getAmount());
        $view->setWallet($transaction->getWallet()->getId()->toString());
        $view->setCreatedAt($transaction->getCreatedAt()->format(\DateTimeInterface::ATOM));
    }
}