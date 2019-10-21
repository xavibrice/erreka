<?php

namespace App\DataFixtures;

use App\Entity\Situation;
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
        $this->loadUser($manager);
        $this->loadSituation($manager);
    }

    private function loadSituation(ObjectManager $manager): void
    {
        foreach ($this->getNameSituation() as $name) {
            $situation = new Situation();
            $situation->setName($name);
            $manager->persist($situation);
        }
        $manager->flush();
    }
    
    private function getSituationData()
    {
        $situations = [];
        foreach ($this->getNameSituation() as $i => $name) {
            $situations[] = [
                $name
            ];
        }
    }

    private function getNameSituation(): array
    {
        return [
            'Noticia',
            'Noticia a desarrollar',
        ];
    }

    private function loadUser(ObjectManager $manager):void
    {

        foreach ($this->getUserData() as [$first_name, $last_name, $username, $state, $role, $mobile, $pass]) {
            $user = new User();
            $user->setFirstName($first_name);
            $user->setLastName($last_name);
            $user->setRoles($role);
            $user->setMobile($mobile);

            $password = $this->encoder->encodePassword($user, $pass);
            $user->setPassword($password);

            $user->setCompany(null);
            $user->setActive($state);
            $user->setUsername($username);
            $manager->persist($user);

            $manager->flush();
        }
    }

    private function getUserData(): array
    {
        return [
            ['Xavier', 'Briceño', 'admin', true, ['ROLE_ADMIN'], '666666664', 'Almi123'],
            ['Fernando', 'Sanchez', 'user', true, ['ROLE_USER'], '999999393', 'Almi123'],
        ];
    }
}
