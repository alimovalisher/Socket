<?php
namespace Aysheka\Socket\Exception;

class IOException extends SocketException
{
    public static function cantWriteToSocket()
    {
        return new self(sprintf('Failed: Cant write to socket: %s', self::getSocketError()));
    }

    public static function cantReadFromSocket()
    {
        return new self(sprintf('Failed: Cant read from socket: %s', self::getSocketError()));
    }
}
