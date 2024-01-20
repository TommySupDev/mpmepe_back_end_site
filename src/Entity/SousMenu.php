<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\Delete\DeleteSousMenuAction;
use App\Controller\ModifierPositionSousMenuAction;
use App\InterfacePersonnalise\UserOwnedInterface;
use App\Repository\SousMenuRepository;
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
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousMenuRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:SousMenu','read:Entity']],
    denormalizationContext: ['groups' => ['write:SousMenu','write:Entity']],
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
            controller: DeleteSousMenuAction::class,
            write: false
        ),
        new Post(
            name: 'update_position_sous_menus',
            uriTemplate: '/sous_menus/update/positions',
            controller: ModifierPositionSousMenuAction::class,
            deserialize: false,
            validate: false,
            write: false,
            inputFormats: ['json' => ['application/json']],
            security: "is_granted('ROLE_ADMIN')",
            openapiContext: [
                'summary' => "Modifie la position des sous-menus",
            ]
        ),
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['id', 'name'])]
#[ApiFilter(SearchFilter::class, properties: ['deleted' => 'exact', 'userAjout' => 'exact', 'userModif' => 'exact'])]
#[UniqueEntity(
    fields: ['name', 'menu']
)]
class SousMenu implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:SousMenu',
        'read:Header',
        'read:Menu',
        'read:Page',
    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups([
        'read:SousMenu',
        'write:SousMenu',
        'read:Header',
        'read:Menu',
        'read:Page',
    ])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'sousMenus')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:SousMenu',
        'write:SousMenu',
    ])]
    private ?Menu $menu = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:SousMenu',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:SousMenu',
    ])]
    private ?User $userModif = null;

    #[ORM\Column]
    #[Groups([
        'read:SousMenu',
        'write:SousMenu',
        'read:Header',
        'read:Menu',
        'read:Page',
    ])]
    private string|int|null $position = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
        'read:SousMenu',
        'write:SousMenu',
        'read:Header',
        'read:Menu',
        'read:Page',
    ])]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:SousMenu',
        'write:SousMenu',
        'read:Header',
        'read:Menu',
        'read:Page',
    ])]
    private ?string $formatPage = null;

    #[ORM\OneToOne(mappedBy: 'sousMenu')]
    #[Groups([
        'read:SousMenu',
        'read:Header',
        'read:Menu',
    ])]
    private ?Page $page = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): static
    {
        $this->menu = $menu;

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
            $this->page->setSousMenu(null);
        }

        // set the owning side of the relation if necessary
        if ($page !== null && $page->getSousMenu() !== $this) {
            $page->setSousMenu($this);
        }

        $this->page = $page;

        return $this;
    }
}
