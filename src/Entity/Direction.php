<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\Delete\DeleteDirectionAction;
use App\InterfacePersonnalise\UserOwnedInterface;
use App\Repository\DirectionRepository;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Utils\Traits\EntityTimestampTrait;
use App\Utils\Traits\UserAjoutModifTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DirectionRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Direction','read:Entity']],
    denormalizationContext: ['groups' => ['write:Direction','write:Entity']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            validationContext: ['groups' => ['Default']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Put(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Patch(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')",
            controller: DeleteDirectionAction::class,
            write: false
        )
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['id', 'libelle'])]
#[ApiFilter(SearchFilter::class, properties: ['deleted' => 'exact', 'userAjout' => 'exact', 'userModif' => 'exact'])]
#[UniqueEntity(
    fields: 'libelle'
)]
class Direction implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:Direction',
        'read:Dirigeant',
        'read:Ministere',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:Direction',
        'write:Direction',
        'read:Dirigeant',
        'read:Ministere',
    ])]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:Direction',
        'write:Direction',
        'read:Dirigeant',
        'read:Ministere',
    ])]
    private ?string $sigle = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:Direction',
        'write:Direction',
        'read:Dirigeant',
        'read:Ministere',
    ])]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:Direction',
        'write:Direction',
        'read:Dirigeant',
        'read:Ministere',
    ])]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'direction', targetEntity: Dirigeant::class)]
    #[Groups([
        'read:Direction',
    ])]
    private Collection $dirigeants;

    #[ORM\Column(nullable: true)]
    private ?int $nbLiaison = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Direction',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Direction',
    ])]
    private ?User $userModif = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
        'read:Direction',
        'write:Direction',
        'read:Dirigeant',
        'read:Ministere',
    ])]
    private ?string $description = null;

    /**
     * Valeurs possibles: central, technique et deconcentre
     */
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:Direction',
        'write:Direction',
        'read:Dirigeant',
        'read:Ministere',
    ])]
    private ?string $categorieDirection = null;

    public function __construct()
    {
        $this->dirigeants = new ArrayCollection();
        $this->dateAjout = new \DateTimeImmutable();
        $this->dateModif = new \DateTime();
        $this->deleted = "0";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(string $sigle): static
    {
        $this->sigle = $sigle;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Dirigeant>
     */
    public function getDirigeants(): Collection
    {
        return $this->dirigeants;
    }

    public function addDirigeant(Dirigeant $dirigeant): static
    {
        if (!$this->dirigeants->contains($dirigeant)) {
            $this->dirigeants->add($dirigeant);
            $dirigeant->setDirection($this);
        }

        return $this;
    }

    public function removeDirigeant(Dirigeant $dirigeant): static
    {
        if ($this->dirigeants->removeElement($dirigeant)) {
            // set the owning side to null (unless already changed)
            if ($dirigeant->getDirection() === $this) {
                $dirigeant->setDirection(null);
            }
        }

        return $this;
    }

    public function getNbLiaison(): ?int
    {
        return $this->nbLiaison;
    }

    public function setNbLiaison(?int $nbLiaison): static
    {
        $this->nbLiaison = $nbLiaison;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorieDirection(): ?string
    {
        return $this->categorieDirection;
    }

    public function setCategorieDirection(?string $categorieDirection): static
    {
        $this->categorieDirection = $categorieDirection;

        return $this;
    }

}
