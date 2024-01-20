<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\FilesRepository;
use App\Service\FileUploader;
use App\Service\RandomStringGeneratorServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class MeAction extends AbstractController
{
    public function __construct(
//        private EntityManagerInterface $entityManager,
//        private FileUploader $fileUploader,
//        private RandomStringGeneratorServices $randomStringGeneratorServices,
//        private FilesRepository $filesRepository,
        private Security $security,
    )
    {
    }

    public function __invoke()
    {
        /** @var User $user */
        $user = $this->security->getUser();

//        if ($user !== null) {
//            // Récupération des fichiers
//            $filePhotoCodeFichier = $this->filesRepository->findOneBy(
//                [
//                    'referenceCode' => $user->getPhotoCodeFichier()
//                ]
//            );
//
//            $fileSelfiePieceCodeFichier = $this->filesRepository->findOneBy(
//                [
//                    'referenceCode' => $user->getSelfiePieceCodeFichier()
//                ]
//            );
//
//            $serverUrl = $this->getParameter('serverUrl');
//
//            $fichiers = [
//                'photo' => $filePhotoCodeFichier ? $serverUrl.$filePhotoCodeFichier->getLocation().$filePhotoCodeFichier->getFilename() : null,
//                'selfiePiece' => $fileSelfiePieceCodeFichier ? $serverUrl.$fileSelfiePieceCodeFichier->getLocation().$fileSelfiePieceCodeFichier->getFilename() : null
//            ];
//            $user->setFichiers($fichiers);
//        }

        return $user;
    }

}
