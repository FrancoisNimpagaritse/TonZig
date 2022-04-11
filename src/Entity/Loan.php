<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoanRepository::class)
 */
class Loan
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
    private $disbursedAt;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="loans")
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity=Meeting::class, inversedBy="loans")
     * @ORM\JoinColumn(nullable=false)
     */
    private $meeting;

    /**
     * @ORM\OneToMany(targetEntity=LoanPayment::class, mappedBy="loan", orphanRemoval=true)
     */
    private $payments;

    /**
     * @ORM\OneToMany(targetEntity=LoanDue::class, mappedBy="loan", orphanRemoval=true)
     */
    private $dues;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
        $this->dues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisbursedAt(): ?\DateTimeInterface
    {
        return $this->disbursedAt;
    }

    public function setDisbursedAt(\DateTimeInterface $disbursedAt): self
    {
        $this->disbursedAt = $disbursedAt;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getMember(): ?User
    {
        return $this->member;
    }

    public function setMember(?User $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getMeeting(): ?Meeting
    {
        return $this->meeting;
    }

    public function setMeeting(?Meeting $meeting): self
    {
        $this->meeting = $meeting;

        return $this;
    }

    /**
     * @return Collection|LoanPayment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(LoanPayment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setLoan($this);
        }

        return $this;
    }

    public function removePayment(LoanPayment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getLoan() === $this) {
                $payment->setLoan(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LoanPaymentDue[]
     */
    public function getDues(): Collection
    {
        return $this->dues;
    }

    public function addDue(LoanDue $due): self
    {
        if (!$this->dues->contains($due)) {
            $this->dues[] = $due;
            $due->setLoan($this);
        }

        return $this;
    }

    public function removeDue(LoanDue $due): self
    {
        if ($this->dues->removeElement($due)) {
            // set the owning side to null (unless already changed)
            if ($due->getLoan() === $this) {
                $due->setLoan(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function __toString()
    {
        return $this->getId() . '-' . $this->getMember() . ' : ' . $this->getAmount();
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    //Method to calculate total principal payments made so far
    public function getTotalPrincipalPaid(): float
    {
        $totalPrincipalPaid = 0;
        foreach($this->payments as $payment){
            $totalPrincipalPaid+= $payment->getprincipal();
        }

        return $totalPrincipalPaid;
    }

    //Method to calculate total interest payments made so far
    public function getTotalInterestPaid(): float
    {
        $totalInterestPaid = 0;
        foreach($this->payments as $payment){
            $totalInterestPaid+= $payment->getInterest();
        }

        return $totalInterestPaid;
    }
}
