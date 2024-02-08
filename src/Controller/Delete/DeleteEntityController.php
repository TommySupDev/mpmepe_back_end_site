<?php

namespace App\Controller\Delete;

use App\Entity\Article;
use App\Entity\ArticleGalerie;
use App\Entity\ArticleTag;
use App\Entity\BeninRevele;
use App\Entity\CategorieDocument;
use App\Entity\Contact;
use App\Entity\Copyright;
use App\Entity\Demande;
use App\Entity\Direction;
use App\Entity\Dirigeant;
use App\Entity\Document;
use App\Entity\DocumentCategorieDocument;
use App\Entity\Galerie;
use App\Entity\Header;
use App\Entity\Historique;
use App\Entity\Menu;
use App\Entity\Ministere;
use App\Entity\Multimedia;
use App\Entity\Page;
use App\Entity\PageHeader;
use App\Entity\Prestation;
use App\Entity\PrestationDetail;
use App\Entity\Programme;
use App\Entity\ProgrammeDetail;
use App\Entity\Role;
use App\Entity\SocialNetwork;
use App\Entity\SousMenu;
use App\Entity\Tag;
use App\Entity\TypeDirection;
use App\Entity\User;
use App\Entity\UserRole;
use App\Entity\ValeurDemande;
use App\Service\ControlDeletionEntityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DeleteEntityController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ControlDeletionEntityService $controlDeletionEntityService
    )
    {
    }

    #[Route('/articles/delete', name: 'app_articles_delete', methods: ['DELETE'])]
    public function deleteArticle(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Article::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Article")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Article::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Article")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/article_galeries/delete', name: 'app_article_galeries_delete', methods: ['DELETE'])]
    public function deleteArticleGalerie(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(ArticleGalerie::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("ArticleGalerie")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(ArticleGalerie::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("ArticleGalerie")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/article_tags/delete', name: 'app_article_tags_delete', methods: ['DELETE'])]
    public function deleteArticleTag(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(ArticleTag::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("ArticleTag")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(ArticleTag::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("ArticleTag")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/categorie_documents/delete', name: 'app_categorie_documents_delete', methods: ['DELETE'])]
    public function deleteCategorieDocument(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(CategorieDocument::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("CategorieDocument")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(CategorieDocument::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("CategorieDocument")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/contacts/delete', name: 'app_contacts_delete', methods: ['DELETE'])]
    public function deleteContact(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Contact::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Contact")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Contact::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Contact")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/copyrights/delete', name: 'app_copyrights_delete', methods: ['DELETE'])]
    public function deleteCopyright(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Copyright::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Copyright")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Copyright::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Copyright")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/demandes/delete', name: 'app_demandes_delete', methods: ['DELETE'])]
    public function deleteDemande(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Demande::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Demande")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Demande::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Demande")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/directions/delete', name: 'app_directions_delete', methods: ['DELETE'])]
    public function deleteDirection(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Direction::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Direction")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Direction::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Direction")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/dirigeants/delete', name: 'app_dirigeants_delete', methods: ['DELETE'])]
    public function deleteDirigeant(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Dirigeant::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Dirigeant")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Dirigeant::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Dirigeant")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/document_categorie_documents/delete', name: 'app_document_categorie_documents_delete', methods: ['DELETE'])]
    public function deleteDocumentCategorieDocument(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(DocumentCategorieDocument::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("DocumentCategorieDocument")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(DocumentCategorieDocument::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("DocumentCategorieDocument")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/documents/delete', name: 'app_documents_delete', methods: ['DELETE'])]
    public function deleteDocument(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Document::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Document")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Document::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Document")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/galeries/delete', name: 'app_galeries_delete', methods: ['DELETE'])]
    public function deleteGalerie(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Galerie::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Galerie")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Galerie::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Galerie")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/headers/delete', name: 'app_headers_delete', methods: ['DELETE'])]
    public function deleteHeader(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Header::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Header")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Header::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Header")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/menus/delete', name: 'app_menus_delete', methods: ['DELETE'])]
    public function deleteMenu(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Menu::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Menu")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Menu::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Menu")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/ministeres/delete', name: 'app_ministeres_delete', methods: ['DELETE'])]
    public function deleteMinistere(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Ministere::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Ministere")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Ministere::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Ministere")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/pages/delete', name: 'app_pages_delete', methods: ['DELETE'])]
    public function deletePage(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Page::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Page")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Page::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Page")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/page_headers/delete', name: 'app_page_headers_delete', methods: ['DELETE'])]
    public function deletePageHeader(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(PageHeader::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("PageHeader")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(PageHeader::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("PageHeader")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/roles/delete', name: 'app_roles_delete', methods: ['DELETE'])]
    public function deleteRole(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Role::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Role")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Role::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Role")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/social_networks/delete', name: 'app_social_networks_delete', methods: ['DELETE'])]
    public function deleteSocialNetwork(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(SocialNetwork::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("SocialNetwork")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(SocialNetwork::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("SocialNetwork")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/sous_menus/delete', name: 'app_sous_menus_delete', methods: ['DELETE'])]
    public function deleteSousMenu(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(SousMenu::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("SousMenu")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(SousMenu::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("SousMenu")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/tags/delete', name: 'app_tags_delete', methods: ['DELETE'])]
    public function deleteTag(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Tag::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Tag")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Tag::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Tag")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/users/delete', name: 'app_users_delete', methods: ['DELETE'])]
    public function deleteUser(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(User::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("User")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(User::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("User")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/user_roles/delete', name: 'app_user_roles_delete', methods: ['DELETE'])]
    public function deleteUserRole(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(UserRole::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("UserRole")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(UserRole::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("UserRole")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/valeur_demandes/delete', name: 'app_valeur_demandes_delete', methods: ['DELETE'])]
    public function deleteValeurDemande(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(ValeurDemande::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("ValeurDemande")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(ValeurDemande::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("ValeurDemande")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/benin_reveles/delete', name: 'app_benin_reveles_delete', methods: ['DELETE'])]
    public function deleteBeninRevele(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(BeninRevele::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("BeninRevele")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(BeninRevele::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("BeninRevele")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/multimedias/delete', name: 'app_multimedias_delete', methods: ['DELETE'])]
    public function deleteMultimedia(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Multimedia::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Multimedia")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Multimedia::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Multimedia")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/prestations/delete', name: 'app_prestations_delete', methods: ['DELETE'])]
    public function deletePrestation(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Prestation::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Prestation")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Prestation::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Prestation")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/prestation_details/delete', name: 'app_prestation_details_delete', methods: ['DELETE'])]
    public function deletePrestationDetail(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(PrestationDetail::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("PrestationDetail")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(PrestationDetail::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("PrestationDetail")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/programmes/delete', name: 'app_programmes_delete', methods: ['DELETE'])]
    public function deleteProgramme(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(Programme::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("Programme")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(Programme::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("Programme")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/programme_details/delete', name: 'app_programme_details_delete', methods: ['DELETE'])]
    public function deleteProgrammeDetail(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(ProgrammeDetail::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("ProgrammeDetail")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(ProgrammeDetail::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("ProgrammeDetail")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/type_directions/delete', name: 'app_type_directions_delete', methods: ['DELETE'])]
    public function deleteTypeDirection(Request $request): Response
    {
        if ($request->headers->get('content-type') == "application/json") {
            $requestBodyDecode = json_decode($request->getContent(), true);

            // Récupérer les IDs des entités à supprimer
            $id = null;
            $ids = null;

            if (array_key_exists('id', $requestBodyDecode)) {
                $id = $requestBodyDecode['id'];   // Suppression d'un seul élément
            }

            if (array_key_exists('ids', $requestBodyDecode)) {
                $ids = $requestBodyDecode['ids']; // Suppression groupée
            }

            if ($id !== null && $ids !== null) {
                return new Response(json_encode([
                    'message' => "Mettez soit la clé id ou la clé ids: la présence des deux clés id et ids n'est pas autorisée"
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Si on a des IDs, on supprime en groupé
            if ($ids && \is_array($ids)) {
                foreach ($ids as $idToDelete) {
                    $entity = $this->entityManager
                        ->getRepository(TypeDirection::class)
                        ->find($idToDelete)
                    ;

                    if ($entity) {
                        // Enregistrement dans la table historique
                        $historique = (new Historique())
                            ->setOperation("Suppression d'un enregistrement")
                            ->setNomTable("TypeDirection")
                            ->setIdTable($entity->getId())
                            ->setUser($this->getUser())
                        ;

                        $this->entityManager->persist($historique);

                        // Suppression de l'entité
                        $this->controlDeletionEntityService->controlDeletion($entity);
                    }
                }
            } else if ($id) { // Si on a un seul ID, on supprime cet élément
                $entity = $this->entityManager
                    ->getRepository(TypeDirection::class)
                    ->find($id)
                ;

                if ($entity) {
                    // Enregistrement dans la table historique
                    $historique = (new Historique())
                        ->setOperation("Suppression d'un enregistrement")
                        ->setNomTable("TypeDirection")
                        ->setIdTable($entity->getId())
                        ->setUser($this->getUser())
                    ;

                    $this->entityManager->persist($historique);

                    // Suppression de l'entité
                    $this->controlDeletionEntityService->controlDeletion($entity);
                }
            } else {
                return new Response(json_encode([
                    'message' => 'Paramètres manquants: mettez soit id ou ids'
                ]), Response::HTTP_BAD_REQUEST);
            }

            // Répondre avec une réponse 200 OK ou autre réponse appropriée
            return new Response(json_encode([
                'message' => 'Suppression réussie'
            ]), Response::HTTP_OK);

        } else {
            // Le Content-Type n'est pas application/json
            return new Response(json_encode([
                'message' => 'Le Content-Type doit être: application/json'
            ]), Response::HTTP_BAD_REQUEST);
        }
    }

}
