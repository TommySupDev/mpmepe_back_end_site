<?php

namespace App\Controller;

use ApiPlatform\Symfony\Util\RequestAttributesExtractor;
use App\Entity\Newsletter;
use App\Repository\FilesRepository;
use App\Repository\NewsletterRepository;
use App\Service\FileUploader;
use App\Service\RandomStringGeneratorServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[AsController]
final class DesinscrireNewsletterAction extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private NewsletterRepository $newsletterRepository,
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

        if ($request->attributes->get('data') instanceof Newsletter) {
            /*
            *  On traite ici l'enregistrement dans la base de données
            *  (équivaut à l'attribut de api operation:  write: false)
            */

            /** @var Newsletter $newsletter */
            $newsletter = $request->attributes->get('data');

            // Traitement de la désinscription
            if (!$request->request->get('resourceId')) {
                $emailUser = $newsletter->getEmail();
                $newsletter = $this->newsletterRepository->findOneBy(
                    [
                        'email' => $emailUser
                    ]
                );

                if ($newsletter !== null) {
                    $newsletter->setActif("0");
                    $this->entityManager->flush();
                }

            } // resourceId n'existe pas

            // On retourne un objet
            $dataResult = new \ArrayObject([
                'message' => "Votre désinscription s'est effectuée avec succès."
            ]);
        }

        return $dataResult;
    }

}
