<?php

namespace App\Normalizer;

use App\Entity\ImportMovie;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaginationNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer
    )
    {

    }

    /**
     * @inheritDoc
     */
    public function normalize(mixed $object, ?string $format = null, array $context = [])
    {
        if (!($object instanceof PaginationInterface)) {
            throw new \RuntimeException();
        }

        return [
            'items' => array_map(
                fn(ImportMovie $movie) => $this->normalizer->normalize($movie, $format, $context),
                $object->getItems()
            ),
            'total' => $object->getTotalItemCount(),
            'page' => $object->getCurrentPageNumber(),
            'lastPage' => ceil($object->getTotalItemCount() / $object->getItemNumberPerPage()),
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization(mixed $data, ?string $format = null)
    {
        return $data instanceof PaginationInterface && $format === 'json';
    }

    /**
     * @param string|null $format
     * @return true[]
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            PaginationInterface::class => true,
        ];
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method array getSupportedTypes(?string $format)
    }
}