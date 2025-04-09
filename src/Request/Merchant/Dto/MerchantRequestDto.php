<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\Merchant\Dto;

use Hiap\Robokassa\Request\Dto\Receipt;

/**
 * Class MerchantRequestDto
 * @package App\Util\Request\Merchant
 */
readonly class MerchantRequestDto
{
    /**
     * @param int $outSum
     * @param string $description
     * @param int|null $invoiceID
     * @param Receipt|null $receipt
     */
    public function __construct(
        public int $outSum,
        public string $description,
        public ?int $invoiceID = null,
        public ?Receipt $receipt = null
    )
    {
    }


    /**
     * @return int
     */
    public function getOutSum(): int
    {
        return $this->outSum;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int|null
     */
    public function getInvoiceID(): ?int
    {
        return $this->invoiceID;
    }

    /**
     * @return Receipt|null
     */
    public function getReceipt(): ?Receipt
    {
        return $this->receipt;
    }
}
