<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserFixtures extends Fixture
{
    private $userManager;

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++){
            $user = $this->userManager->createUser();
            $user->setUsername('test'.$i);
            $user->setEmail('test'.$i.'@test.co');
            $user->setPlainPassword('test');
            $user->setEnabled(true);
            $user->setBalance(rand(100,3000));
            $this->userManager->updateUser($user,false);
        }
        $user = $this->userManager->createUser();
        $user->setUsername('test'.$i);
        $user->setEmail('test'.$i.'@test.co');
        $user->setPlainPassword('test');
        $user->setEnabled(true);
        $user->setRoles(['ROLE_ADMIN']);
        $this->userManager->updateUser($user,false);

        $manager->flush();
    }

    public function __construct(UserManagerInterface $manager)
    {
        $this->userManager = $manager;
    }
}
