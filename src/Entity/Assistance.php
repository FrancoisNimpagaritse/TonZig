<?php

namespace App\Entity;

use App\Repository\AssistanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AssistanceRepository::class)
 */
class Assistance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="La date d'octroi est obligatoire")
     */
    private $distributedDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="assistances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beneficiary;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le montant accordé est obligatoire")
     * @Assert\Positive
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le motif de l'assistance est obligatoire")
     */
    private $reason;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDistributedDate(): ?\DateTimeInterface
    {
        return $this->distributedDate;
    }

    public function setDistributedDate(\DateTimeInterface $distributedDate): self
    {
        $this->distributedDate = $distributedDate;

        return $this;
    }

    public function getBeneficiary(): ?User
    {
        return $this->beneficiary;
    }

    public function setBeneficiary(?User $beneficiary): self
    {
        $this->beneficiary = $beneficiary;

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

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }
}
