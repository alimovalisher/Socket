<?php
namespace Aysheka\Socket\Exception\Init;
use Aysheka\Socket\Socket;
use Aysheka\Socket\Exception\IOException;

class OpenException extends IOException
{
    public function __construct(Socket $socket, $msg=null) {
      if (!$msg) $msg = "Can't open socket";
      parent::__construct($socket, $msg);
    }
}
