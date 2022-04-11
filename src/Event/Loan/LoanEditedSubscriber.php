<?php

namespace App\Event\Loan;

use App\Entity\MouvementCaisse;
use App\Event\Loan\LoanEditedEvent;
use App\Repository\AccountRepository;
use App\Repository\MouvementCaisseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoanEditedSubscriber implements EventSubscriberInterface
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
            'loan.added' => 'onLoanAdded',
            'loan.edited' => 'onLoanEdited',
            'loan.deleted' => 'onLoanDeleted',
        ];
    }

    public function onLoanAdded(LoanEditedEvent $event)
    {
        $loanAdded = $event->getLoan();

        $mvtAccount = $this->accountRepo->findOneBy(['number' =>  '101']);

        $mvtCaisse = new MouvementCaisse();
        $mvtCaisse->setAccount($mvtAccount)
                  ->setTransactionDate($loanAdded->getDisbursedAt())
                  ->setAmount((-1) * $loanAdded->getAmount())
                  ->setType('Crédit accordé à ' . $loanAdded->getMember())
                  ->setOriginCode('Crédit_' . $loanAdded->getId());

        $this->manager->persist($mvtCaisse);
        $this->manager->flush();
    }

    public function onLoanEdited(LoanEditedEvent $event)
    {
        $loanEdited = $event->getLoan();

        $mvtCaisseToEdit = $this->mvtCaisseRepo->findOneBy(['originCode' => 'Crédit_' . $loanEdited->getId()]);
        
        $mvtCaisseToEdit->setTransactionDate($loanEdited->getDisbursedAt())
                  ->setAmount((-1) * $loanEdited->getAmount())
                  ->setType('Crédit accordé à ' . $loanEdited->getMember());

        $this->manager->flush();
    }

    public function onLoanDeleted(LoanEditedEvent $event)
    {
        $loanDeleted = $event->getLoan();
        $mvtCaisseToDelete = $this->mvtCaisseRepo->findOneBy(['originCode' => 'Crédit_' . $loanDeleted->getId()]);
        $this->manager->remove($mvtCaisseToDelete);
        $this->manager->flush();
    }
}