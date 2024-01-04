<?php

namespace App\Controller;

use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Symfony\Util\RequestAttributesExtractor;
use App\Entity\Article;
use App\Entity\Document;
use App\Entity\ArticleGalerie;
use App\Entity\CategorieDocument;
use App\Entity\Galerie;
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
final class AjouterArticleGalerieAction extends AbstractController
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

            // Enregistrement des ArticleGalerie
            if (isset($request->request->all()['galerie'])) {
                foreach ($request->request->all()['galerie'] as $d) {
                    if (trim($d) === '') {
                        continue;
                    }

                    $galerieId = explode('/', $d);
                    $galerieId = $galerieId[(count($galerieId) - 1)];

                    $galerie = $this->entityManager
                        ->getRepository(Galerie::class)
                        ->find($galerieId)
                    ;

                    $existArticleGalerie = $this->entityManager
                        ->getRepository(ArticleGalerie::class)
                        ->findOneBy(
                            [
                                'article' => $article,
                                'galerie' => $galerie
                            ]
                        )
                    ;

                    if ($existArticleGalerie === null) {
                        $existArticleGalerie = (new ArticleGalerie())
                            ->setArticle($article)
                            ->setGalerie($galerie)
                            ->setUserAjout($this->getUser())
                            ->setUserModif($this->getUser())
                        ;

                        $this->entityManager->persist($existArticleGalerie);
                        $this->entityManager->flush();

                        // Gestion de nbLiaison et de l'historique
                        $article->setNbLiaison((int) $article->getNbLiaison() + 1);
                        $galerie->setNbLiaison((int) $galerie->getNbLiaison() + 1);

                        $historique = (new Historique())
                            ->setOperation("Ajout d'un nouvel enregistrement")
                            ->setNomTable("ArticleGalerie")
                            ->setIdTable($existArticleGalerie->getId())
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
