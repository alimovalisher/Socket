<?php
namespace Aysheka\Socket\Exception\IO;
use Aysheka\Socket\Socket;
use Aysheka\Socket\Exception\IOException;

class WriteException extends IOException
{
    protected $sendData;

    public function __construct(Socket $socket, $sendData, $msg=null) {
      $this->sendData = $sendData;

      if (!$msg) $msg = "Can't write to socket";
      parent::__construct($socket, $msg);
    }
}
