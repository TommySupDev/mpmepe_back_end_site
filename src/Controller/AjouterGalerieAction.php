<?php

namespace App\Controller;

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

#[AsController]
final class AjouterGalerieAction extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FileUploader $fileUploader,
        private RandomStringGeneratorServices $randomStringGeneratorServices,
        private FilesRepository $filesRepository,
    )
    {
    }

    public function __invoke(Request $request): object
    {
        $data = new \stdClass();
        $data->message = "Impossible de désérialiser les données.";

        if (array_key_exists('fichier', $request->files->all())) {
            foreach ($request->files->all()['fichier'] as $fichier) {
                if ($fichier instanceof UploadedFile) {
                    // On s'assure que la reference est unique pour ne pas lier d'autres fichiers
                    do {
                        $reference = $this->randomStringGeneratorServices->random_alphanumeric(16);

                        $existFiles = $this->filesRepository->findBy([
                            'referenceCode' => $reference
                        ]);

                    } while (count($existFiles) > 0);

                    $fileObj = $this->fileUploader->saveFile(
                        $fichier,
                        false,
                        Galerie::class,
                        null,
                        $reference,
                        true
                    );

                    $galerie = (new Galerie())
                        ->setCodeFichier($fileObj->getReferenceCode())
                        ->setTitre($fileObj->getFilename())
                        ->setTailleFichier($fileObj->getSize())
                        ->setExtensionFichier(strtoupper($fileObj->getType()))
                        ->setUserAjout($this->getUser())
                        ->setUserModif($this->getUser())
                    ;

                    $this->entityManager->persist($galerie);
                    $this->entityManager->flush();

                    $historique = (new Historique())
                        ->setOperation("Ajout d'un nouveau fichier")
                        ->setNomTable("Galerie")
                        ->setIdTable($galerie->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);
                }
            }

            $this->entityManager->flush();

            // On retourne un message
            $data->message = "Les fichiers ont été enregistrés avec succès.";
        }

        return $data;
    }

}
