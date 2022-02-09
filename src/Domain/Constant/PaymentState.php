<?php


namespace App\Domain\Constant;


class PaymentState
{
    const WAITING = 'waiting';
    const PAID = 'paid';
    const REFUND = 'refund';
    const REFUSE = 'refuse';
}
