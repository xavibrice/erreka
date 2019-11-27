<?php


namespace App\Form\DataTransformer;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FullnameToCommercialTransformer implements DataTransformerInterface
{
    private $userRepository;
    private $finderCallback;

    public function __construct(UserRepository $userRepository, callable $finderCallback)
    {
        $this->userRepository = $userRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        if (!$value instanceof User) {
            throw new \LogicException('The CommercialSelectType can only be used wiht User objects');
        }

        return $value->getFullName();
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return;
        }

        $callback = $this->finderCallback;
        $commercial = $callback($this->userRepository, $value);

        if (!$commercial) {
            throw new TransformationFailedException(sprintf(
                'No se encuentra comercial "%s"',
                $value
            ));
        }

        return $commercial;
    }
}