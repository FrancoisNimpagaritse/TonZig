<?php

namespace App\Event\Loan;

use App\Entity\Loan;
use Symfony\Contracts\EventDispatcher\Event;

class LoanEditedEvent extends Event
{
    protected $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function getLoan()
    {
        return $this->loan;
    }
}