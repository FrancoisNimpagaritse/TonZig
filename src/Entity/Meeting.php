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
     * @ORM\OneToMany(targetEntity=MeetingAppliedSanction::class, mappedBy="meeting", orphanRemoval=true)
     */
    private $meetingAppliedSanctions;

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

    public function __construct()
    {
        $this->cotisations = new ArrayCollection();
        $this->caisseSociales = new ArrayCollection();
        $this->meetingAppliedSanctions = new ArrayCollection();
        $this->loans = new ArrayCollection();
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
     * @return Collection|MeetingAppliedSanction[]
     */
    public function getMeetingAppliedSanctions(): Collection
    {
        return $this->meetingAppliedSanctions;
    }

    public function addMeetingAppliedSanction(MeetingAppliedSanction $meetingAppliedSanction): self
    {
        if (!$this->meetingAppliedSanctions->contains($meetingAppliedSanction)) {
            $this->meetingAppliedSanctions[] = $meetingAppliedSanction;
            $meetingAppliedSanction->setMeeting($this);
        }

        return $this;
    }

    public function removeMeetingAppliedSanction(MeetingAppliedSanction $meetingAppliedSanction): self
    {
        if ($this->meetingAppliedSanctions->removeElement($meetingAppliedSanction)) {
            // set the owning side to null (unless already changed)
            if ($meetingAppliedSanction->getMeeting() === $this) {
                $meetingAppliedSanction->setMeeting(null);
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
}