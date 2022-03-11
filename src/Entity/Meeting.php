<?php

namespace App\Entity;

use App\Repository\MeetingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MeetingRepository::class)
 */
class Meeting
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
    private $meetingAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $remainingMeetings;

    /**
     * @ORM\ManyToOne(targetEntity=Round::class, inversedBy="meetings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $round;

    /**
     * @ORM\OneToMany(targetEntity=Cotisation::class, mappedBy="meeting", orphanRemoval=true)
     */
    private $cotisations;

    /**
     * @ORM\OneToMany(targetEntity=CaisseSociale::class, mappedBy="meeting", orphanRemoval=true)
     */
    private $caisseSociales;

    /**
     * @ORM\OneToMany(targetEntity=Loan::class, mappedBy="meeting", orphanRemoval=true)
     */
    private $loans;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="hostedOneMeetings")
     */
    private $hostOne;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="hostedTwoMeetings")
     */
    private $hostTwo;

    /**
     * @ORM\OneToOne(targetEntity=MeetingLotDistribution::class, mappedBy="meeting", cascade={"persist", "remove"})
     */
    private $lotDistribution;

    /**
     * @ORM\OneToMany(targetEntity=AppliedSanction::class, mappedBy="meeting", orphanRemoval=true)
     */
    private $appliedSanctions;

    public function __construct()
    {
        $this->cotisations = new ArrayCollection();
        $this->caisseSociales = new ArrayCollection();
        $this->loans = new ArrayCollection();
        $this->appliedSanctions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeetingAt(): ?\DateTimeInterface
    {
        return $this->meetingAt;
    }

    public function setMeetingAt(\DateTimeInterface $meetingAt): self
    {
        $this->meetingAt = $meetingAt;

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

    public function getRemainingMeetings(): ?int
    {
        return $this->remainingMeetings;
    }

    public function setRemainingMeetings(int $remainingMeetings): self
    {
        $this->remainingMeetings = $remainingMeetings;

        return $this;
    }

    public function getRound(): ?Round
    {
        return $this->round;
    }

    public function setRound(?Round $round): self
    {
        $this->round = $round;

        return $this;
    }

    /**
     * @return Collection|Cotisation[]
     */
    public function getCotisations(): Collection
    {
        return $this->cotisations;
    }

    public function addCotisation(Cotisation $cotisation): self
    {
        if (!$this->cotisations->contains($cotisation)) {
            $this->cotisations[] = $cotisation;
            $cotisation->setMeeting($this);
        }

        return $this;
    }

    public function removeCotisation(Cotisation $cotisation): self
    {
        if ($this->cotisations->removeElement($cotisation)) {
            // set the owning side to null (unless already changed)
            if ($cotisation->getMeeting() === $this) {
                $cotisation->setMeeting(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CaisseSociale[]
     */
    public function getCaisseSociales(): Collection
    {
        return $this->caisseSociales;
    }

    public function addCaisseSociale(CaisseSociale $caisseSociale): self
    {
        if (!$this->caisseSociales->contains($caisseSociale)) {
            $this->caisseSociales[] = $caisseSociale;
            $caisseSociale->setMeeting($this);
        }

        return $this;
    }

    public function removeCaisseSociale(CaisseSociale $caisseSociale): self
    {
        if ($this->caisseSociales->removeElement($caisseSociale)) {
            // set the owning side to null (unless already changed)
            if ($caisseSociale->getMeeting() === $this) {
                $caisseSociale->setMeeting(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Loan[]
     */
    public function getLoans(): Collection
    {
        return $this->loans;
    }

    public function addLoan(Loan $loan): self
    {
        if (!$this->loans->contains($loan)) {
            $this->loans[] = $loan;
            $loan->setMeeting($this);
        }

        return $this;
    }

    public function removeLoan(Loan $loan): self
    {
        if ($this->loans->removeElement($loan)) {
            // set the owning side to null (unless already changed)
            if ($loan->getMeeting() === $this) {
                $loan->setMeeting(null);
            }
        }

        return $this;
    }

    public function getHostOne(): ?User
    {
        return $this->hostOne;
    }

    public function setHostOne(?User $hostOne): self
    {
        $this->hostOne = $hostOne;

        return $this;
    }

    public function getHostTwo(): ?User
    {
        return $this->hostTwo;
    }

    public function setHostTwo(?User $hostTwo): self
    {
        $this->hostTwo = $hostTwo;

        return $this;
    }

    public function getLotDistribution(): ?MeetingLotDistribution
    {
        return $this->lotDistribution;
    }

    public function setLotDistribution(MeetingLotDistribution $lotDistribution): self
    {
        // set the owning side of the relation if necessary
        if ($lotDistribution->getMeeting() !== $this) {
            $lotDistribution->setMeeting($this);
        }

        $this->lotDistribution = $lotDistribution;

        return $this;
    }

    /**
     * @return Collection|AppliedSanction[]
     */
    public function getAppliedSanctions(): Collection
    {
        return $this->appliedSanctions;
    }

    public function addAppliedSanction(AppliedSanction $appliedSanction): self
    {
        if (!$this->appliedSanctions->contains($appliedSanction)) {
            $this->appliedSanctions[] = $appliedSanction;
            $appliedSanction->setMeeting($this);
        }

        return $this;
    }

    public function removeAppliedSanction(AppliedSanction $appliedSanction): self
    {
        if ($this->appliedSanctions->removeElement($appliedSanction)) {
            // set the owning side to null (unless already changed)
            if ($appliedSanction->getMeeting() === $this) {
                $appliedSanction->setMeeting(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return 'Rencontre du: '.$this->getMeetingAt()->format('d-m-Y');
    }
}
