<?php

namespace Janssen\Rpc\Common\Logger;


class BlackHole extends \Psr\Log\AbstractLogger
{
    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
        var_dump($level, $message);
    }
}