<?php

namespace App\Controller\Delete;

use App\Entity\ArticleTag;
use App\Service\ControlDeletionEntityService;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class DeleteArticleTagAction extends AbstractController
{
    public function __construct(
        private ControlDeletionEntityService $controlDeletionEntityService
    )
    {
    }

    /**
     * @throws ReflectionException
     */
    public function __invoke(Request $request): object|null
    {
        $data = new \stdClass();
        $data->message = "Impossible de supprimer la ressource.";

        if ($request->attributes->get('data') instanceof ArticleTag) {
            /** @var ArticleTag $articleTag */
            $articleTag = $request->attributes->get('data');

            $this->controlDeletionEntityService->controlDeletion($articleTag);

            // On retourne null
            $data = null;
        }

        return $data;
    }
}
