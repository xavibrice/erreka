<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setFirstName('Xavier');
        $user->setLastName('Briceño');
        $user->setEmail('xavi@xavi.com');
        $user->setRoles(['ROLE_ADMIN']);

        $password = $this->encoder->encodePassword($user, 'Almi123');
        $user->setPassword($password);

        $user->setCompany(null);
        $user->setActive(true);
        $user->setUsername('xavi');

        $manager->persist($user);

        $manager->flush();
    }
}
