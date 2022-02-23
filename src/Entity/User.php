<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="date")
     */
    private $registeredAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $suspendedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Cotisation::class, mappedBy="member", orphanRemoval=true)
     */
    private $cotisations;

    /**
     * @ORM\OneToMany(targetEntity=CaisseSociale::class, mappedBy="member", orphanRemoval=true)
     */
    private $caisseSociales;

    /**
     * @ORM\OneToMany(targetEntity=Loan::class, mappedBy="member", orphanRemoval=true)
     */
    private $loans;

    /**
     * @ORM\OneToMany(targetEntity=Meeting::class, mappedBy="hostOne")
     */
    private $hostedOneMeetings;

    /**
     * @ORM\OneToMany(targetEntity=Meeting::class, mappedBy="hostTwo")
     */
    private $hostedTwoMeetings;

    /**
     * @ORM\OneToMany(targetEntity=Assistance::class, mappedBy="beneficiary", orphanRemoval=true)
     */
    private $assistances;

    /**
     * @ORM\OneToMany(targetEntity=AppliedSanction::class, mappedBy="member", orphanRemoval=true)
     */
    private $sanctions;

    public function __construct()
    {
        $this->cotisations = new ArrayCollection();
        $this->caisseSociales = new ArrayCollection();
        $this->meetingAppliedSanctions = new ArrayCollection();
        $this->loans = new ArrayCollection();
        $this->hostedOneMeetings = new ArrayCollection();
        $this->hostedTwoMeetings = new ArrayCollection();
        $this->assistances = new ArrayCollection();
        $this->sanctions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getSuspendedAt(): ?\DateTimeInterface
    {
        return $this->suspendedAt;
    }

    public function setSuspendedAt(?\DateTimeInterface $suspendedAt): self
    {
        $this->suspendedAt = $suspendedAt;

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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

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
            $cotisation->setMember($this);
        }

        return $this;
    }

    public function removeCotisation(Cotisation $cotisation): self
    {
        if ($this->cotisations->removeElement($cotisation)) {
            // set the owning side to null (unless already changed)
            if ($cotisation->getMember() === $this) {
                $cotisation->setMember(null);
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
            $caisseSociale->setMember($this);
        }

        return $this;
    }

    public function removeCaisseSociale(CaisseSociale $caisseSociale): self
    {
        if ($this->caisseSociales->removeElement($caisseSociale)) {
            // set the owning side to null (unless already changed)
            if ($caisseSociale->getMember() === $this) {
                $caisseSociale->setMember(null);
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
            $loan->setMember($this);
        }

        return $this;
    }

    public function removeLoan(Loan $loan): self
    {
        if ($this->loans->removeElement($loan)) {
            // set the owning side to null (unless already changed)
            if ($loan->getMember() === $this) {
                $loan->setMember(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * @return Collection|Meeting[]
     */
    public function getHostedOneMeetings(): Collection
    {
        return $this->hostedOneMeetings;
    }

    public function addHostedOneMeeting(Meeting $hostedOneMeeting): self
    {
        if (!$this->hostedOneMeetings->contains($hostedOneMeeting)) {
            $this->hostedOneMeetings[] = $hostedOneMeeting;
            $hostedOneMeeting->setHostOne($this);
        }

        return $this;
    }

    public function removeHostedOneMeeting(Meeting $hostedOneMeeting): self
    {
        if ($this->hostedOneMeetings->removeElement($hostedOneMeeting)) {
            // set the owning side to null (unless already changed)
            if ($hostedOneMeeting->getHostOne() === $this) {
                $hostedOneMeeting->setHostOne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Meeting[]
     */
    public function getHostedTwoMeetings(): Collection
    {
        return $this->hostedTwoMeetings;
    }

    public function addHostedTwoMeeting(Meeting $hostedTwoMeeting): self
    {
        if (!$this->hostedTwoMeetings->contains($hostedTwoMeeting)) {
            $this->hostedTwoMeetings[] = $hostedTwoMeeting;
            $hostedTwoMeeting->setHostTwo($this);
        }

        return $this;
    }

    public function removeHostedTwoMeeting(Meeting $hostedTwoMeeting): self
    {
        if ($this->hostedTwoMeetings->removeElement($hostedTwoMeeting)) {
            // set the owning side to null (unless already changed)
            if ($hostedTwoMeeting->getHostTwo() === $this) {
                $hostedTwoMeeting->setHostTwo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Assistance[]
     */
    public function getAssistances(): Collection
    {
        return $this->assistances;
    }

    public function addAssistance(Assistance $assistance): self
    {
        if (!$this->assistances->contains($assistance)) {
            $this->assistances[] = $assistance;
            $assistance->setBeneficiary($this);
        }

        return $this;
    }

    public function removeAssistance(Assistance $assistance): self
    {
        if ($this->assistances->removeElement($assistance)) {
            // set the owning side to null (unless already changed)
            if ($assistance->getBeneficiary() === $this) {
                $assistance->setBeneficiary(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AppliedSanction[]
     */
    public function getSanctions(): Collection
    {
        return $this->sanctions;
    }

    public function addSanction(AppliedSanction $sanction): self
    {
        if (!$this->sanctions->contains($sanction)) {
            $this->sanctions[] = $sanction;
            $sanction->setMember($this);
        }

        return $this;
    }

    public function removeSanction(AppliedSanction $sanction): self
    {
        if ($this->sanctions->removeElement($sanction)) {
            // set the owning side to null (unless already changed)
            if ($sanction->getMember() === $this) {
                $sanction->setMember(null);
            }
        }

        return $this;
    }
}
