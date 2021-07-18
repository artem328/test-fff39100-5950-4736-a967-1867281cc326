<?php

namespace App\DataFixtures;

use App\Entity\Transaction;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadWalletOne($manager);
        $this->loadWalletTwo($manager);
        $this->loadWalletThree($manager);
        $this->loadWalletFour($manager);

        $manager->flush();
    }

    private function loadWalletOne(ObjectManager $manager): void
    {
        $wallet = new Wallet();
        $wallet->setBalance(30000);

        $transaction = new Transaction($wallet, 30000);
        $transaction->setDescription('Balance replenish');

        $manager->persist($wallet);
        $manager->persist($transaction);
    }

    private function loadWalletTwo(ObjectManager $manager): void
    {
        $wallet = new Wallet();

        $manager->persist($wallet);
    }

    private function loadWalletThree(ObjectManager $manager): void
    {
        $wallet = new Wallet();
        $wallet->setBalance(10000);

        $transactionOne = new Transaction($wallet, 7000);
        $transactionOne->setDescription('Balance replenish');

        $transactionTwo = new Transaction($wallet, 3000);
        $transactionTwo->setDescription('Balance replenish');

        $manager->persist($wallet);
        $manager->persist($transactionOne);
        $manager->persist($transactionTwo);
    }

    private function loadWalletFour(ObjectManager $manager): void
    {
        $wallet = new Wallet();
        $wallet->setBalance(50000);

        $transaction = new Transaction($wallet, 50000);
        $transaction->setDescription('Balance replenish');

        $manager->persist($wallet);
        $manager->persist($transaction);
    }
}
