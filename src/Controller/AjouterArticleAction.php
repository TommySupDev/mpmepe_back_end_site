<?php

namespace App\Controller;

use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Symfony\Util\RequestAttributesExtractor;
use App\Entity\Article;
use App\Entity\ArticleGalerie;
use App\Entity\ArticleTag;
use App\Entity\Galerie;
use App\Entity\Historique;
use App\Entity\Tag;
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
final class AjouterArticleAction extends AbstractController
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

        if ($request->attributes->get('data') instanceof Article) {
            /*
            *  On traite ici l'enregistrement dans la base de données
            *  (équivaut à l'attribut de api operation:  write: false)
            */

            /** @var Article $article */
            $article = $request->attributes->get('data');

            // Nouvel enregistrement
            if (!$request->request->get('resourceId')) {
                $fichierUploades = $request->files->all();

                // Gestion des fichiers
                if ($fichierUploades !== null) {
                    // Enregistrement de l'image de l'article
                    if (array_key_exists('imageFichier', $fichierUploades)) {
                        // On s'assure que la reference est unique pour ne pas lier d'autres fichiers
                        do {
                            $reference = $this->randomStringGeneratorServices->random_alphanumeric(16);

                            $existFiles = $this->filesRepository->findBy([
                                'referenceCode' => $reference
                            ]);

                        } while (count($existFiles) > 0);

                        if ($fichierUploades['imageFichier'] instanceof UploadedFile) {
                            $this->fileUploader->saveFile(
                                $fichierUploades['imageFichier'],
                                false,
                                Article::class,
                                null,
                                $reference);
                        }

                        $article->setImageCodeFichier($reference);
                    }

                }

                $this->entityManager->persist($article);
                $this->entityManager->flush();
                $this->entityManager->refresh($article);

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

                        $articleGalerie = (new ArticleGalerie())
                            ->setArticle($article)
                            ->setGalerie($galerie)
                        ;

                        $this->entityManager->persist($articleGalerie);
                        $this->entityManager->flush();

                        // Gestion de nbLiaison et de l'historique
                        $article->setNbLiaison((int) $article->getNbLiaison() + 1);
                        $galerie->setNbLiaison((int) $galerie->getNbLiaison() + 1);

                        $historique = (new Historique())
                            ->setOperation("Ajout d'un nouvel enregistrement")
                            ->setNomTable("ArticleGalerie")
                            ->setIdTable($articleGalerie->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);
                    }

                    $this->entityManager->flush();
                }

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

                        $articleTag = (new ArticleTag())
                            ->setArticle($article)
                            ->setTag($tag)
                        ;

                        $this->entityManager->persist($articleTag);
                        $this->entityManager->flush();

                        // Gestion de nbLiaison et de l'historique
                        $article->setNbLiaison((int) $article->getNbLiaison() + 1);
                        $tag->setNbLiaison((int) $tag->getNbLiaison() + 1);

                        $historique = (new Historique())
                            ->setOperation("Ajout d'un nouvel enregistrement")
                            ->setNomTable("ArticleTag")
                            ->setIdTable($articleTag->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);
                    }

                    $this->entityManager->flush();
                }

            } // resourceId n'existe pas

            // Modification des informations de l'article
            if ($request->request->get('resourceId')) {
                $article->setId((int) $request->request->get('resourceId'));

                $existArticle = $this->entityManager->getRepository(Article::class)
                    ->findOneBy(
                        [
                            'id' => $article->getId()
                        ]
                    )
                ;

                $attributes = RequestAttributesExtractor::extractAttributes($request);
                $context = $this->serializerContextBuilder->createFromRequest($request, false, $attributes);
                $entitySerialise = $this->serializer->serialize($article, 'json', []);

                // Remplacement des valeurs dans $entitySerialise
                $entitySerialise = json_decode($entitySerialise, true);
                foreach ($entitySerialise as $k => $v) {
                    if (\gettype($v) === 'boolean') {
                        $entitySerialise[$k] = $v === true ? "1" : "0";
                    }

                    if (\gettype($v) === 'integer' || \gettype($v) === 'double') {
                        $entitySerialise[$k] = (string) $v;
                    }
                }
                $entitySerialise = json_encode($entitySerialise);

                if ($existArticle) {
                    $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $existArticle;
                    $article = $this->serializer->deserialize($entitySerialise, Article::class, 'json', $context);
                }

                // Gestion des fichiers
                if ($request->files->all() !== null) {
                    // Enregistrement ou modification de l'image de l'article
                    if (array_key_exists('imageFichier', $request->files->all())) {
                        $reference = $article->getImageCodeFichier();

                        if ($reference === null || trim($reference) === '') {
                            // On s'assure que la reference est unique pour ne pas lier d'autres fichiers
                            do {
                                $reference = $this->randomStringGeneratorServices->random_alphanumeric(16);

                                $existFiles = $this->filesRepository->findBy([
                                    'referenceCode' => $reference
                                ]);

                            } while (count($existFiles) > 0);
                        }

                        if ($request->files->all()['imageFichier'] instanceof UploadedFile) {
                            $this->fileUploader->saveFile(
                                $request->files->all()['imageFichier'],
                                false,
                                Article::class,
                                $reference,
                                $reference
                            );
                        }

                        $article->setImageCodeFichier($reference);
                    }

                }  // Fin gestion des fichiers

                $this->entityManager->flush();
                $this->entityManager->refresh($article);

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

            } // resourceId existe

            // Récupération des fichiers
            $fileImage = $this->filesRepository->findOneBy(
                [
                    'referenceCode' => $article->getImageCodeFichier()
                ]
            );

            $serverUrl = $this->getParameter('serverUrl');

            $fichiers = [
                'imageFichier' => $fileImage ? $serverUrl.$fileImage->getLocation().$fileImage->getFilename() : null
            ];
            $article->setFichiers($fichiers);

            // On retourne un objet
            $data = $article;
        }

        return $data;
    }

}
