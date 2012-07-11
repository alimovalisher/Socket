<?php
namespace Aysheka\Socket\Exception\IO;
use Aysheka\Socket\Socket;
use Aysheka\Socket\Exception\IOException;

class ReadException extends IOException
{
    public function __construct(Socket $socket, $msg=null) {
      if (!$msg) $msg = "Can't read from socket";
      parent::__construct($socket, $msg);
    }
}
