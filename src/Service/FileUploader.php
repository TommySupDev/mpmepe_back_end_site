<?php

namespace App\Service;

use App\Entity\Files;
use App\Repository\FilesRepository;
use App\Service\GeneraleServices;
use App\Service\RandomStringGeneratorServices;
use App\Utils\Constants\AppConstants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        private SluggerInterface $slugger,
        private EntityManagerInterface $entityManager,
        private FilesRepository $filesRepository,
        private GeneraleServices $generaleServices,
        private RandomStringGeneratorServices $randomStringGeneratorServices,
        private ImageOptimizerService $imageOptimizerService
    )
    {
    }

    public function saveFile(
        UploadedFile $file,
        $temp = false,
        $entityClass = null,
        $existFileCode = null,
        $reference = null,
        $returnFileObj = false,
        $sendByEmail = false,
    )
    {
        // Fichiers à envoyer par mail
        if ($sendByEmail) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            // Get folder location based on entity
            $location = $this->getFileFolderDependOnEntity(null);

            try {
                $file->move($location, $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            return dirname(__FILE__, 3) . '/public/' . $location . $fileName;
        }

        // Remove file from DB & FileFolder if exist
        if ($existFileCode !== null) {
            $existFiles = $this->filesRepository->findBy([
                'referenceCode' => $existFileCode,
            ]);

            foreach ($existFiles as $existFile) {
                try {
                    unlink(dirname(__FILE__, 3) . '/public/' . $existFile->getLocation() . $existFile->getFilename());
                } catch (\Exception) {
                }
                $this->filesRepository->remove($existFile);
            }
        }

        // Create and save new file
        if ($reference === null) {
            $reference = $this->randomStringGeneratorServices->random_alphanumeric_custom_length(16);
        }

        $extension = $file->getClientOriginalExtension();
        $fileNewName = md5(uniqid()) . '.' . $extension;

        // Get folder location based on entity
        $location = $this->getFileFolderDependOnEntity(
            $this->generaleServices->getTableName($entityClass)
        );

        try {
            $file->move($location, $fileNewName);
            // Rédimensionnement de l'image
            $this->imageOptimizerService->resize($location.$fileNewName);

            // Une image ne doit pas dépasser 1Mo
            $unMegaOctet = 1048576;
            while (\filesize($location.$fileNewName) > $unMegaOctet) {
                // Compression de l'image
                $this->compressImage(
                    $location.$fileNewName,
                    $location.$fileNewName,
                    75
                );
            }
        } catch (\Exception) {
        }

        $fileSize = \filesize($location.$fileNewName);

        if ($fileSize === false) {
            $fileSize = 0;
        }

        $file = new Files();
        $file->setFilename($fileNewName);
        $file->setTemp($temp);
        $file->setSize($fileSize);
        $file->setLocation($location);
        $file->setType($extension);
        $file->setReferenceCode($reference);
        $this->entityManager->persist($file);

        if ($returnFileObj) {
            return $file;
        }
        return $reference;
    }

    private function getFileFolderDependOnEntity($entityClass)
    {
        switch ($entityClass) {
            case 'article':
                return AppConstants::ARTICLE_FOLDER;
            case 'ministere':
                return AppConstants::MINISTERE_FOLDER;
            case 'social_network':
                return AppConstants::SOCIAL_NETWORK_FOLDER;
            case 'document':
                return AppConstants::DOCUMENT_FOLDER;
            case 'page':
                return AppConstants::PAGE_FOLDER;
            case 'user':
                return AppConstants::USER_FOLDER;
            case 'galerie':
                return AppConstants::GALERIE_FOLDER;
            case 'dirigeant':
                return AppConstants::DIRIGEANT_FOLDER;
            case 'sous_menu':
                return AppConstants::SOUS_MENU_FOLDER;
            case 'benin_revele':
                return AppConstants::BENIN_REVELE_FOLDER;
            case 'multimedia':
                return AppConstants::MULTIMEDIA_FOLDER;
            case 'prestation':
                return AppConstants::PRESTATION_FOLDER;
            case 'prestation_detail':
                return AppConstants::PRESTATION_DETAIL_FOLDER;
            case 'programme':
                return AppConstants::PROGRAMME_FOLDER;
            case 'programme_detail':
                return AppConstants::PROGRAMME_DETAIL_FOLDER;
            case 'type_direction':
                return AppConstants::TYPE_DIRECTION_FOLDER;
            default:
                return AppConstants::DEFAULT_FOLDER;
        }
    }

    public function getFilesByFileCode(
        string $filesCode,
        string $returnSingleFile = '0'
    )
    {
        if ($returnSingleFile === '1') {
            $singleFile = $this->filesRepository->findOneBy([
                'referenceCode' => $filesCode,
            ]);
            if ($singleFile) {
                return $singleFile->getLocation() . $singleFile->getFilename();
            }
            return $filesCode;
        }

        return $this->filesRepository->findBy([
            'referenceCode' => $filesCode,
        ]);
    }

    /**
     * Custom function to compress image size and
     * upload to the server
     *
     * @param $source  L'image à compresser
     * @param string $destination  L'emplacement final de l'image
     * @param int $quality  Le niveau de compression de l'image (De 0 à 100)
     * @return void
     */
    public function compressImage($source, string $destination, int $quality): void
    {
        // Get image info
        $imgInfo = \getimagesize($source);
        $mime = $imgInfo['mime'];

        // Create a new image from file
        switch ($mime) {
            case 'image/png':
                $image = \imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = \imagecreatefromgif($source);
                break;
            case 'image/jpeg':
            case 'image/jpg':
            default:
                $image = \imagecreatefromjpeg($source);
                break;
        }

        // Save image
        imagejpeg($image, $destination, $quality);
        imagedestroy($image);
    }

}
