<?php

namespace App\Controller\Delete;

use App\Entity\Tag;
use App\Service\ControlDeletionEntityService;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class DeleteTagAction extends AbstractController
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

        if ($request->attributes->get('data') instanceof Tag) {
            /** @var Tag $tag */
            $tag = $request->attributes->get('data');

            $this->controlDeletionEntityService->controlDeletion($tag);

            // On retourne null
            $data = null;
        }

        return $data;
    }
}
