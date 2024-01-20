<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AjouterPageAction;
use App\Controller\Delete\DeletePageAction;
use App\InterfacePersonnalise\UserOwnedInterface;
use App\Repository\PageRepository;
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

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Page','read:Entity']],
    denormalizationContext: ['groups' => ['write:Page','write:Entity']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: AjouterPageAction::class,
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
            controller: DeletePageAction::class,
            write: false
        )
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['id', 'titre'])]
#[ApiFilter(SearchFilter::class, properties: ['deleted' => 'exact', 'userAjout' => 'exact', 'userModif' => 'exact'])]
#[UniqueEntity(
    fields: 'titre'
)]
class Page implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:Page',
        'read:PageHeader',
        'read:Menu',
        'read:SousMenu',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:Page',
        'read:PageHeader',
        'read:Menu',
        'read:SousMenu',
    ])]
    private ?string $imageCodeFichier = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:Page',
        'write:Page',
        'read:PageHeader',
        'read:Menu',
        'read:SousMenu',
    ])]
    private ?string $titre = null;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: PageHeader::class)]
    private Collection $pageHeaders;

    #[ORM\Column(nullable: true)]
    private ?int $nbLiaison = null;

    #[Groups([
        'read:Page',
        'read:PageHeader',
        'read:Menu',
        'read:SousMenu',
    ])]
    public array $fichiers = [];

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Page',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Page',
    ])]
    private ?User $userModif = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
        'read:Page',
        'write:Page',
        'read:PageHeader',
        'read:Menu',
        'read:SousMenu',
    ])]
    private ?string $contenu = null;

    #[ORM\OneToOne(inversedBy: 'page')]
    #[Groups([
        'read:Page',
        'write:Page',
        'read:PageHeader',
    ])]
    private ?Menu $menu = null;

    #[ORM\OneToOne(inversedBy: 'page')]
    #[Groups([
        'read:Page',
        'write:Page',
        'read:PageHeader',
    ])]
    private ?SousMenu $sousMenu = null;

    public function __construct()
    {
        $this->pageHeaders = new ArrayCollection();
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

    public function getImageCodeFichier(): ?string
    {
        return $this->imageCodeFichier;
    }

    public function setImageCodeFichier(string $imageCodeFichier): static
    {
        $this->imageCodeFichier = $imageCodeFichier;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection<int, PageHeader>
     */
    public function getPageHeaders(): Collection
    {
        return $this->pageHeaders;
    }

    public function addPageHeader(PageHeader $pageHeader): static
    {
        if (!$this->pageHeaders->contains($pageHeader)) {
            $this->pageHeaders->add($pageHeader);
            $pageHeader->setPage($this);
        }

        return $this;
    }

    public function removePageHeader(PageHeader $pageHeader): static
    {
        if ($this->pageHeaders->removeElement($pageHeader)) {
            // set the owning side to null (unless already changed)
            if ($pageHeader->getPage() === $this) {
                $pageHeader->setPage(null);
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

    public function getFichiers(): array
    {
        return $this->fichiers;
    }

    public function setFichiers(array $fichiers)
    {
        $this->fichiers = $fichiers;
        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): static
    {
        $this->menu = $menu;

        return $this;
    }

    public function getSousMenu(): ?SousMenu
    {
        return $this->sousMenu;
    }

    public function setSousMenu(?SousMenu $sousMenu): static
    {
        $this->sousMenu = $sousMenu;

        return $this;
    }

}
