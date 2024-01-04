<?php

namespace App\Serializer;

use App\Entity\Galerie;
use App\Repository\FilesRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

final class GalerieNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'GALERIE_NORMALIZER_ALREADY_CALLED';

    public function __construct(
        private FilesRepository $filesRepository,
        private ParameterBagInterface $parameterBag
    )
    {
    }

    /**
     * @param Galerie $object
     * @param string|null $format
     * @param array $context
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $context[self::ALREADY_CALLED] = true;

        $fileGalerie = $this->filesRepository->findOneBy(
            [
                'referenceCode' => $object->getCodeFichier()
            ]
        );

        $serverUrl = $this->parameterBag->get('serverUrl');

        $fichiers = [
            'fichier' => $fileGalerie ? $serverUrl.$fileGalerie->getLocation().$fileGalerie->getFilename() : null
        ];

        $object->setFichiers($fichiers);

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Galerie && (count($data->getFichiers()) === 0);
    }

}
