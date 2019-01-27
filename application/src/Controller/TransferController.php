<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\TranserType;
use App\Service\CalculatePay;
use App\Service\TransferLog;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CheckUsers;


/**
 * Class TransferController
 * @package App\Controller
 */
class TransferController extends AbstractController
{
    /**
     * @param CheckUsers $checkUsers
     * @return Response
     * @Route("/", name="transfer", methods={"GET"})
     */
    public function actionIndex(CheckUsers $checkUsers): Response
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
     * @param TransferLog $transferLog
     * @return Response
     *
     * @Route("/transfer_balance/{id}", name="pull_balance", methods="GET|POST")
     */
    public function actionTransfer(Request $request, User $user, CalculatePay $calculatePay, TransferLog $transferLog ): Response
    {
        $sendUser = $this->getUser();
        $maxBalance = $sendUser->getBalance();
        $form = $this->createForm(TranserType::class, null, [
            'maxBalance' => $maxBalance
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            //Считает изменение баланса и возвращает сообщение
            $message = $calculatePay->calculate($sendUser, $user, $data['balance']);
            $transferLog->writeLog($message);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transfer', [
            ]);
        }

        return $this->render('transfer/edit.html.twig', [
            'user' => $user,
            'send_user'=> $sendUser,
            'form' => $form->createView(),
        ]);
    }


}
