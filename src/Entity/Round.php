<?php

namespace App\Entity;

use App\Repository\RoundRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Le numéro du round est obligatoire")
     */
    private $roundNumber;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="La date de début est obligatoire")
     */
    private $roundStartDate;
    
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le montant de la cotisation mensuelle du membre est obligatoire")
     */
    private $monthlyCotisation;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le montant de la caisse sociale mensuelle du membre est obligatoire")
     */
    private $monthlyCaisseSociale;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer la durée de remboursement du crédit")
     */
    private $loanMonthsDuration;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Veuillez indiquer lepourcentage des intérêts sur crédit")
     */
    private $loanMonthlyInterestPercentage;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer la durée avant le remboursement du crédit")
     */
    private $loanPrincipalGracePeriod;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez indiquer la durée avant le remboursement des intérêts sur crédit")
     */
    private $loanInterestGracePeriod;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Veuillez indiquer le pourcentage de pénalité sur le crédit en retard")
     */
    private $principalLatePenalityPercentage;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Veuillez indiquer le pourcentage de pénalité sur les intérêts en retard")
     */
    private $interestLatePenalityPercentage;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Veuillez indiquer le montant de pénalité den cas de retard à la rencontre")
     */
    private $meetingLatePenalityAmount;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Veuillez indiquer le montant de pénalité den cas d'absebce à la rencontre")
     */
    private $meetingAbsencePenalityAmount;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer les jours entre deux rencontres")
     */
    private $meetingFrequency;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez indiquer l'heure où commence la rencontre")
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
     * @Assert\NotBlank(message="Veuillez indiquer le nombre total de rencontres pour ce cycle")
     */
    private $totalMeetings;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $roundClosingDate;

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

    public function getRoundClosingDate(): ?\DateTimeInterface
    {
        return $this->roundClosingDate;
    }

    public function setRoundClosingDate(?\DateTimeInterface $roundClosingDate): self
    {
        $this->roundClosingDate = $roundClosingDate;

        return $this;
    }
}
