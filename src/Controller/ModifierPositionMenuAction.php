<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Historique;
use App\Repository\FilesRepository;
use App\Service\FileUploader;
use App\Service\RandomStringGeneratorServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class ModifierPositionMenuAction extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
//        private FileUploader $fileUploader,
//        private RandomStringGeneratorServices $randomStringGeneratorServices,
//        private FilesRepository $filesRepository,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $dataResult = new \ArrayObject([
            'message' => "Impossible de désérialiser les données."
        ]);

        $requestBodyDecode = json_decode($request->getContent(), true);

        if (count($requestBodyDecode) > 0) {
            foreach ($requestBodyDecode as $data) {
                if (array_key_exists('id', $data) && array_key_exists('position', $data)) {
                    $entity = $this->entityManager
                        ->getRepository(Menu::class)
                        ->find($data['id'])
                    ;

                    if ($entity !== null) {
                        $entity->setPosition((int) $data['position']);

                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Mise à jour de la position")
                            ->setNomTable("Menu")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);
                    }
                }
            }

            $this->entityManager->flush();

            $dataResult = new \ArrayObject([
                'message' => "Mise à jour des positions effectuée avec succès."
            ]);
        }

        return $dataResult;
    }

}
