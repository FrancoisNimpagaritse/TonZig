<?php

namespace App\Entity;

use App\Repository\LoanPaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoanPaymentRepository::class)
 */
class LoanPayment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $PaidDate;

    /**
     * @ORM\Column(type="float")
     */
    private $principal;

    /**
     * @ORM\Column(type="float")
     */
    private $interest;

    /**
     * @ORM\Column(type="float")
     */
    private $penality;

    /**
     * @ORM\ManyToOne(targetEntity=Loan::class, inversedBy="payments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $loan;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaidDate(): ?\DateTimeInterface
    {
        return $this->PaidDate;
    }

    public function setPaidDate(\DateTimeInterface $PaidDate): self
    {
        $this->PaidDate = $PaidDate;

        return $this;
    }

    public function getPrincipal(): ?float
    {
        return $this->principal;
    }

    public function setPrincipal(float $principal): self
    {
        $this->principal = $principal;

        return $this;
    }

    public function getInterest(): ?float
    {
        return $this->interest;
    }

    public function setInterest(float $interest): self
    {
        $this->interest = $interest;

        return $this;
    }

    public function getPenality(): ?float
    {
        return $this->penality;
    }

    public function setPenality(float $penality): self
    {
        $this->penality = $penality;

        return $this;
    }

    public function getLoan(): ?Loan
    {
        return $this->loan;
    }

    public function setLoan(?Loan $loan): self
    {
        $this->loan = $loan;

        return $this;
    }
}
