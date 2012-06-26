<?php
namespace Aysheka\Socket\Exception;

class SocketException extends \Exception
{
    static function cantOpenSocket()
    {
        return new self(sprintf('Cant open socket: %s', self::getSocketError()));
    }


    static function cantConnectToSocket()
    {
        return new self(sprintf('Cant connect to socket: %s', self::getSocketError()));
    }

    static function failed()
    {
        return new self(sprintf('Failed: %s', self::getSocketError()));
    }

    static function cantBindToSocket()
    {
        return new self(sprintf('Cant bind to socket: %s', self::getSocketError()));
    }

    /**
     * @static
     * @return string
     */
    protected static function getSocketError()
    {
        return socket_strerror(socket_last_error());
    }
}
