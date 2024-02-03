<?php

namespace App\Controller\Delete;

use App\Entity\PrestationDetail;
use App\Service\ControlDeletionEntityService;
use ArrayObject;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class DeletePrestationDetailAction extends AbstractController
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

        if ($request->attributes->get('data') instanceof PrestationDetail) {
            /** @var PrestationDetail $prestationDetail */
            $prestationDetail = $request->attributes->get('data');

            $this->controlDeletionEntityService->controlDeletion($prestationDetail);

            // On retourne null
            $data = null;
        }

        return $data;
    }
}
