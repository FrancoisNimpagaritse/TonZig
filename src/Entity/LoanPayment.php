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
    private $paidDate;

    /**
     * @ORM\Column(type="float")
     */
    private $principalPaid;

    /**
     * @ORM\Column(type="float")
     */
    private $interestPaid;

    /**
     * @ORM\Column(type="float")
     */
    private $penalityPaid;

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
        return $this->paidDate;
    }

    public function setPaidDate(\DateTimeInterface $paidDate): self
    {
        $this->paidDate = $paidDate;

        return $this;
    }

    public function getPrincipalPaid(): ?float
    {
        return $this->principalPaid;
    }

    public function setPrincipalPaid(float $principalPaid): self
    {
        $this->principalPaid = $principalPaid;

        return $this;
    }

    public function getInterestPaid(): ?float
    {
        return $this->interestPaid;
    }

    public function setInterestPaid(float $interestPaid): self
    {
        $this->interestPaid = $interestPaid;

        return $this;
    }

    public function getPenalityPaid(): ?float
    {
        return $this->penalityPaid;
    }

    public function setPenalityPaid(float $penalityPaid): self
    {
        $this->penalityPaid = $penalityPaid;

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
