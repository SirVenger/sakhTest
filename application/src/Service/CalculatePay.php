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
    /**
     * @param $userSender
     * @param $userAddressee
     * @param $balance
     * @return string
     */
    public function calculate(&$userSender, &$userAddressee, int $balance)
    {
        $userSender->setBalance($userSender->getBalance() - $balance);
        $userAddressee->setBalance($userAddressee->getBalance() + $balance);
        $message = $userSender->getUsername().'('.$userSender->getId().')'.
                    ' произвел перевод '. $userAddressee->getUsername().'('.$userAddressee->getId().')'.
                    ' на сумму : '.$balance;
        return $message;
    }

}