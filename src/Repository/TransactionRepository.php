<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class TransactionRepository extends ServiceEntityRepository implements TransactionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @inheritDoc
     */
    public function getTransactionsByWallet(Wallet $wallet): array
    {
        $queryBuilder = $this->createQueryBuilder('transaction')
            ->where('transaction.wallet = :wallet')
            ->setParameter('wallet', $wallet)
            ->orderBy('transaction.createdAt', 'DESC')
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    public function saveBatch(Transaction $first, Transaction ...$transactions): void
    {
        \array_unshift($transactions, $first);

        foreach ($transactions as $transaction) {
            $this->getEntityManager()->persist($transactions);
        }

        $this->getEntityManager()->flush();
    }
}