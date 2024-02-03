<?php

namespace App\Controller;

use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Symfony\Util\RequestAttributesExtractor;
use App\Entity\Programme;
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
final class AjouterProgrammeAction extends AbstractController
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

        if ($request->attributes->get('data') instanceof Programme) {
            /*
            *  On traite ici l'enregistrement dans la base de données
            *  (équivaut à l'attribut de api operation:  write: false)
            */

            /** @var Programme $programme */
            $programme = $request->attributes->get('data');

            // Nouvel enregistrement
            if (!$request->request->get('resourceId')) {
                $fichierUploades = $request->files->all();

                // Gestion des fichiers
                if ($fichierUploades !== null) {
                    // Enregistrement du logo
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
                                Programme::class,
                                null,
                                $reference
                            );
                        }

                        $programme->setLogo($reference);
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
                                Programme::class,
                                null,
                                $reference
                            );
                        }

                        $programme->setBackgroundImage($reference);
                    }

                }

                $this->entityManager->persist($programme);
                $this->entityManager->flush();
                $this->entityManager->refresh($programme);

            } // resourceId n'existe pas

            // Modification des informations du programme
            if ($request->request->get('resourceId')) {
                $programme->setId((int) $request->request->get('resourceId'));

                $existProgramme = $this->entityManager->getRepository(Programme::class)
                    ->findOneBy(
                        [
                            'id' => $programme->getId()
                        ]
                    )
                ;

                $attributes = RequestAttributesExtractor::extractAttributes($request);
                $context = $this->serializerContextBuilder->createFromRequest($request, false, $attributes);
                $entitySerialise = $this->serializer->serialize($programme, 'json', []);

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

                if ($existProgramme) {
                    $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $existProgramme;
                    $programme = $this->serializer->deserialize($entitySerialise, Programme::class, 'json', $context);
                }

                // Gestion des fichiers
                if ($request->files->all() !== null) {
                    // Enregistrement ou modification du logo
                    if (array_key_exists('logo', $request->files->all())) {
                        $reference = $programme->getLogo();

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
                                Programme::class,
                                $reference,
                                $reference
                            );
                        }

                        $programme->setLogo($reference);
                    }

                    // Enregistrement ou modification du backgroundImage
                    if (array_key_exists('backgroundImage', $request->files->all())) {
                        $reference = $programme->getBackgroundImage();

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
                                Programme::class,
                                $reference,
                                $reference
                            );
                        }

                        $programme->setBackgroundImage($reference);
                    }

                }  // Fin gestion des fichiers

                $this->entityManager->flush();
                $this->entityManager->refresh($programme);

            } // resourceId existe

            // Récupération des fichiers
            $fileLogo = $this->filesRepository->findOneBy(
                [
                    'referenceCode' => $programme->getLogo()
                ]
            );

            $fileBackgroundImage = $this->filesRepository->findOneBy(
                [
                    'referenceCode' => $programme->getBackgroundImage()
                ]
            );

            $serverUrl = $this->getParameter('serverUrl');

            $fichiers = [
                'logo' => $fileLogo ? $serverUrl.$fileLogo->getLocation().$fileLogo->getFilename() : null,
                'backgroundImage' => $fileBackgroundImage ? $serverUrl.$fileBackgroundImage->getLocation().$fileBackgroundImage->getFilename() : null,
            ];
            $programme->setFichiers($fichiers);

            // On retourne un objet
            $data = $programme;
        }

        return $data;
    }

}
