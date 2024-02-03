<?php

namespace App\Controller;

use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Symfony\Util\RequestAttributesExtractor;
use App\Entity\ProgrammeDetail;
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
final class AjouterProgrammeDetailAction extends AbstractController
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

        if ($request->attributes->get('data') instanceof ProgrammeDetail) {
            /*
            *  On traite ici l'enregistrement dans la base de données
            *  (équivaut à l'attribut de api operation:  write: false)
            */

            /** @var ProgrammeDetail $programmeDetail */
            $programmeDetail = $request->attributes->get('data');

            // Nouvel enregistrement
            if (!$request->request->get('resourceId')) {
                $fichierUploades = $request->files->all();

                // Gestion des fichiers
                if ($fichierUploades !== null) {
                    // Enregistrement de l'image
                    if (array_key_exists('image', $fichierUploades)) {
                        // On s'assure que la reference est unique pour ne pas lier d'autres fichiers
                        do {
                            $reference = $this->randomStringGeneratorServices->random_alphanumeric(16);

                            $existFiles = $this->filesRepository->findBy([
                                'referenceCode' => $reference
                            ]);

                        } while (count($existFiles) > 0);

                        if ($fichierUploades['image'] instanceof UploadedFile) {
                            $this->fileUploader->saveFile(
                                $fichierUploades['image'],
                                false,
                                ProgrammeDetail::class,
                                null,
                                $reference
                            );
                        }

                        $programmeDetail->setImage($reference);
                    }

                }

                $this->entityManager->persist($programmeDetail);
                $this->entityManager->flush();
                $this->entityManager->refresh($programmeDetail);

            } // resourceId n'existe pas

            // Modification des informations du programmeDetail
            if ($request->request->get('resourceId')) {
                $programmeDetail->setId((int) $request->request->get('resourceId'));

                $existProgrammeDetail = $this->entityManager->getRepository(ProgrammeDetail::class)
                    ->findOneBy(
                        [
                            'id' => $programmeDetail->getId()
                        ]
                    )
                ;

                $attributes = RequestAttributesExtractor::extractAttributes($request);
                $context = $this->serializerContextBuilder->createFromRequest($request, false, $attributes);
                $entitySerialise = $this->serializer->serialize($programmeDetail, 'json', []);

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

                if ($existProgrammeDetail) {
                    $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $existProgrammeDetail;
                    $programmeDetail = $this->serializer->deserialize($entitySerialise, ProgrammeDetail::class, 'json', $context);
                }

                // Gestion des fichiers
                if ($request->files->all() !== null) {
                    // Enregistrement ou modification de l'image
                    if (array_key_exists('image', $request->files->all())) {
                        $reference = $programmeDetail->getImage();

                        if ($reference === null || trim($reference) === '') {
                            // On s'assure que la reference est unique pour ne pas lier d'autres fichiers
                            do {
                                $reference = $this->randomStringGeneratorServices->random_alphanumeric(16);

                                $existFiles = $this->filesRepository->findBy([
                                    'referenceCode' => $reference
                                ]);

                            } while (count($existFiles) > 0);
                        }

                        if ($request->files->all()['image'] instanceof UploadedFile) {
                            $this->fileUploader->saveFile(
                                $request->files->all()['image'],
                                false,
                                ProgrammeDetail::class,
                                $reference,
                                $reference
                            );
                        }

                        $programmeDetail->setImage($reference);
                    }

                }  // Fin gestion des fichiers

                $this->entityManager->flush();
                $this->entityManager->refresh($programmeDetail);

            } // resourceId existe

            // Récupération des fichiers
            $fileImage = $this->filesRepository->findOneBy(
                [
                    'referenceCode' => $programmeDetail->getImage()
                ]
            );

            $serverUrl = $this->getParameter('serverUrl');

            $fichiers = [
                'image' => $fileImage ? $serverUrl.$fileImage->getLocation().$fileImage->getFilename() : null,
            ];
            $programmeDetail->setFichiers($fichiers);

            // On retourne un objet
            $data = $programmeDetail;
        }

        return $data;
    }

}
