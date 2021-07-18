<?php

declare(strict_types=1);

namespace App\ViewFactory;

use App\Entity\Wallet;
use App\View\WalletView;

final class WalletViewFactory
{
    public function createSingle(Wallet $wallet): WalletView
    {
        $view = new WalletView();
        $view->setId($wallet->getId()->toString());
        $view->setBalance($wallet->getBalance());

        return $view;
    }

    /**
     * @param Wallet[] $wallets
     * @return WalletView[]
     */
    public function createCollection(array $wallets): array
    {
        return \array_map([$this, 'createSingle'], $wallets);
    }
}