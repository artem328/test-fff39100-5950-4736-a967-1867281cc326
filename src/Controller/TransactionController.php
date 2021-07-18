<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Transaction;
use App\View\ExpandedTransactionView;
use App\ViewFactory\TransactionViewFactory;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Route("/transactions")
 */
final class TransactionController
{
    /**
     * @OA\Response(
     *     response=200,
     *     description="Transaction",
     *     @Model(type="App\View\ExpandedTransactionView")
     * )
     *
     * @Route("/{transaction}", methods={"GET"}, name="transactions_get_single")
     */
    public function getSingle(
        Transaction $transaction,
        TransactionViewFactory $transactionViewFactory
    ): ExpandedTransactionView {
        return $transactionViewFactory->createSingleExpanded($transaction);
    }
}