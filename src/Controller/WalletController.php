<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\Type\CreateTransferRequestType;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\WalletRepositoryInterface;
use App\Request\CreateTransferRequest;
use App\Transfer\TransferException;
use App\Transfer\TransferProcessorInterface;
use App\View\ExpandedTransactionView;
use App\View\TransactionView;
use App\View\WalletView;
use App\ViewFactory\TransactionViewFactory;
use App\ViewFactory\WalletViewFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wallets")
 */
final class WalletController
{
    /**
     * @OA\Response(
     *     response=200,
     *     description="Wallets list",
     *     @OA\JsonContent(type="array", items=@OA\Items(ref=@Model(type="App\View\WalletView")))
     * )
     *
     * @Route("", methods={"GET"}, name="wallets_list")
     *
     * @return WalletView[]
     */
    public function list(WalletRepositoryInterface $walletRepository, WalletViewFactory $walletViewFactory): array
    {
        $wallets = $walletRepository->getWallets();

        return $walletViewFactory->createCollection($wallets);
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Transactions list",
     *     @OA\JsonContent(type="array", items=@OA\Items(ref=@Model(type="App\View\TransactionView")))
     * )
     *
     * @Route("/{wallet}/transactions", methods={"GET"}, name="wallets_transactions_list")
     *
     * @return TransactionView[]
     */
    public function transactionList(
        Wallet $wallet,
        TransactionRepositoryInterface $transactionRepository,
        TransactionViewFactory $transactionViewFactory
    ): array {
        $transactions = $transactionRepository->getTransactionsByWallet($wallet);

        return $transactionViewFactory->createCollection($transactions);
    }

    /**
     * @OA\RequestBody(
     *     @Model(type="App\Form\Type\CreateTransferRequestType")
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Created transaction",
     *     @Model(type="App\View\ExpandedTransactionView")
     * )
     *
     * @Route("/{wallet}/transfers", methods={"POST"}, name="wallets_transfers_create")
     */
    public function transfers(
        Request $request,
        Wallet $wallet,
        FormFactoryInterface $formFactory,
        TransferProcessorInterface $transferProcessor,
        TransactionViewFactory $transactionViewFactory
    ): ExpandedTransactionView {
        $createTransferRequest = new CreateTransferRequest($wallet);

        $form = $formFactory->create(CreateTransferRequestType::class, $createTransferRequest);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            throw new BadRequestHttpException('Invalid request');
        }

        try {
            $transaction = $transferProcessor->process($createTransferRequest);
        } catch (TransferException $e) {
            throw new BadRequestHttpException($e->getMessage(), $e);
        }

        return $transactionViewFactory->createSingleExpanded($transaction);
    }
}