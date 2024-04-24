<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Article;
use App\Entity\ArticleGalerie;
use App\Entity\Dirigeant;
use App\Entity\Historique;
use App\Entity\Menu;
use App\Entity\Page;
use App\Entity\SousMenu;
use App\Entity\ValeurDemande;
use App\Repository\ArticleRepository;
use App\Repository\NewsletterRepository;
use App\Repository\PageRepository;
use App\Repository\SocialNetworkRepository;
use App\Service\EmailSmsServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiPlatformEventPersonnaliseSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security,
        private EmailSmsServices $emailSmsServices,
        private ArticleRepository $articleRepository,
        private PageRepository $pageRepository,
        private NewsletterRepository $newsletterRepository,
        private SocialNetworkRepository $socialNetworkRepository,
    )
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                ['insertUserAjout', EventPriorities::POST_WRITE],
                ['writeHistorique', EventPriorities::POST_WRITE],
                ['sendNewsletter', EventPriorities::POST_WRITE],
            ]
        ];
    }

    public function insertUserAjout(ViewEvent $event): void
    {
        $entity = $event->getControllerResult();
        $request = $event->getRequest();
        $method = $request->getMethod();

        if ($method !== Request::METHOD_POST) {
            return;
        }

        if (\gettype($entity) !== "object") {
            return;
        }

        $reflectionClass = new \ReflectionClass($entity::class);
        $userAjoutSet = $reflectionClass->hasProperty('userAjout');

        if ($userAjoutSet === true) {
            if (!$request->request->get('resourceId')) {
                // Cas d'un ajout
                $entity->setUserAjout($this->security->getUser());

                $this->entityManager->flush();
                $this->entityManager->refresh($entity);
                $event->setControllerResult($entity);
            }
        }
    }

    public function writeHistorique(ViewEvent $event): void
    {
        $request = $event->getRequest();
        $method = $request->getMethod();

        if ($method === Request::METHOD_GET) {
            return;
        }

        $entity = $event->getControllerResult();

        if ($entity instanceof \stdClass || $entity instanceof \ArrayObject) {
            return;
        }

        if ($method === Request::METHOD_POST) {
            $nomTable = explode('\\', $entity::class);
            $nomTable = $nomTable[(count($nomTable) - 1)];

            $idTable = $entity->getId();

            if (!$request->request->get('resourceId')) {
                // Cas d'un ajout
                $historique = (new Historique())
                    ->setOperation("Ajout d'un nouvel enregistrement")
                    ->setNomTable($nomTable)
                    ->setIdTable($idTable)
                    ->setUser($this->security->getUser())
                ;

                $this->entityManager->persist($historique);

                // Gestion du nbLiaison de Ministere et de Direction
                if ($entity instanceof Dirigeant) {
                    $entity->getMinistere()->setNbLiaison(
                        (int) $entity->getMinistere()->getNbLiaison() + 1
                    );
                    $entity->getDirection()->setNbLiaison(
                        (int) $entity->getDirection()->getNbLiaison() + 1
                    );
                }

                // Gestion du nbLiaison de Header
                if ($entity instanceof Menu) {
                    $entity->getHeader()->setNbLiaison(
                        (int) $entity->getHeader()->getNbLiaison() + 1
                    );
                }

                // Gestion du nbLiaison de Menu
                if ($entity instanceof SousMenu) {
                    $entity->getMenu()->setNbLiaison(
                        (int) $entity->getMenu()->getNbLiaison() + 1
                    );
                }

                // Gestion du nbLiaison de Demande
                if ($entity instanceof ValeurDemande) {
                    $entity->getDemande()->setNbLiaison(
                        (int) $entity->getDemande()->getNbLiaison() + 1
                    );
                }

                $this->entityManager->flush();
                $this->entityManager->refresh($historique);

                // Gestion du nbLiaison de User
                if ($historique->getUser() !== null) {
                    $historique->getUser()->setNbLiaison(
                        (int) $historique->getUser()->getNbLiaison() + 1
                    );
                    $this->entityManager->flush();
                }

            } else {
                // Cas d'une modification
                $historique = (new Historique())
                    ->setOperation("Modification d'un enregistrement")
                    ->setNomTable($nomTable)
                    ->setIdTable($idTable)
                    ->setUser($this->security->getUser())
                ;

                $this->entityManager->persist($historique);
                $this->entityManager->flush();
            }
        }

        if (($method === Request::METHOD_PUT) || ($method === Request::METHOD_PATCH)) {
            $nomTable = explode('\\', $entity::class);
            $nomTable = $nomTable[(count($nomTable) - 1)];

            $idTable = $entity->getId();

            $historique = (new Historique())
                ->setOperation("Modification d'un enregistrement")
                ->setNomTable($nomTable)
                ->setIdTable($idTable)
                ->setUser($this->security->getUser())
            ;

            $this->entityManager->persist($historique);
            $this->entityManager->flush();
        }

        if ($method === Request::METHOD_DELETE) {
            $entity = $request->attributes->get('data');

            if ($entity) {
                $nomTable = explode('\\', $entity::class);
                $nomTable = $nomTable[(count($nomTable) - 1)];

                $idTable = $request->attributes->get('dataEntityRemoveId');

                $historique = (new Historique())
                    ->setOperation("Suppression d'un enregistrement")
                    ->setNomTable($nomTable)
                    ->setIdTable($idTable)
                    ->setUser($this->security->getUser())
                ;

                $this->entityManager->persist($historique);
                $this->entityManager->flush();
            }
        }
    }

    /*
     * Le format pour un article: /actualite/${val.id}/${val.menu.name}
     * Ex: /actualite/20/Communiqués
     * Le format pour une page: /page/${datamenu.slug}/${datamenu.name}/${data.id}/${datamenu.id}
     * Ex: /page/kdzhkjdhz/Programmes%20et%20Projets/4/36
     */
    public function sendNewsletter(ViewEvent $event): void
    {
        $entity = $event->getControllerResult();
        $request = $event->getRequest();
        $method = $request->getMethod();

        if ($method !== Request::METHOD_POST) {
            return;
        }

        if (\gettype($entity) !== "object") {
            return;
        }

        if ($entity instanceof \stdClass || $entity instanceof \ArrayObject) {
            return;
        }

        // Tables concernées par la newsletter: article et page
        if ($entity instanceof Article || $entity instanceof Page) {
            // Cas d'un ajout
            if (!$request->request->get('resourceId')) {
                $destinataires = [];
                $entityArticles = [];
                $entityPages = [];
                $lienFacebook = null;
                $lienInstagram = null;
                $lienLinkedin = null;

                $newslettersEntity = $this->newsletterRepository->findBy(
                    [
                        'deleted' => '0',
                        'actif' => '1',
                    ]
                );

                foreach ($newslettersEntity as $d) {
                    $destinataires[] = trim($d->getEmail());
                }

                if ($entity instanceof Article) {
                    $entityArticles = $this->articleRepository->findBy(
                        [
                            'deleted' => '0'
                        ],
                        [
                            'id' => 'DESC'
                        ],
                        5
                    );
                }

                if ($entity instanceof Page) {
                    $entityPages = $this->pageRepository->findBy(
                        [
                            'deleted' => '0'
                        ],
                        [
                            'id' => 'DESC'
                        ],
                        5
                    );
                }

                $socialNetworksEntity = $this->socialNetworkRepository->findBy(
                    [
                        'deleted' => '0',
                    ]
                );

                $patternFacebook = '/(facebook)+/';
                foreach ($socialNetworksEntity as $d) {
                    if (\preg_match($patternFacebook, mb_strtolower($d->getNom())) === 1) {
                        $lienFacebook = $d;
                        break;
                    }
                }

                $patternInstagram = '/(instagram)+/';
                foreach ($socialNetworksEntity as $d) {
                    if (\preg_match($patternInstagram, mb_strtolower($d->getNom())) === 1) {
                        $lienInstagram = $d;
                        break;
                    }
                }

                $patternLinkedin = '/(linkedin)+/';
                foreach ($socialNetworksEntity as $d) {
                    if (\preg_match($patternLinkedin, mb_strtolower($d->getNom())) === 1) {
                        $lienLinkedin = $d;
                        break;
                    }
                }

                // Email data
                $data = [
                    'emailFrom' => "solutechcorporate@gmail.com",
                    'fromName' => "Automatic Emails",
                    'entityArticles' => $entityArticles,
                    'entityPages' => $entityPages,
                    'lienFacebook' => $lienFacebook,
                    'lienInstagram' => $lienInstagram,
                    'lienLinkedin' => $lienLinkedin,
                ];

                // Send email
                if (\count($destinataires) > 0) {
                    $this->emailSmsServices->sendEmail(
                        $destinataires,
                        'email_templates/newsletter.html.twig',
                        "Nos récentes actualités",
                        $data['emailFrom'],
                        $data['fromName'],
                        $data
                    );
                }

            }
        }
    }

}
