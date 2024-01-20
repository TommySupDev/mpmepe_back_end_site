<?php

namespace App\Serializer;

use App\Entity\Dirigeant;
use App\Repository\FilesRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

final class DirigeantNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'DIRIGEANT_NORMALIZER_ALREADY_CALLED';

    public function __construct(
        private FilesRepository $filesRepository,
        private ParameterBagInterface $parameterBag
    )
    {
    }

    /**
     * @param Dirigeant $object
     * @param string|null $format
     * @param array $context
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $context[self::ALREADY_CALLED] = true;

        $fileImage = $this->filesRepository->findOneBy(
            [
                'referenceCode' => $object->getImageCodeFichier()
            ]
        );

        $serverUrl = $this->parameterBag->get('serverUrl');

        $fichiers = [
            'imageFichier' => $fileImage ? $serverUrl.$fileImage->getLocation().$fileImage->getFilename() : null
        ];

        $object->setFichiers($fichiers);

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Dirigeant && (count($data->getFichiers()) === 0);
    }

}
