<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\AjouterNewsletterAction;
use App\Controller\Delete\DeleteNewsletterAction;
use App\Controller\DesinscrireNewsletterAction;
use App\InterfacePersonnalise\UserOwnedInterface;
use App\Repository\NewsletterRepository;
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
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Newsletter','read:Entity']],
    denormalizationContext: ['groups' => ['write:Newsletter','write:Entity']],
    operations: [
        new Get(
            security: "is_granted('ROLE_ADMIN')",
        ),
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')",
        ),
        new Post(
            controller: AjouterNewsletterAction::class,
            write: false,
            validationContext: ['groups' => ['Default']],
            inputFormats: ['multipart' => ['multipart/form-data']],
//            security: "is_granted('ROLE_ADMIN')"
        ),
//        new Put(
//            security: "is_granted('ROLE_ADMIN')"
//        ),
//        new Patch(
//            security: "is_granted('ROLE_ADMIN')"
//        ),
        new Delete(
            controller: DeleteNewsletterAction::class,
            write: false,
            security: "is_granted('ROLE_ADMIN')",
        ),
        new Post(
            name: 'desinscrire_newsletters',
            uriTemplate: '/newsletters/desinscrire',
            controller: DesinscrireNewsletterAction::class,
            validate: false,
            write: false,
            inputFormats: ['multipart' => ['multipart/form-data']],
//            security: "is_granted('ROLE_ADMIN')",
            openapiContext: [
                'summary' => "Permet de se désinscrire de la newsletter",
            ]
        ),
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['id', 'nomPrenom', 'email', 'actif'])]
#[ApiFilter(SearchFilter::class, properties: ['deleted' => 'exact', 'userAjout' => 'exact', 'userModif' => 'exact'])]
#[UniqueEntity(
    fields: ['email']
)]
class Newsletter implements UserOwnedInterface
{
    use EntityTimestampTrait;
    use UserAjoutModifTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:Newsletter',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:Newsletter',
        'write:Newsletter',
    ])]
    private ?string $nomPrenom = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'read:Newsletter',
        'write:Newsletter',
    ])]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:Newsletter',
    ])]
    private string|bool|null $actif = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Newsletter',
    ])]
    private ?User $userAjout = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups([
        'read:Newsletter',
    ])]
    private ?User $userModif = null;

    public function __construct()
    {
        $this->dateAjout = new \DateTimeImmutable();
        $this->dateModif = new \DateTime();
        $this->deleted = "0";
        $this->actif = "1";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nomPrenom;
    }

    public function setNomPrenom(?string $nomPrenom): static
    {
        $this->nomPrenom = $nomPrenom;

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

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(string|bool|null $actif): static
    {
        $this->actif = ConvertValueToBoolService::convertValueToBool($actif);

        return $this;
    }
}
