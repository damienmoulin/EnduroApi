<?php


namespace App\Domain;


class Payment
{
    public ?string $id;
    public ?Contest $contest;
    public ?\DateTime $createdAt;
    public ?\DateTime $paidAt;
    public ?string $paymentState;
    public array $payment = [];
    public ?int $value;

    /**
     * Payment constructor.
     * @param string|null $id
     * @param Contest|null $contest
     * @param \DateTime|null $createdAt
     * @param \DateTime|null $paidAt
     * @param string|null $paymentState
     * @param array $payment
     * @param int|null $value
     */
    public function __construct(
        ?string $id = null,
        ?Contest $contest = null,
        ?\DateTime $createdAt = null,
        ?\DateTime $paidAt = null,
        ?string $paymentState = null,
        array $payment = [],
        ?int $value = null
    )
    {
        $this->id = $id;
        $this->contest = $contest;
        $this->createdAt = $createdAt;
        $this->paidAt = $paidAt;
        $this->paymentState = $paymentState;
        $this->payment = $payment;
        $this->value = $value;
    }


}
