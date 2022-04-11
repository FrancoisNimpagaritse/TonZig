<?php

namespace App\Event\Repay;

use App\Entity\MouvementCaisse;
use App\Event\Repay\RepayEditedEvent;
use App\Repository\AccountRepository;
use App\Repository\MouvementCaisseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RepayEditedSubscriber implements EventSubscriberInterface
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
            'repay.added' => 'onRepayAdded',
            'repay.edited' => 'onRepayEdited',
            'repay.deleted' => 'onRepayDeleted',
        ];
    }

    public function onRepayAdded(RepayEditedEvent $event)
    {
        $repayAdded = $event->getRepay();

        $mvtAccount = $this->accountRepo->findOneBy(['number' =>  '101']);

        $mvtCaisse = new MouvementCaisse();
        $mvtCaisse->setAccount($mvtAccount)
                  ->setTransactionDate($repayAdded->getPaidDate())
                  ->setAmount($repayAdded->getPrincipal() + $repayAdded->getInterest() + $repayAdded->getPenality())
                  ->setType('Remboursement crédit n° ' . $repayAdded->getLoan()->getId())
                  ->setOriginCode('Repay_' . $repayAdded->getId());

        $this->manager->persist($mvtCaisse);
        $this->manager->flush();
    }

    public function onRepayEdited(RepayEditedEvent $event)
    {
        $repayEdited = $event->getRepay();

        $mvtCaisseToEdit = $this->mvtCaisseRepo->findOneBy(['originCode' => 'Repay_' . $repayEdited->getId()]);
        
        $mvtCaisseToEdit->setTransactionDate($repayEdited->getPaidDate())
                  ->setAmount($repayEdited->getPrincipal() + $repayEdited->getInterest() + $repayEdited->getPenality())
                  ->setType('Remboursement crédit n° ' . $repayEdited->getLoan()->getId);

        $this->manager->flush();
    }

    public function onRepayDeleted(RepayEditedEvent $event)
    {
        $repayDeleted = $event->getRepay();
        $mvtCaisseToDelete = $this->mvtCaisseRepo->findOneBy(['originCode' => 'Repay_' . $repayDeleted->getId()]);
        $this->manager->remove($mvtCaisseToDelete);
        $this->manager->flush();
    }
}