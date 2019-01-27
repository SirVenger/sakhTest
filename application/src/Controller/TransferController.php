<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\TranserType;
use App\Service\CalculatePay;
use FOS\UserBundle\Doctrine\UserManager;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CheckUsers;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

/**
 * Class TransferController
 * @package App\Controller
 */
class TransferController extends AbstractController
{
    /**
     * @Route("/", name="transfer", methods={"GET"})
     */
    public function Index(CheckUsers $checkUsers): Response
    {

        //$userManager = $this->container->get('fos_user.user_manager');
        $user = $this->getUser();

        if ($user) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $result = $repository->findAll();
            $id = $user->getId();
            $users = $checkUsers->checkUsers($result, $id);

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

    /**
     * @param Request $request
     * @param User $user
     * @param CalculatePay $calculatePay
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     * @Route("/transfer_balance/{id}", name="pull_balance", methods="GET|POST")
     */
    public function actionTransfer(Request $request, User $user, CalculatePay $calculatePay )
    {
        $sendUser = $this->getUser();
        $maxBalance = $sendUser->getBalance();
        $form = $this->createForm(TranserType::class, null, [
            'maxBalance' => $maxBalance
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $message = $calculatePay->calculate($sendUser, $user, $data['balance']);

            // Create the logger
            $logger = new Logger('my_logger');
            // Now add some handlers

            $logger->pushHandler(new StreamHandler("../var/log/transfer.log", Logger::DEBUG));
            $logger->pushHandler(new FirePHPHandler());
            $logger->info($message);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transfer', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('transfer/edit.html.twig', [
            'user' => $user,
            'send_user'=> $sendUser,
            'form' => $form->createView(),
        ]);
    }


}
