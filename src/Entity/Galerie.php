<?php

namespace App\Entity;

use App\Repository\GalerieRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AjouterGalerieAction;
use App\Controller\Delete\DeleteGalerieAction;
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

#[ORM\Entity(repositoryClass: GalerieRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Galerie','read:Entity']],
    denormalizationContext: ['groups' => ['write:Galerie','write:Entity']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: AjouterGalerieAction::class,
            deserialize: false,
            validate: false,
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
            controller: DeleteGalerieAction::class,
            write: false,
            security: "is_granted('ROLE_ADMIN')",
        )
    ]
)]
#[UniqueEntity(
    fields: ['titre', 'extensionFichier']
)]
#[ApiFilter(OrderFilter::class, properties: ['titre', 'nbTelechargement', 'tailleFichier', 'extensionFichier'])]
#[ApiFilter(SearchFilter::class, properties: ['deleted' => 'exact', 'userAjout' => 'exact', 'userModif' => 'exact'])]
class Galerie implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:Galerie',
        'read:ArticleGalerie',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:Galerie',
        'read:ArticleGalerie',
    ])]
    private ?string $codeFichier = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups([
        'read:Galerie',
        'read:ArticleGalerie',
    ])]
    private ?string $titre = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbLiaison = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:Galerie',
        'read:ArticleGalerie',
    ])]
    private ?float $nbTelechargement = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:Galerie',
        'read:ArticleGalerie',
    ])]
    private ?float $tailleFichier = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:Galerie',
        'read:ArticleGalerie',
    ])]
    private ?string $extensionFichier = null;

    #[ORM\OneToMany(mappedBy: 'galerie', targetEntity: ArticleGalerie::class)]
    private Collection $articleGaleries;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Galerie',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Galerie',
    ])]
    private ?User $userModif = null;

    #[Groups([
        'read:Galerie',
        'read:ArticleGalerie',
    ])]
    public array $fichiers = [];

    public function __construct()
    {
        $this->articleGaleries = new ArrayCollection();
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

    public function getCodeFichier(): ?string
    {
        return $this->codeFichier;
    }

    public function setCodeFichier(?string $codeFichier): static
    {
        $this->codeFichier = $codeFichier;

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

    public function getNbLiaison(): ?int
    {
        return $this->nbLiaison;
    }

    public function setNbLiaison(?int $nbLiaison): static
    {
        $this->nbLiaison = $nbLiaison;

        return $this;
    }

    public function getNbTelechargement(): ?float
    {
        return $this->nbTelechargement;
    }

    public function setNbTelechargement(?float $nbTelechargement): static
    {
        $this->nbTelechargement = $nbTelechargement;

        return $this;
    }

    public function getTailleFichier(): ?float
    {
        return $this->tailleFichier;
    }

    public function setTailleFichier(?float $tailleFichier): static
    {
        $this->tailleFichier = $tailleFichier;

        return $this;
    }

    public function getExtensionFichier(): ?string
    {
        return $this->extensionFichier;
    }

    public function setExtensionFichier(?string $extensionFichier): static
    {
        $this->extensionFichier = $extensionFichier;

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
            $articleGalery->setGalerie($this);
        }

        return $this;
    }

    public function removeArticleGalery(ArticleGalerie $articleGalery): static
    {
        if ($this->articleGaleries->removeElement($articleGalery)) {
            // set the owning side to null (unless already changed)
            if ($articleGalery->getGalerie() === $this) {
                $articleGalery->setGalerie(null);
            }
        }

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

}
