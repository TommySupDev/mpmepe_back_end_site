<?php

namespace App\Controller;

use ApiPlatform\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Symfony\Util\RequestAttributesExtractor;
use App\Entity\Newsletter;
use App\Repository\FilesRepository;
use App\Repository\NewsletterRepository;
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
final class AjouterNewsletterAction extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FileUploader $fileUploader,
        private RandomStringGeneratorServices $randomStringGeneratorServices,
        private FilesRepository $filesRepository,
        private SerializerInterface $serializer,
        private SerializerContextBuilderInterface $serializerContextBuilder,
        private NewsletterRepository $newsletterRepository,
    )
    {
    }

    public function __invoke(Request $request): object
    {
        $data = new \stdClass();
        $data->message = "Impossible de désérialiser les données.";

        if ($request->attributes->get('data') instanceof Newsletter) {
            /*
            *  On traite ici l'enregistrement dans la base de données
            *  (équivaut à l'attribut de api operation:  write: false)
            */

            /** @var Newsletter $newsletter */
            $newsletter = $request->attributes->get('data');

            // Nouvel enregistrement
            if (!$request->request->get('resourceId')) {
                // Contrôle de l'email pour les cas de réinscription
                $emailUser = $newsletter->getEmail();
                $existNewsletter = $this->newsletterRepository->findOneBy(
                    [
                        'email' => $emailUser
                    ]
                );

                if ($existNewsletter !== null) {
                    $existNewsletter->setActif("1");
                    $this->entityManager->flush();
                    $this->entityManager->refresh($existNewsletter);

                    $newsletter = $existNewsletter;
                } else {
                    $this->entityManager->persist($newsletter);
                    $this->entityManager->flush();
                    $this->entityManager->refresh($newsletter);
                }

            } // resourceId n'existe pas

            // Modification des informations du newsletter
            if ($request->request->get('resourceId')) {
                $newsletter->setId((int) $request->request->get('resourceId'));

                $existNewsletter = $this->entityManager->getRepository(Newsletter::class)
                    ->findOneBy(
                        [
                            'id' => $newsletter->getId()
                        ]
                    )
                ;

                $attributes = RequestAttributesExtractor::extractAttributes($request);
                $context = $this->serializerContextBuilder->createFromRequest($request, false, $attributes);
                $entitySerialise = $this->serializer->serialize($newsletter, 'json', []);

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

                if ($existNewsletter) {
                    $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $existNewsletter;
                    $newsletter = $this->serializer->deserialize($entitySerialise, Newsletter::class, 'json', $context);
                }

                $this->entityManager->flush();
                $this->entityManager->refresh($newsletter);

            } // resourceId existe

            // On retourne un objet
            $data = $newsletter;
        }

        return $data;
    }

}
