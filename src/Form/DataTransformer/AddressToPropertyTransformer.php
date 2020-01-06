<?php


namespace App\Form\DataTransformer;


use App\Entity\Client;
use App\Entity\Property;
use App\Repository\ClientRepository;
use App\Repository\PropertyRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AddressToPropertyTransformer implements DataTransformerInterface
{
    private $propertyRepository;
    private $finderCallback;

    public function __construct(PropertyRepository $propertyRepository, callable $finderCallback)
    {
        $this->propertyRepository = $propertyRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        if (!$value instanceof Property) {
            throw new \LogicException('The PropertySelectType can only be used wiht Property objects');
        }

        return $value->getStreet();
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return;
        }

        $callback = $this->finderCallback;
        $property = $callback($this->propertyRepository, $value);

        if (!$property) {
            throw new TransformationFailedException(sprintf(
                'No client found with email "%s"',
                $value
            ));
        }

        return $property;
    }
}