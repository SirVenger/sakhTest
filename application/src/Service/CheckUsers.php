<?php
/**
 * Created by PhpStorm.
 * User: venger
 * Date: 27.01.19
 * Time: 13:31
 */

namespace App\Service;

class checkUsers
{
    public function checkUsers($users, int $id)
    {
        $result = [];
        foreach ($users as $user) {
            $roles = $user->getRoles();

            if ($user->getId() != $id && $roles[0] == 'ROLE_USER' ){
                $result[] = $user;
            }
        }
        return $result;
    }
}