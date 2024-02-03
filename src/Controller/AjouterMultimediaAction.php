<?php

namespace App\Controller;

use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Symfony\Util\RequestAttributesExtractor;
use App\Entity\Multimedia;
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
final class AjouterMultimediaAction extends AbstractController
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

        if ($request->attributes->get('data') instanceof Multimedia) {
            /*
            *  On traite ici l'enregistrement dans la base de données
            *  (équivaut à l'attribut de api operation:  write: false)
            */

            /** @var Multimedia $multimedia */
            $multimedia = $request->attributes->get('data');

            // Nouvel enregistrement
            if (!$request->request->get('resourceId')) {
                $fichierUploades = $request->files->all();

                // Gestion des fichiers
                if ($fichierUploades !== null) {
                    // Enregistrement du logo du multimedia
                    if (array_key_exists('logo', $fichierUploades)) {
                        // On s'assure que la reference est unique pour ne pas lier d'autres fichiers
                        do {
                            $reference = $this->randomStringGeneratorServices->random_alphanumeric(16);

                            $existFiles = $this->filesRepository->findBy([
                                'referenceCode' => $reference
                            ]);

                        } while (count($existFiles) > 0);

                        if ($fichierUploades['logo'] instanceof UploadedFile) {
                            $this->fileUploader->saveFile(
                                $fichierUploades['logo'],
                                false,
                                Multimedia::class,
                                null,
                                $reference
                            );
                        }

                        $multimedia->setLogo($reference);
                    }

                    // Enregistrement du backgroundImage
                    if (array_key_exists('backgroundImage', $fichierUploades)) {
                        // On s'assure que la reference est unique pour ne pas lier d'autres fichiers
                        do {
                            $reference = $this->randomStringGeneratorServices->random_alphanumeric(16);

                            $existFiles = $this->filesRepository->findBy([
                                'referenceCode' => $reference
                            ]);

                        } while (count($existFiles) > 0);

                        if ($fichierUploades['backgroundImage'] instanceof UploadedFile) {
                            $this->fileUploader->saveFile(
                                $fichierUploades['backgroundImage'],
                                false,
                                Multimedia::class,
                                null,
                                $reference
                            );
                        }

                        $multimedia->setBackgroundImage($reference);
                    }

                }

                $this->entityManager->persist($multimedia);
                $this->entityManager->flush();
                $this->entityManager->refresh($multimedia);

            } // resourceId n'existe pas

            // Modification des informations du multimedia
            if ($request->request->get('resourceId')) {
                $multimedia->setId((int) $request->request->get('resourceId'));

                $existMultimedia = $this->entityManager->getRepository(Multimedia::class)
                    ->findOneBy(
                        [
                            'id' => $multimedia->getId()
                        ]
                    )
                ;

                $attributes = RequestAttributesExtractor::extractAttributes($request);
                $context = $this->serializerContextBuilder->createFromRequest($request, false, $attributes);
                $entitySerialise = $this->serializer->serialize($multimedia, 'json', []);

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

                if ($existMultimedia) {
                    $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $existMultimedia;
                    $multimedia = $this->serializer->deserialize($entitySerialise, Multimedia::class, 'json', $context);
                }

                // Gestion des fichiers
                if ($request->files->all() !== null) {
                    // Enregistrement ou modification du logo du multimedia
                    if (array_key_exists('logo', $request->files->all())) {
                        $reference = $multimedia->getLogo();

                        if ($reference === null || trim($reference) === '') {
                            // On s'assure que la reference est unique pour ne pas lier d'autres fichiers
                            do {
                                $reference = $this->randomStringGeneratorServices->random_alphanumeric(16);

                                $existFiles = $this->filesRepository->findBy([
                                    'referenceCode' => $reference
                                ]);

                            } while (count($existFiles) > 0);
                        }

                        if ($request->files->all()['logo'] instanceof UploadedFile) {
                            $this->fileUploader->saveFile(
                                $request->files->all()['logo'],
                                false,
                                Multimedia::class,
                                $reference,
                                $reference
                            );
                        }

                        $multimedia->setLogo($reference);
                    }

                    // Enregistrement ou modification du backgroundImage
                    if (array_key_exists('backgroundImage', $request->files->all())) {
                        $reference = $multimedia->getBackgroundImage();

                        if ($reference === null || trim($reference) === '') {
                            // On s'assure que la reference est unique pour ne pas lier d'autres fichiers
                            do {
                                $reference = $this->randomStringGeneratorServices->random_alphanumeric(16);

                                $existFiles = $this->filesRepository->findBy([
                                    'referenceCode' => $reference
                                ]);

                            } while (count($existFiles) > 0);
                        }

                        if ($request->files->all()['backgroundImage'] instanceof UploadedFile) {
                            $this->fileUploader->saveFile(
                                $request->files->all()['backgroundImage'],
                                false,
                                Multimedia::class,
                                $reference,
                                $reference
                            );
                        }

                        $multimedia->setBackgroundImage($reference);
                    }

                }  // Fin gestion des fichiers

                $this->entityManager->flush();
                $this->entityManager->refresh($multimedia);

            } // resourceId existe

            // Récupération des fichiers
            $fileLogo = $this->filesRepository->findOneBy(
                [
                    'referenceCode' => $multimedia->getLogo()
                ]
            );

            $fileBackgroundImage = $this->filesRepository->findOneBy(
                [
                    'referenceCode' => $multimedia->getBackgroundImage()
                ]
            );

            $serverUrl = $this->getParameter('serverUrl');

            $fichiers = [
                'logo' => $fileLogo ? $serverUrl.$fileLogo->getLocation().$fileLogo->getFilename() : null,
                'backgroundImage' => $fileBackgroundImage ? $serverUrl.$fileBackgroundImage->getLocation().$fileBackgroundImage->getFilename() : null,
            ];
            $multimedia->setFichiers($fichiers);

            // On retourne un objet
            $data = $multimedia;
        }

        return $data;
    }

}
