<?php


namespace App\Form\DataTransformer;


use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FullnameToClientTransformer implements DataTransformerInterface
{
    private $clientRepository;
    private $finderCallback;

    public function __construct(ClientRepository $clientRepository, callable $finderCallback)
    {
        $this->clientRepository = $clientRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        if (!$value instanceof Client) {
            throw new \LogicException('The ClientSelectType can only be used wiht Client objects');
        }

        return $value->getFullName();
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return;
        }

        $callback = $this->finderCallback;
        $client = $callback($this->clientRepository, $value);

        if (!$client) {
            throw new TransformationFailedException(sprintf(
                'No client found with email "%s"',
                $value
            ));
        }

        return $client;
    }
}