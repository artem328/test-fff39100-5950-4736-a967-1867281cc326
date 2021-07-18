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
     * @OA\Property(type="string", example="050eac74-e549-4db1-9ae1-bd83a8827d13", description="Nullable. Receiving/sending wallet ID, in case transaction was a transfer.")
     */
    private ?string $relatedWallet = null;

    public function getRelatedWallet(): ?string
    {
        return $this->relatedWallet;
    }

    public function setRelatedWallet(?string $relatedWallet): void
    {
        $this->relatedWallet = $relatedWallet;
    }
}