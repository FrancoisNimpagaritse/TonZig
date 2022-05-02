<?php

namespace App\Entity;

use App\Repository\AppliedSanctionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AppliedSanctionRepository::class)
 */
class AppliedSanction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le type de sanction est obligatoire")
     */
    private $sanctionType;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le montant de la sanction est obligatoire")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Meeting::class, inversedBy="appliedSanctions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $meeting;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sanctions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSanctionType(): ?string
    {
        return $this->sanctionType;
    }

    public function setSanctionType(string $sanctionType): self
    {
        $this->sanctionType = $sanctionType;

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

    public function getMeeting(): ?Meeting
    {
        return $this->meeting;
    }

    public function setMeeting(?Meeting $meeting): self
    {
        $this->meeting = $meeting;

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
}
