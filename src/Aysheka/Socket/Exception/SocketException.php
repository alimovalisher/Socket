<?php
namespace Aysheka\Socket\Exception;

class SocketException extends \Exception
{
    public static function cantOpenSocket()
    {
        return new self('Cant open socket');
    }
}
