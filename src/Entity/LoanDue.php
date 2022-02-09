<?php

namespace App\Entity;

use App\Repository\LoanDueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoanDueRepository::class)
 */
class LoanDue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dueDate;

    /**
     * @ORM\Column(type="float")
     */
    private $principalDue;

    /**
     * @ORM\Column(type="float")
     */
    private $interestDue;

    /**
     * @ORM\Column(type="float")
     */
    private $penalityDue;

    /**
     * @ORM\ManyToOne(targetEntity=Loan::class, inversedBy="dues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $loan;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getPrincipalDue(): ?float
    {
        return $this->principalDue;
    }

    public function setPrincipalDue(float $principalDue): self
    {
        $this->principalDue = $principalDue;

        return $this;
    }

    public function getInterestDue(): ?float
    {
        return $this->interestDue;
    }

    public function setInterestDue(float $interestDue): self
    {
        $this->interestDue = $interestDue;

        return $this;
    }

    public function getPenalityDue(): ?float
    {
        return $this->penalityDue;
    }

    public function setPenalityDue(float $penalityDue): self
    {
        $this->penalityDue = $penalityDue;

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
