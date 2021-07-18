<?php

declare(strict_types=1);

namespace App\View;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(allOf={@OA\Schema(ref=@Model(type="App\View\TransactionView"))})
 */
final class ExpandedTransactionView extends TransactionView {
    /**
     * @OA\Property(type="string", example="050eac74-e549-4db1-9ae1-bd83a8827d13", description="Nullable. Receiving wallet ID, in case transaction was a transfer.")
     */
    private ?string $receivingWallet = null;

    /**
     * @OA\Property(type="string", example="Commision fee", description="Nullable. Description of the transaction")
     */
    private ?string $description = null;

    public function getReceivingWallet(): ?string
    {
        return $this->receivingWallet;
    }

    public function setReceivingWallet(?string $receivingWallet): void
    {
        $this->receivingWallet = $receivingWallet;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}