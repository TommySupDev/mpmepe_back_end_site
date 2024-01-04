<?php

namespace App\Controller\Delete;

use App\Entity\ArticleGalerie;
use App\Service\ControlDeletionEntityService;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class DeleteArticleGalerieAction extends AbstractController
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

        if ($request->attributes->get('data') instanceof ArticleGalerie) {
            /** @var ArticleGalerie $articleGalerie */
            $articleGalerie = $request->attributes->get('data');

            $this->controlDeletionEntityService->controlDeletion($articleGalerie);

            // On retourne null
            $data = null;
        }

        return $data;
    }
}
