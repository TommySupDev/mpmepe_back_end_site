<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AjouterHeaderAction;
use App\Controller\Delete\DeleteHeaderAction;
use App\InterfacePersonnalise\UserOwnedInterface;
use App\Repository\HeaderRepository;
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

#[ORM\Entity(repositoryClass: HeaderRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Header','read:Entity']],
    denormalizationContext: ['groups' => ['write:Header','write:Entity']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: AjouterHeaderAction::class,
            write: false,
            validationContext: ['groups' => ['Default']],
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
            controller: DeleteHeaderAction::class,
            write: false
        )
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['id', 'name'])]
#[ApiFilter(SearchFilter::class, properties: ['deleted' => 'exact', 'userAjout' => 'exact', 'userModif' => 'exact'])]
class Header implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:Header',
        'read:PageHeader',
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups([
        'read:Header',
        'write:Header',
        'read:PageHeader',
    ])]
    private ?int $position = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:Header',
        'write:Header',
        'read:PageHeader',
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:Header',
        'write:Header',
        'read:PageHeader',
    ])]
    private ?string $affichage = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
        'read:Header',
        'write:Header',
        'read:PageHeader',
    ])]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'header', targetEntity: Menu::class)]
    #[Groups([
        'read:Header',
    ])]
    private Collection $menus;

    #[ORM\Column(nullable: true)]
    private ?int $nbLiaison = null;

    #[ORM\OneToMany(mappedBy: 'header', targetEntity: PageHeader::class)]
    private Collection $pageHeaders;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Header',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Header',
    ])]
    private ?User $userModif = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:Header',
        'write:Header',
        'read:PageHeader',
    ])]
    private ?string $formatPage = null;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->dateAjout = new \DateTimeImmutable();
        $this->dateModif = new \DateTime();
        $this->deleted = "0";
        $this->pageHeaders = new ArrayCollection();
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

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

    public function getAffichage(): ?string
    {
        return $this->affichage;
    }

    public function setAffichage(string $affichage): static
    {
        $this->affichage = $affichage;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): static
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->setHeader($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): static
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getHeader() === $this) {
                $menu->setHeader(null);
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
            $pageHeader->setHeader($this);
        }

        return $this;
    }

    public function removePageHeader(PageHeader $pageHeader): static
    {
        if ($this->pageHeaders->removeElement($pageHeader)) {
            // set the owning side to null (unless already changed)
            if ($pageHeader->getHeader() === $this) {
                $pageHeader->setHeader(null);
            }
        }

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
}
