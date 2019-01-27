<?php

namespace App\Controller;

use App\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

class TransferController extends AbstractController
{
    /**
     * @Route("/", name="transfer")
     */
    public function Index()
    {

        //$userManager = $this->container->get('fos_user.user_manager');
        $user = $this->getUser();

        if ($user) {

            $repository = $this->getDoctrine()->getRepository(User::class);

            $users = $repository->findAll();

            return $this->render('transfer/index.html.twig', [
                'controller_name' => 'TransferController',
                'user' => $user,
                'users' => $users,
            ]);
        }  else {
            return $this->render('transfer/index.html.twig', [
                'controller_name' => 'TransferController',
                'user' => null,
            ]);
        }
    }


}
