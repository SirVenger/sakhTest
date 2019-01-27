<?php
/**
 * Created by PhpStorm.
 * User: venger
 * Date: 27.01.19
 * Time: 16:08
 */

namespace App\Service;


class CalculatePay
{

    public function calculate(&$userSender, &$userAddressee, $balance)
    {
        $userSender->setBalance($userSender->getBalance() - $balance);
        $userAddressee->setBalance($userAddressee->getBalance() + $balance);
        $message = $userSender->getUsername(). 'transfer'. $userAddressee->getUsername().': '.$balance;
        return $message;
    }

}