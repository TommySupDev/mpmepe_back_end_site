<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AjouterArticleAction;
use App\Controller\Delete\DeleteArticleAction;
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

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Article','read:Entity']],
    denormalizationContext: ['groups' => ['write:Article','write:Entity']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: AjouterArticleAction::class,
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
            controller: DeleteArticleAction::class,
            write: false,
            security: "is_granted('ROLE_ADMIN')",
        )
    ]
)]
#[UniqueEntity(
    fields: 'titre'
)]
#[ApiFilter(OrderFilter::class, properties: ['titre'])]
#[ApiFilter(SearchFilter::class, properties: [
    'deleted' => 'exact',
    'userAjout' => 'exact',
    'userModif' => 'exact'
])]
class Article implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:Article',
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups([
        'read:Article',
        'write:Article',
    ])]
    private ?string $titre = null;

    #[ORM\Column]
    #[Groups([
        'read:Article',
        'write:Article',
    ])]
    private ?string $contenu = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:Article',
    ])]
    private ?string $imageCodeFichier = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        'read:Article',
        'write:Article',
    ])]
    private ?\DateTimeInterface $dateEvent = null;

    #[ORM\Column]
    #[Groups([
        'read:Article',
        'write:Article',
    ])]
    private string|bool|null $visibility = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        'read:Article',
        'write:Article',
    ])]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column]
    #[Groups([
        'read:Article',
        'write:Article',
    ])]
    private string|bool|null $isMention = null;

    #[ORM\Column]
    #[Groups([
        'read:Article',
        'write:Article',
    ])]
    private string|bool|null $isFlashinfo = null;

    #[ORM\Column]
    #[Groups([
        'read:Article',
        'write:Article',
    ])]
    private string|int|null $category = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbLiaison = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Article',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Article',
    ])]
    private ?User $userModif = null;

    #[Groups([
        'read:Article',
    ])]
    public array $fichiers = [];

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: ArticleGalerie::class)]
    private Collection $articleGaleries;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: ArticleTag::class)]
    private Collection $articleTags;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
        'read:Article',
        'write:Article',
    ])]
    private ?string $slug = null;

    public function __construct()
    {
        $this->articleGaleries = new ArrayCollection();
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

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

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): static
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function isVisibility(): ?bool
    {
        return $this->visibility;
    }

    public function setVisibility(string|bool|null $visibility): static
    {
        $this->visibility = ConvertValueToBoolService::convertValueToBool($visibility);

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function isIsMention(): ?bool
    {
        return $this->isMention;
    }

    public function setIsMention(string|bool|null $isMention): static
    {
        $this->isMention = ConvertValueToBoolService::convertValueToBool($isMention);

        return $this;
    }

    public function isIsFlashinfo(): ?bool
    {
        return $this->isFlashinfo;
    }

    public function setIsFlashinfo(string|bool|null $isFlashinfo): static
    {
        $this->isFlashinfo = ConvertValueToBoolService::convertValueToBool($isFlashinfo);

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(string|int|null $category): static
    {
        $this->category = (int) $category;

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

    /**
     * @return Collection<int, ArticleGalerie>
     */
    public function getArticleGaleries(): Collection
    {
        return $this->articleGaleries;
    }

    public function addArticleGalery(ArticleGalerie $articleGalery): static
    {
        if (!$this->articleGaleries->contains($articleGalery)) {
            $this->articleGaleries->add($articleGalery);
            $articleGalery->setArticle($this);
        }

        return $this;
    }

    public function removeArticleGalery(ArticleGalerie $articleGalery): static
    {
        if ($this->articleGaleries->removeElement($articleGalery)) {
            // set the owning side to null (unless already changed)
            if ($articleGalery->getArticle() === $this) {
                $articleGalery->setArticle(null);
            }
        }

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
            $articleTag->setArticle($this);
        }

        return $this;
    }

    public function removeArticleTag(ArticleTag $articleTag): static
    {
        if ($this->articleTags->removeElement($articleTag)) {
            // set the owning side to null (unless already changed)
            if ($articleTag->getArticle() === $this) {
                $articleTag->setArticle(null);
            }
        }

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

}
