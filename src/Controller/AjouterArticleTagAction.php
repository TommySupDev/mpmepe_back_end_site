<?php

namespace App\Controller;

use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Symfony\Util\RequestAttributesExtractor;
use App\Entity\Article;
use App\Entity\ArticleTag;
use App\Entity\Tag;
use App\Entity\Historique;
use App\Repository\FilesRepository;
use App\Service\FileUploader;
use App\Service\RandomStringGeneratorServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class AjouterArticleTagAction extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FileUploader $fileUploader,
        private RandomStringGeneratorServices $randomStringGeneratorServices,
        private FilesRepository $filesRepository,
        private SerializerInterface $serializer,
        private SerializerContextBuilderInterface $serializerContextBuilder,
    )
    {
    }

    public function __invoke(Request $request): object
    {
        $data = new \stdClass();
        $data->message = "Impossible de désérialiser les données.";

        if (count($request->request->all()) > 1) {
            // Récupération de l'article
            $articleEntrypoint = $request->request->get('article');
            $articleId = explode('/', $articleEntrypoint);
            $articleId = $articleId[(count($articleId) - 1)];

            $article = $this->entityManager
                ->getRepository(Article::class)
                ->find($articleId)
            ;

            // Enregistrement des ArticleTag
            if (isset($request->request->all()['tag'])) {
                foreach ($request->request->all()['tag'] as $d) {
                    if (trim($d) === '') {
                        continue;
                    }

                    $tagId = explode('/', $d);
                    $tagId = $tagId[(count($tagId) - 1)];

                    $tag = $this->entityManager
                        ->getRepository(Tag::class)
                        ->find($tagId)
                    ;

                    $existArticleTag = $this->entityManager
                        ->getRepository(ArticleTag::class)
                        ->findOneBy(
                            [
                                'article' => $article,
                                'tag' => $tag
                            ]
                        )
                    ;

                    if ($existArticleTag === null) {
                        $existArticleTag = (new ArticleTag())
                            ->setArticle($article)
                            ->setTag($tag)
                            ->setUserAjout($this->getUser())
                            ->setUserModif($this->getUser())
                        ;

                        $this->entityManager->persist($existArticleTag);
                        $this->entityManager->flush();

                        // Gestion de nbLiaison et de l'historique
                        $article->setNbLiaison((int) $article->getNbLiaison() + 1);
                        $tag->setNbLiaison((int) $tag->getNbLiaison() + 1);

                        $historique = (new Historique())
                            ->setOperation("Ajout d'un nouvel enregistrement")
                            ->setNomTable("ArticleTag")
                            ->setIdTable($existArticleTag->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);
                    }
                }

                $this->entityManager->flush();
            }

            // On retourne un message
            $data->message = "Les données ont été enregistrées avec succès.";
        }

        return $data;
    }

}
