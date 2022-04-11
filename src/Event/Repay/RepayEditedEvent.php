<?php

namespace App\Event\Repay;

use App\Entity\LoanPayment;
use Symfony\Contracts\EventDispatcher\Event;

class RepayEditedEvent extends Event
{
    protected $repay;

    public function __construct(LoanPayment $repay)
    {
        $this->repay = $repay;
    }

    public function getRepay()
    {
        return $this->repay;
    }
}