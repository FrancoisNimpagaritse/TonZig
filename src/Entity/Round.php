<?php

namespace App\Entity;

use App\Repository\RoundRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoundRepository::class)
 */
class Round
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $roundNumber;

    /**
     * @ORM\Column(type="date")
     */
    private $roundStartDate;
    
    /**
     * @ORM\Column(type="float")
     */
    private $monthlyCotisation;

    /**
     * @ORM\Column(type="float")
     */
    private $monthlyCaisseSociale;

    /**
     * @ORM\Column(type="integer")
     */
    private $loanMonthsDuration;

    /**
     * @ORM\Column(type="float")
     */
    private $loanMonthlyInterestPercentage;

    /**
     * @ORM\Column(type="integer")
     */
    private $loanPrincipalGracePeriod;

    /**
     * @ORM\Column(type="integer")
     */
    private $loanInterestGracePeriod;

    /**
     * @ORM\Column(type="float")
     */
    private $principalLatePenalityPercentage;

    /**
     * @ORM\Column(type="float")
     */
    private $interestLatePenalityPercentage;

    /**
     * @ORM\Column(type="float")
     */
    private $meetingLatePenalityAmount;

    /**
     * @ORM\Column(type="float")
     */
    private $meetingAbsencePenalityAmount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $meetingFrequency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $meetingStartHour;

    /**
     * @ORM\OneToMany(targetEntity=Meeting::class, mappedBy="round", orphanRemoval=true)
     */
    private $meetings;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalMeetings;

    public function __construct()
    {
        $this->meetings = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoundNumber(): ?int
    {
        return $this->roundNumber;
    }

    public function setRoundNumber(int $roundNumber): self
    {
        $this->roundNumber = $roundNumber;

        return $this;
    }

    public function getMonthlyCotisation(): ?float
    {
        return $this->monthlyCotisation;
    }

    public function setMonthlyCotisation(float $monthlyCotisation): self
    {
        $this->monthlyCotisation = $monthlyCotisation;

        return $this;
    }

    public function getMonthlyCaisseSociale(): ?float
    {
        return $this->monthlyCaisseSociale;
    }

    public function setMonthlyCaisseSociale(float $monthlyCaisseSociale): self
    {
        $this->monthlyCaisseSociale = $monthlyCaisseSociale;

        return $this;
    }

    public function getLoanMonthsDuration(): ?int
    {
        return $this->loanMonthsDuration;
    }

    public function setLoanMonthsDuration(int $loanMonthsDuration): self
    {
        $this->loanMonthsDuration = $loanMonthsDuration;

        return $this;
    }

    public function getLoanMonthlyInterestPercentage(): ?float
    {
        return $this->loanMonthlyInterestPercentage;
    }

    public function setLoanMonthlyInterestPercentage(float $loanMonthlyInterestPercentage): self
    {
        $this->loanMonthlyInterestPercentage = $loanMonthlyInterestPercentage;

        return $this;
    }

    public function getLoanPrincipalGracePeriod(): ?int
    {
        return $this->loanPrincipalGracePeriod;
    }

    public function setLoanPrincipalGracePeriod(int $loanPrincipalGracePeriod): self
    {
        $this->loanPrincipalGracePeriod = $loanPrincipalGracePeriod;

        return $this;
    }

    public function getLoanInterestGracePeriod(): ?int
    {
        return $this->loanInterestGracePeriod;
    }

    public function setLoanInterestGracePeriod(int $loanInterestGracePeriod): self
    {
        $this->loanInterestGracePeriod = $loanInterestGracePeriod;

        return $this;
    }

    public function getPrincipalLatePenalityPercentage(): ?float
    {
        return $this->principalLatePenalityPercentage;
    }

    public function setPrincipalLatePenalityPercentage(float $principalLatePenalityPercentage): self
    {
        $this->principalLatePenalityPercentage = $principalLatePenalityPercentage;

        return $this;
    }

    public function getInterestLatePenalityPercentage(): ?float
    {
        return $this->interestLatePenalityPercentage;
    }

    public function setInterestLatePenalityPercentage(float $interestLatePenalityPercentage): self
    {
        $this->interestLatePenalityPercentage = $interestLatePenalityPercentage;

        return $this;
    }

    public function getMeetingLatePenalityAmount(): ?float
    {
        return $this->meetingLatePenalityAmount;
    }

    public function setMeetingLatePenalityAmount(float $meetingLatePenalityAmount): self
    {
        $this->meetingLatePenalityAmount = $meetingLatePenalityAmount;

        return $this;
    }

    public function getMeetingAbsencePenalityAmount(): ?float
    {
        return $this->meetingAbsencePenalityAmount;
    }

    public function setMeetingAbsencePenalityAmount(float $meetingAbsencePenalityAmount): self
    {
        $this->meetingAbsencePenalityAmount = $meetingAbsencePenalityAmount;

        return $this;
    }

    public function getMeetingFrequency(): ?string
    {
        return $this->meetingFrequency;
    }

    public function setMeetingFrequency(string $meetingFrequency): self
    {
        $this->meetingFrequency = $meetingFrequency;

        return $this;
    }

    public function getMeetingStartHour(): ?string
    {
        return $this->meetingStartHour;
    }

    public function setMeetingStartHour(string $meetingStartHour): self
    {
        $this->meetingStartHour = $meetingStartHour;

        return $this;
    }

    public function getRoundStartDate(): ?\DateTimeInterface
    {
        return $this->roundStartDate;
    }

    public function setRoundStartDate(\DateTimeInterface $roundStartDate): self
    {
        $this->roundStartDate = $roundStartDate;

        return $this;
    }

    /**
     * @return Collection|Meeting[]
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting): self
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings[] = $meeting;
            $meeting->setRound($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): self
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getRound() === $this) {
                $meeting->setRound(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotalMeetings(): ?int
    {
        return $this->totalMeetings;
    }

    public function setTotalMeetings(?int $totalMeetings): self
    {
        $this->totalMeetings = $totalMeetings;

        return $this;
    }
}
