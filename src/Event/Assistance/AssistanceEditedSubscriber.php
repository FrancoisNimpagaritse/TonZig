<?php

namespace App\Event\Assistance;

use App\Entity\MouvementCaisse;
use App\Event\Assistance\AssistanceEditedEvent;
use App\Repository\AccountRepository;
use App\Repository\MouvementCaisseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AssistanceEditedSubscriber implements EventSubscriberInterface
{
    private $manager;
    private $accountRepo;
    private $mvtCaisseRepo;

    public function __construct(EntityManagerInterface $manager, AccountRepository $accountRepo,MouvementCaisseRepository $mvtCaisseRepo)
    {
        $this->manager = $manager;
        $this->accountRepo = $accountRepo;
        $this->mvtCaisseRepo = $mvtCaisseRepo;
    }

    public static function getSubscribedEvents()
    {
        return [
            'assistance.added' => 'onAssistanceAdded',
            'assistance.edited' => 'onAssistanceEdited',
            'assistance.deleted' => 'onAssistanceDeleted',
        ];
    }

    public function onAssistanceAdded(AssistanceEditedEvent $event)
    {
        $assistAdded = $event->getAssistance();

        $mvtAccount = $this->accountRepo->findOneBy(['number' =>  '101']);

        $mvtCaisse = new MouvementCaisse();
        $mvtCaisse->setAccount($mvtAccount)
                  ->setTransactionDate($assistAdded->getDistributedDate())
                  ->setAmount((-1) * $assistAdded->getAmount())
                  ->setType('Assistance sociale accordée à ' . $assistAdded->getBeneficiary() . ' pour ' . $assistAdded->getReason())
                  ->setOriginCode('Assist_' . $assistAdded->getId());

        $this->manager->persist($mvtCaisse);
        $this->manager->flush();
    }

    public function onAssistanceEdited(AssistanceEditedEvent $event)
    {
        $assistEdited = $event->getAssistance();

        $mvtCaisseToEdit = $this->mvtCaisseRepo->findOneBy(['originCode' => 'Assist_' . $assistEdited->getId()]);
        
        $mvtCaisseToEdit->setTransactionDate($assistEdited->getDistributedDate())
                  ->setAmount((-1) * $assistEdited->getAmount())
                  ->setType('Assistance sociale accordée à ' . $assistEdited->getBeneficiary());

        $this->manager->flush();
    }

    public function onAssistanceDeleted(AssistanceEditedEvent $event)
    {
        $assistDeleted = $event->getAssistance();
        $mvtCaisseToDelete = $this->mvtCaisseRepo->findOneBy(['originCode' => 'Assist_' . $assistDeleted->getId()]);
        $this->manager->remove($mvtCaisseToDelete);
        $this->manager->flush();
    }
}