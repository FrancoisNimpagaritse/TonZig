<?php

namespace App\Entity;

use App\Repository\MeetingLotDistributionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MeetingLotDistributionRepository::class)
 */
class MeetingLotDistribution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $beneficiaires;

    /**
     * @ORM\OneToOne(targetEntity=Meeting::class, inversedBy="lotDistribution", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $meeting;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBeneficiaires(): ?string
    {
        return $this->beneficiaires;
    }

    public function setBeneficiaires(string $beneficiaires): self
    {
        $this->beneficiaires = $beneficiaires;

        return $this;
    }

    public function getMeeting(): ?Meeting
    {
        return $this->meeting;
    }

    public function setMeeting(Meeting $meeting): self
    {
        $this->meeting = $meeting;

        return $this;
    }
}
