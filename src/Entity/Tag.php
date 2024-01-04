<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\Delete\DeleteTagAction;
use App\InterfacePersonnalise\UserOwnedInterface;
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
use App\Service\ConvertValueToBoolService;
use App\Utils\Traits\EntityTimestampTrait;
use App\Utils\Traits\UserAjoutModifTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Tag','read:Entity']],
    denormalizationContext: ['groups' => ['write:Tag','write:Entity']],
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
            controller: DeleteTagAction::class,
            write: false,
            security: "is_granted('ROLE_ADMIN')",
        )
    ]
)]
#[UniqueEntity(
    fields: 'name'
)]
#[ApiFilter(OrderFilter::class, properties: ['name'])]
#[ApiFilter(SearchFilter::class, properties: ['deleted' => 'exact', 'userAjout' => 'exact', 'userModif' => 'exact'])]
class Tag implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:Tag',
        'read:ArticleTag',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:Tag',
        'write:Tag',
        'read:ArticleTag',
    ])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'tag', targetEntity: ArticleTag::class)]
    private Collection $articleTags;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Tag',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Tag',
    ])]
    private ?User $userModif = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbLiaison = null;

    public function __construct()
    {
        $this->articleTags = new ArrayCollection();
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

    /**
     * @return Collection<int, ArticleTag>
     */
    public function getArticleTags(): Collection
    {
        return $this->articleTags;
    }

    public function addArticleTag(ArticleTag $articleTag): static
    {
        if (!$this->articleTags->contains($articleTag)) {
            $this->articleTags->add($articleTag);
            $articleTag->setTag($this);
        }

        return $this;
    }

    public function removeArticleTag(ArticleTag $articleTag): static
    {
        if ($this->articleTags->removeElement($articleTag)) {
            // set the owning side to null (unless already changed)
            if ($articleTag->getTag() === $this) {
                $articleTag->setTag(null);
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
}
