<?php

namespace App\Event\Sanction;

use App\Entity\MouvementCaisse;
use App\Event\Sanction\AppliedSanctionEditedEvent;
use App\Repository\AccountRepository;
use App\Repository\MouvementCaisseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AppliedSanctionEditedSubscriber implements EventSubscriberInterface
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
            'appliedSanction.added' => 'onAppliedSanctionAdded',
            'appliedSanction.edited' => 'onAppliedSanctionEdited',
            'appliedSanction.deleted' => 'onAppliedSanctionDeleted',
        ];
    }

    public function onAppliedSanctionAdded(AppliedSanctionEditedEvent $event)
    {
        $sanctionAdded = $event->getAppliedSanction();

        $mvtAccount = $this->accountRepo->findOneBy(['number' =>  '101']);

        $mvtCaisse = new MouvementCaisse();
        $mvtCaisse->setAccount($mvtAccount)
                  ->setTransactionDate($sanctionAdded->getMeeting()->getMeetingAt())
                  ->setAmount($sanctionAdded->getAmount())
                  ->setType('Sanction à ' . $sanctionAdded->getMember() . ' pour ' . $sanctionAdded->getSanctionType())
                  ->setOriginCode('Sanction_' . $sanctionAdded->getId());

        $this->manager->persist($mvtCaisse);
        $this->manager->flush();
    }

    public function onAppliedSanctionEdited(AppliedsanctionEditedEvent $event)
    {
        $sanctionEdited = $event->getAppliedsanction();

        $mvtCaisseToEdit = $this->mvtCaisseRepo->findOneBy(['originCode' => 'Sanction_' . $sanctionEdited->getId()]);
        
        $mvtCaisseToEdit->setTransactionDate($sanctionEdited->getMeeting()->getMeetingAt())
                  ->setAmount($sanctionEdited->getAmount())
                  ->setType('Sanction infligée à ' . $sanctionEdited->getMember() . ' pour ' . $sanctionEdited->getSanctionType());

        $this->manager->flush();
    }

    public function onAppliedSanctionDeleted(AppliedsanctionEditedEvent $event)
    {
        $sanctionDeleted = $event->getAppliedsanction();
        $mvtCaisseToDelete = $this->mvtCaisseRepo->findOneBy(['originCode' => 'Sanction_' . $sanctionDeleted->getId()]);
        $this->manager->remove($mvtCaisseToDelete);
        $this->manager->flush();
    }
}