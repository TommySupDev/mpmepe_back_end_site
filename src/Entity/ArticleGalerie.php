<?php

namespace App\Entity;

use App\Controller\AjouterArticleGalerieAction;
use App\Controller\Delete\DeleteArticleGalerieAction;
use App\Repository\ArticleGalerieRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AjouterArticleAction;
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

#[ORM\Entity(repositoryClass: ArticleGalerieRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:ArticleGalerie','read:Entity']],
    denormalizationContext: ['groups' => ['write:ArticleGalerie','write:Entity']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: AjouterArticleGalerieAction::class,
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
            controller: DeleteArticleGalerieAction::class,
            write: false,
            security: "is_granted('ROLE_ADMIN')",
        )
    ]
)]
#[UniqueEntity(
    fields: ['article', 'galerie']
)]
#[ApiFilter(OrderFilter::class, properties: ['article', 'galerie'])]
#[ApiFilter(SearchFilter::class, properties: [
    'deleted' => 'exact',
    'userAjout' => 'exact',
    'userModif' => 'exact',
    'article' => 'exact',
    'galerie' => 'exact',
])]
class ArticleGalerie implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:ArticleGalerie',
    ])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'articleGaleries')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:ArticleGalerie',
        'write:ArticleGalerie',
    ])]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'articleGaleries')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:ArticleGalerie',
        'write:ArticleGalerie',
    ])]
    private ?Galerie $galerie = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:ArticleGalerie',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:ArticleGalerie',
    ])]
    private ?User $userModif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getGalerie(): ?Galerie
    {
        return $this->galerie;
    }

    public function setGalerie(?Galerie $galerie): static
    {
        $this->galerie = $galerie;

        return $this;
    }
}
