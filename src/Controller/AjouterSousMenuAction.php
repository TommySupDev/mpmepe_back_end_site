<?php

namespace App\Controller;

use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Symfony\Util\RequestAttributesExtractor;
use App\Entity\SousMenu;
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
final class AjouterSousMenuAction extends AbstractController
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

        if ($request->attributes->get('data') instanceof SousMenu) {
            /*
            *  On traite ici l'enregistrement dans la base de données
            *  (équivaut à l'attribut de api operation:  write: false)
            */

            /** @var SousMenu $sousMenu */
            $sousMenu = $request->attributes->get('data');

            // Nouvel enregistrement
            if (!$request->request->get('resourceId')) {
                $fichierUploades = $request->files->all();

                // Gestion des fichiers
                if ($fichierUploades !== null) {
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
                                SousMenu::class,
                                null,
                                $reference
                            );
                        }

                        $sousMenu->setBackgroundImage($reference);
                    }

                }

                $this->entityManager->persist($sousMenu);
                $this->entityManager->flush();
                $this->entityManager->refresh($sousMenu);

            } // resourceId n'existe pas

            // Modification des informations du sousMenu
            if ($request->request->get('resourceId')) {
                $sousMenu->setId((int) $request->request->get('resourceId'));

                $existSousMenu = $this->entityManager->getRepository(SousMenu::class)
                    ->findOneBy(
                        [
                            'id' => $sousMenu->getId()
                        ]
                    )
                ;

                $attributes = RequestAttributesExtractor::extractAttributes($request);
                $context = $this->serializerContextBuilder->createFromRequest($request, false, $attributes);
                $entitySerialise = $this->serializer->serialize($sousMenu, 'json', []);

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

                if ($existSousMenu) {
                    $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $existSousMenu;
                    $sousMenu = $this->serializer->deserialize($entitySerialise, SousMenu::class, 'json', $context);
                }

                // Gestion des fichiers
                if ($request->files->all() !== null) {
                    // Enregistrement ou modification du backgroundImage
                    if (array_key_exists('backgroundImage', $request->files->all())) {
                        $reference = $sousMenu->getBackgroundImage();

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
                                SousMenu::class,
                                $reference,
                                $reference
                            );
                        }

                        $sousMenu->setBackgroundImage($reference);
                    }

                }  // Fin gestion des fichiers

                $this->entityManager->flush();
                $this->entityManager->refresh($sousMenu);

            } // resourceId existe

            // Récupération des fichiers
            $fileBackgroundImage = $this->filesRepository->findOneBy(
                [
                    'referenceCode' => $sousMenu->getBackgroundImage()
                ]
            );

            $serverUrl = $this->getParameter('serverUrl');

            $fichiers = [
                'backgroundImage' => $fileBackgroundImage ? $serverUrl.$fileBackgroundImage->getLocation().$fileBackgroundImage->getFilename() : null,
            ];
            $sousMenu->setFichiers($fichiers);

            // On retourne un objet
            $data = $sousMenu;
        }

        return $data;
    }

}
