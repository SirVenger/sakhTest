<?php
/**
 * Created by PhpStorm.
 * User: venger
 * Date: 28.01.19
 * Time: 2:49
 */

namespace App\Service;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class TransferLog
{
    public function writeLog(string $message)
    {
        // Create the logger
        $logger = new Logger('my_logger');
        // Now add some handlers

        $logger->pushHandler(new StreamHandler("../var/log/transfer.log", Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        $logger->info($message);

    }
}