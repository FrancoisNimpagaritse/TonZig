<?php

namespace App\Event\Sanction;

use App\Entity\AppliedSanction;
use Symfony\Contracts\EventDispatcher\Event;

class AppliedSanctionEditedEvent extends Event
{
    protected $sanction;

    public function __construct(AppliedSanction $sanction)
    {
        $this->sanction = $sanction;
    }

    public function getAppliedSanction()
    {
        return $this->sanction;
    }
}