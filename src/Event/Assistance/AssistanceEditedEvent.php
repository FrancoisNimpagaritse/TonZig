<?php

namespace App\Event\Assistance;

use App\Entity\Assistance;
use Symfony\Contracts\EventDispatcher\Event;

class AssistanceEditedEvent extends Event
{
    protected $assistance;

    public function __construct(Assistance $assistance)
    {
        $this->assistance = $assistance;
    }

    public function getAssistance()
    {
        return $this->assistance;
    }
}