<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AjouterMenuAction;
use App\Controller\Delete\DeleteMenuAction;
use App\InterfacePersonnalise\UserOwnedInterface;
use App\Repository\MenuRepository;
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
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Menu','read:Entity']],
    denormalizationContext: ['groups' => ['write:Menu','write:Entity']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: AjouterMenuAction::class,
            write: false,
            validationContext: ['groups' => ['Default']],
            inputFormats: ['multipart' => ['multipart/form-data']],
            security: "is_granted('ROLE_ADMIN')"
        ),
//        new Put(
//            security: "is_granted('ROLE_ADMIN')"
//        ),
//        new Patch(
//            security: "is_granted('ROLE_ADMIN')"
//        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')",
            controller: DeleteMenuAction::class,
            write: false
        )
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['id', 'name', 'header'])]
#[ApiFilter(SearchFilter::class, properties: ['deleted' => 'exact', 'userAjout' => 'exact', 'userModif' => 'exact'])]
#[UniqueEntity(
    fields: ['name', 'header']
)]
class Menu implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:Menu',
        'read:Header',
        'read:SousMenu',
        'read:Page',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:Menu',
        'write:Menu',
        'read:Header',
        'read:SousMenu',
        'read:Page',
    ])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'menus')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:Menu',
        'write:Menu',
    ])]
    private ?Header $header = null;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: SousMenu::class)]
    #[Groups([
        'read:Menu',
        'read:Header',
    ])]
    private Collection $sousMenus;

    #[ORM\Column(nullable: true)]
    private ?int $nbLiaison = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
        'read:Menu',
        'write:Menu',
        'read:Header',
        'read:SousMenu',
        'read:Page',
    ])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:Menu',
        'read:Header',
        'read:SousMenu',
        'read:Page',
    ])]
    private ?string $imageCodeFichier = null;

    #[Groups([
        'read:Menu',
        'read:Header',
        'read:SousMenu',
        'read:Page',
    ])]
    public array $fichiers = [];

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Menu',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Menu',
    ])]
    private ?User $userModif = null;

    /**
     * Valeurs possibles: interne, externe
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        'read:Menu',
        'write:Menu',
        'read:Header',
        'read:SousMenu',
        'read:Page',
    ])]
    private ?string $lien = null;

    #[ORM\Column]
    #[Groups([
        'read:Menu',
        'write:Menu',
        'read:Header',
        'read:SousMenu',
        'read:Page',
    ])]
    private string|int|null $position = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
        'read:Menu',
        'write:Menu',
        'read:Header',
        'read:SousMenu',
        'read:Page',
    ])]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:Menu',
        'write:Menu',
        'read:Header',
        'read:SousMenu',
        'read:Page',
    ])]
    private ?string $formatPage = null;

    #[ORM\OneToOne(mappedBy: 'menu')]
    #[Groups([
        'read:Menu',
        'read:Header',
        'read:SousMenu',
    ])]
    private ?Page $page = null;

    public function __construct()
    {
        $this->sousMenus = new ArrayCollection();
        $this->dateAjout = new \DateTimeImmutable();
        $this->dateModif = new \DateTime();
        $this->deleted = "0";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getHeader(): ?Header
    {
        return $this->header;
    }

    public function setHeader(?Header $header): static
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @return Collection<int, SousMenu>
     */
    public function getSousMenus(): Collection
    {
        return $this->sousMenus;
    }

    public function addSousMenu(SousMenu $sousMenu): static
    {
        if (!$this->sousMenus->contains($sousMenu)) {
            $this->sousMenus->add($sousMenu);
            $sousMenu->setMenu($this);
        }

        return $this;
    }

    public function removeSousMenu(SousMenu $sousMenu): static
    {
        if ($this->sousMenus->removeElement($sousMenu)) {
            // set the owning side to null (unless already changed)
            if ($sousMenu->getMenu() === $this) {
                $sousMenu->setMenu(null);
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageCodeFichier(): ?string
    {
        return $this->imageCodeFichier;
    }

    public function setImageCodeFichier(?string $imageCodeFichier): static
    {
        $this->imageCodeFichier = $imageCodeFichier;

        return $this;
    }

    public function getFichiers(): array
    {
        return $this->fichiers;
    }

    public function setFichiers(array $fichiers)
    {
        $this->fichiers = $fichiers;
        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): static
    {
        $this->lien = $lien;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(string|int $position): static
    {
        $this->position = (int) $position;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFormatPage(): ?string
    {
        return $this->formatPage;
    }

    public function setFormatPage(?string $formatPage): static
    {
        $this->formatPage = $formatPage;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): static
    {
        // unset the owning side of the relation if necessary
        if ($page === null && $this->page !== null) {
            $this->page->setMenu(null);
        }

        // set the owning side of the relation if necessary
        if ($page !== null && $page->getMenu() !== $this) {
            $page->setMenu($this);
        }

        $this->page = $page;

        return $this;
    }
}
