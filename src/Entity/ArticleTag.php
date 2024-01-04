<?php

namespace App\Entity;

use App\Controller\AjouterArticleTagAction;
use App\Repository\ArticleTagRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AjouterArticleAction;
use App\Controller\Delete\DeleteArticleTagAction;
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

#[ORM\Entity(repositoryClass: ArticleTagRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:ArticleTag','read:Entity']],
    denormalizationContext: ['groups' => ['write:ArticleTag','write:Entity']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: AjouterArticleTagAction::class,
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
            controller: DeleteArticleTagAction::class,
            write: false,
            security: "is_granted('ROLE_ADMIN')",
        )
    ]
)]
#[UniqueEntity(
    fields: ['article', 'tag']
)]
#[ApiFilter(OrderFilter::class, properties: ['article', 'tag'])]
#[ApiFilter(SearchFilter::class, properties: [
    'deleted' => 'exact',
    'userAjout' => 'exact',
    'userModif' => 'exact',
    'article' => 'exact',
    'tag' => 'exact',
])]
class ArticleTag implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:ArticleTag',
    ])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'articleTags')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:ArticleTag',
        'write:ArticleTag',
    ])]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'articleTags')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:ArticleTag',
        'write:ArticleTag',
    ])]
    private ?Tag $tag = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:ArticleTag',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:ArticleTag',
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

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): static
    {
        $this->tag = $tag;

        return $this;
    }
}
