<?php

namespace App\Serializer;

use App\Entity\SousMenu;
use App\Repository\FilesRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

final class SousMenuNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'SOUS_MENU_NORMALIZER_ALREADY_CALLED';

    public function __construct(
        private FilesRepository $filesRepository,
        private ParameterBagInterface $parameterBag
    )
    {
    }

    /**
     * @param SousMenu $object
     * @param string|null $format
     * @param array $context
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $context[self::ALREADY_CALLED] = true;

        $fileBackgroundImage = $this->filesRepository->findOneBy(
            [
                'referenceCode' => $object->getBackgroundImage()
            ]
        );

        $serverUrl = $this->parameterBag->get('serverUrl');

        $fichiers = [
            'backgroundImage' => $fileBackgroundImage ? $serverUrl.$fileBackgroundImage->getLocation().$fileBackgroundImage->getFilename() : null,
        ];

        $object->setFichiers($fichiers);

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof SousMenu && (count($data->getFichiers()) === 0);
    }

}
